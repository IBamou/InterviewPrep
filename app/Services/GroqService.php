<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GroqService
{
    protected string $apiKey;

    protected string $baseUrl;

    protected string $defaultModel;

    protected array $defaults;

    protected PromptBuilder $promptBuilder;

    public function __construct(PromptBuilder $promptBuilder)
    {
        $this->apiKey = config('groq.api_key');
        $this->baseUrl = config('groq.base_url');
        $this->defaultModel = config('groq.model');
        $this->defaults = config('groq.defaults');
        $this->promptBuilder = $promptBuilder;
    }

    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
            ])
            ->timeout($this->defaults['timeout']);
    }

    public function chat(
        string $userMessage,
        array $history = [],
        ?string $model = null
    ): string {
        $messages = array_merge($history, [
            ['role' => 'user', 'content' => $userMessage],
        ]);

        $response = $this->client()->post('/chat/completions', [
            'model' => $model ?? $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => $this->defaults['max_tokens'],
            'temperature' => $this->defaults['temperature'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        return $response->json('choices.0.message.content');
    }

    public function chatWithSystem(
        string $systemPrompt,
        string $userMessage,
        array $history = [],
        ?string $model = null
    ): string {
        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $history,
            [['role' => 'user', 'content' => $userMessage]]
        );

        $response = $this->client()->post('/chat/completions', [
            'model' => $model ?? $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => $this->defaults['max_tokens'],
            'temperature' => $this->defaults['temperature'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        return $response->json('choices.0.message.content');
    }

    public function chatStream(
        string $userMessage,
        array $history = [],
        ?string $model = null
    ) {
        $messages = array_merge($history, [
            ['role' => 'user', 'content' => $userMessage],
        ]);

        return response()->stream(function () use ($messages, $model) {
            $response = $this->client()
                ->withOptions(['stream' => true])
                ->post('/chat/completions', [
                    'model' => $model ?? $this->defaultModel,
                    'messages' => $messages,
                    'stream' => true,
                ]);

            foreach ($response->toPsrResponse()->getBody() as $chunk) {
                $lines = explode("\n", $chunk);

                foreach ($lines as $line) {
                    $line = trim($line);

                    if (empty($line) || $line === 'data: [DONE]') {
                        continue;
                    }

                    $jsonStr = str_replace('data: ', '', $line);
                    $data = json_decode($jsonStr, true);
                    $content = $data['choices'][0]['delta']['content'] ?? '';

                    if ($content) {
                        echo 'data: '.json_encode(['content' => $content])."\n\n";
                        ob_flush();
                        flush();
                    }
                }
            }

            echo "data: [DONE]\n\n";
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
        ]);
    }

    public function models(): array
    {
        $response = $this->client()->get('/models');

        if ($response->failed()) {
            $this->handleError($response);
        }

        return $response->json('data');
    }

    public function generateQuestions(Concept $concept, ?User $user = null): array
    {
        $messages = $this->promptBuilder->buildGenerateQuestionsMessages($concept, $user);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => $this->defaults['max_tokens'],
            'temperature' => $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);

        $questions = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$questions) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($questions, true);
        if (!is_array($parsed)) {
            throw new \RuntimeException('Failed to parse questions from Groq response.');
        }

        if (isset($parsed['error']) && $parsed['error'] === 'unrelated') {
            return $parsed;
        }

        if (!isset($parsed['questions']) || !is_array($parsed['questions'])) {
            throw new \RuntimeException('Failed to parse questions from Groq response.');
        }

        return $parsed['questions'];
    }

    public function evaluateAnswers(Concept $concept, array $answers): array
    {
        $messages = $this->promptBuilder->buildEvaluateAnswersMessages($concept, $answers);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => $this->defaults['max_tokens'] * 2,
            'temperature' => $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);
        $content = $decoded['choices'][0]['message']['content'] ?? null;

        if (!$content) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($content, true);
        if (!is_array($parsed) || !isset($parsed['evaluations']) || !is_array($parsed['evaluations'])) {
            throw new \RuntimeException('Failed to parse evaluations from Groq response.');
        }

        return $parsed['evaluations'];
    }

    public function improveDomainDescription(Domain $domain): string
    {
        $messages = $this->promptBuilder->buildImproveDomainDescriptionMessages($domain);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => 300,
            'temperature' => $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($content, true);
        if (!is_array($parsed) || !isset($parsed['improved_description'])) {
            throw new \RuntimeException('Failed to parse improved description from Groq response.');
        }

        return $parsed['improved_description'];
    }

    public function improveConceptExplanation(Concept $concept): string
    {
        $messages = $this->promptBuilder->buildImproveConceptExplanationMessages($concept);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => 500,
            'temperature' => $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($content, true);
        if (!is_array($parsed) || !isset($parsed['improved_explanation'])) {
            throw new \RuntimeException('Failed to parse improved explanation from Groq response.');
        }

        return $parsed['improved_explanation'];
    }

    public function generateConceptExplanation(string $title, string $domainName): array
    {
        $messages = $this->promptBuilder->buildGenerateConceptExplanationMessages($title, $domainName);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => 500,
            'temperature' => $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($content, true);
        if (!is_array($parsed)) {
            throw new \RuntimeException('Failed to parse explanation from Groq response.');
        }

        if (isset($parsed['error']) && $parsed['error'] === 'invalid') {
            return $parsed;
        }

        if (!isset($parsed['explanation'])) {
            throw new \RuntimeException('Failed to parse explanation from Groq response.');
        }

        return ['explanation' => $parsed['explanation']];
    }

    public function verifyConceptTitle(string $title, string $domainName): array
    {
        $messages = $this->promptBuilder->buildVerifyConceptTitleMessages($title, $domainName);

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => $messages,
            'max_tokens' => 100,
            'temperature' => 0.2,
            'response_format' => ['type' => 'json_object'],
        ]);

        if ($response->failed()) {
            $this->handleError($response);
        }

        $body = $response->body();
        $decoded = json_decode($body, true);

        $content = $decoded['choices'][0]['message']['content'] ?? null;
        if (!$content) {
            throw new \RuntimeException('Groq returned an empty response.');
        }

        $parsed = json_decode($content, true);
        if (!is_array($parsed) || !isset($parsed['valid'])) {
            throw new \RuntimeException('Failed to parse verification result from Groq response.');
        }

        return $parsed;
    }

    protected function handleError(Response $response): void
    {
        $body = $response->json();
        $message = $body['error']['message'] ?? 'Unknown error';
        $type = $body['error']['type'] ?? 'unknown';

        throw new \RuntimeException(
            "Groq API Error [{$response->status()}] ({$type}): {$message}"
        );
    }
}
