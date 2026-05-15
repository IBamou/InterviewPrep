<?php

// app/Services/GroqService.php

namespace App\Services;

use App\Models\Concept;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class GroqService
{
    protected string $apiKey;

    protected string $baseUrl;

    protected string $defaultModel;

    protected array $defaults;

    public function __construct()
    {
        $this->apiKey = config('groq.api_key');
        $this->baseUrl = config('groq.base_url');
        $this->defaultModel = config('groq.model');
        $this->defaults = config('groq.defaults');
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

    public function generateQuestions(Concept $concept): array
    {
        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "\nDomain Description: {$concept->domain->description}" : '';

        $prompt = <<<PROMPT
You are a technical interview coach. First, check if the following concept is relevant to its parent domain. If it is NOT relevant, return: {"error": "unrelated", "message": "The concept is not related to the domain."}

If it IS relevant, generate exactly 5 mock interview questions.

{$domainContext}{$domainDescription}
Concept: {$concept->title}
Difficulty Level: {$concept->difficulty->value}
Explanation:
{$concept->explanation}

If relevant, generate 5 interview questions that test understanding of this concept at the {$concept->difficulty->value} level, specifically within the context of the domain mentioned above.

Return ONLY a valid JSON object. Either:
{"error": "unrelated", "message": "..."}
OR
{"questions": ["Question 1?", "Question 2?", "Question 3?", "Question 4?", "Question 5?"]}
PROMPT;

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a JSON-only assistant. Always respond with valid JSON.'],
                ['role' => 'user', 'content' => $prompt],
            ],
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
        $questionsList = '';
        foreach ($answers as $i => $qa) {
            $n = $i + 1;
            $questionsList .= "Q{$n}: {$qa['question']}\nA{$n}: {$qa['answer']}\n\n";
        }

        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}\n" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "Domain Description: {$concept->domain->description}\n" : '';

        $prompt = <<<PROMPT
You are an interview coach evaluating candidate answers for a technical concept.

{$domainContext}{$domainDescription}Concept: {$concept->title}
Difficulty: {$concept->difficulty->value}

For each question-answer pair below, provide:
1. A rating from 1 to 5 (integer)
2. Brief constructive feedback
3. A model answer that would score 5/5

Return ONLY valid JSON with this exact structure:
{"evaluations": [{"question_index": 0, "rating": 4, "feedback": "...", "model_answer": "..."}, ...]}

{$questionsList}
PROMPT;

        $response = $this->client()->post('/chat/completions', [
            'model' => $this->defaultModel,
            'messages' => [
                ['role' => 'system', 'content' => 'You are a JSON-only assistant. Always respond with valid JSON.'],
                ['role' => 'user', 'content' => $prompt],
            ],
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
