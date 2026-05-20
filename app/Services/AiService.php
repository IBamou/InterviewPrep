<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;
use App\Services\Contracts\AiProvider;
use Illuminate\Http\Client\Pool;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AiService
{
    public function __construct(
        protected AiProvider $provider,
        protected PromptBuilder $promptBuilder,
    ) {}

    public function generateQuestions(Concept $concept, ?User $user = null): array
    {
        $messages = $this->promptBuilder->buildGenerateQuestionsMessages($concept, $user);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.generation'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI question generation failed: ' . $e->getMessage());
            throw $e;
        }

        if (isset($parsed['error']) && $parsed['error'] === 'unrelated') {
            return $parsed;
        }

        if (!isset($parsed['questions']) || !is_array($parsed['questions'])) {
            throw new \RuntimeException('Failed to parse questions from AI response.');
        }

        return $parsed['questions'];
    }

    public function evaluateAnswers(Concept $concept, array $answers): array
    {
        $messages = $this->promptBuilder->buildEvaluateAnswersMessages($concept, $answers);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.evaluation'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI answer evaluation failed: ' . $e->getMessage());
            throw $e;
        }

        if (!isset($parsed['evaluations']) || !is_array($parsed['evaluations'])) {
            throw new \RuntimeException('Failed to parse evaluations from AI response.');
        }

        return $parsed['evaluations'];
    }

    public function evaluateAnswersBatch(array $batches): array
    {
        $results = [];

        if (empty($batches)) {
            return $results;
        }

        $baseUrl = $this->provider->getConfig('base_url');
        $apiKey = $this->provider->getConfig('api_key');
        $model = $this->provider->getConfig('model');
        $timeout = $this->provider->getConfig('timeout');

        $responses = Http::pool(function (Pool $pool) use ($batches, $baseUrl, $apiKey, $model, $timeout) {
            $requests = [];

            foreach ($batches as $i => $batch) {
                $messages = $this->promptBuilder->buildEvaluateAnswersMessages(
                    $batch['concept'],
                    $batch['qa_pairs']
                );

                $requests[] = $pool
                    ->as("batch_{$i}")
                    ->baseUrl($baseUrl)
                    ->withToken($apiKey)
                    ->withHeaders(['Content-Type' => 'application/json', 'Accept' => 'application/json'])
                    ->timeout($timeout)
                    ->post('/chat/completions', [
                        'model' => $model,
                        'messages' => $messages,
                        'max_tokens' => config('ai.tokens.evaluation'),
                        'temperature' => config('ai.defaults.temperature'),
                        'response_format' => ['type' => 'json_object'],
                    ]);
            }

            return $requests;
        });

        foreach ($responses as $key => $response) {
            if ($response instanceof Response && !$response->failed()) {
                $content = $response->json('choices.0.message.content');

                if ($content) {
                    $parsed = json_decode($content, true);

                    if ($parsed && isset($parsed['evaluations'])) {
                        $batchIndex = (int) str_replace('batch_', '', $key);
                        $qaPairs = $batches[$batchIndex]['qa_pairs'] ?? [];

                        foreach ($parsed['evaluations'] as $eval) {
                            $idx = $eval['question_index'] ?? null;

                            if ($idx !== null && isset($qaPairs[$idx])) {
                                $results[$qaPairs[$idx]['question_id']] = $eval;
                            }
                        }
                    }
                }
            } else {
                Log::warning('AI batch evaluation failed for batch: ' . $key);
            }
        }

        return $results;
    }

    public function improveDomainDescription(Domain $domain): string
    {
        $messages = $this->promptBuilder->buildImproveDomainDescriptionMessages($domain);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.description'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI domain description improvement failed: ' . $e->getMessage());
            throw $e;
        }

        if (!isset($parsed['improved_description'])) {
            throw new \RuntimeException('Failed to parse improved description from AI response.');
        }

        return $parsed['improved_description'];
    }

    public function improveConceptExplanation(Concept $concept): string
    {
        $messages = $this->promptBuilder->buildImproveConceptExplanationMessages($concept);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.explanation'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI concept explanation improvement failed: ' . $e->getMessage());
            throw $e;
        }

        if (!isset($parsed['improved_explanation'])) {
            throw new \RuntimeException('Failed to parse improved explanation from AI response.');
        }

        return $parsed['improved_explanation'];
    }

    public function generateConceptExplanation(string $title, string $domainName): array
    {
        $messages = $this->promptBuilder->buildGenerateConceptExplanationMessages($title, $domainName);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.explanation'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI concept explanation generation failed: ' . $e->getMessage());
            throw $e;
        }

        if (isset($parsed['error']) && $parsed['error'] === 'invalid') {
            return $parsed;
        }

        if (!isset($parsed['explanation'])) {
            throw new \RuntimeException('Failed to parse explanation from AI response.');
        }

        return ['explanation' => $parsed['explanation']];
    }

    public function verifyConceptTitle(string $title, string $domainName): array
    {
        $messages = $this->promptBuilder->buildVerifyConceptTitleMessages($title, $domainName);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.verification'),
                'temperature' => config('ai.temperatures.verification'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI concept title verification failed: ' . $e->getMessage());
            throw $e;
        }

        if (!isset($parsed['valid'])) {
            throw new \RuntimeException('Failed to parse verification result from AI response.');
        }

        return $parsed;
    }

    public function generateQuizQuestions(Domain $domain, iterable $concepts, int $questionCount): array
    {
        $messages = $this->promptBuilder->buildQuizMessages($domain, $concepts, $questionCount);

        try {
            $parsed = $this->provider->chatJson($messages, [
                'max_tokens' => config('ai.tokens.generation'),
            ]);
        } catch (\Exception $e) {
            Log::warning('AI quiz question generation failed: ' . $e->getMessage());
            throw $e;
        }

        if (!isset($parsed['questions']) || !is_array($parsed['questions'])) {
            throw new \RuntimeException('Failed to parse quiz questions from AI response.');
        }

        return $parsed['questions'];
    }

    public function chat(string $userMessage, array $history = []): string
    {
        $messages = array_merge($history, [
            ['role' => 'user', 'content' => $userMessage],
        ]);

        return $this->provider->chat($messages);
    }

    public function chatWithSystem(
        string $systemPrompt,
        string $userMessage,
        array $history = [],
    ): string {
        $messages = array_merge(
            [['role' => 'system', 'content' => $systemPrompt]],
            $history,
            [['role' => 'user', 'content' => $userMessage]]
        );

        return $this->provider->chat($messages);
    }

    public function chatStream(string $userMessage, array $history = [])
    {
        $messages = array_merge($history, [
            ['role' => 'user', 'content' => $userMessage],
        ]);

        $baseUrl = $this->provider->getConfig('base_url');
        $apiKey = $this->provider->getConfig('api_key');
        $model = $this->provider->getConfig('model');

        return response()->stream(function () use ($messages, $baseUrl, $apiKey, $model) {
            try {
                $response = Http::baseUrl($baseUrl)
                    ->withToken($apiKey)
                    ->withOptions(['stream' => true])
                    ->post('/chat/completions', [
                        'model' => $model,
                        'messages' => $messages,
                        'stream' => true,
                    ]);

                if ($response->failed()) {
                    echo 'data: '.json_encode(['error' => 'AI provider request failed'])."\n\n";
                    echo "data: [DONE]\n\n";
                    ob_flush();
                    flush();
                    return;
                }

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
            } catch (\Exception $e) {
                echo 'data: '.json_encode(['error' => 'Stream error: '.$e->getMessage()])."\n\n";
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
        $baseUrl = $this->provider->getConfig('base_url');
        $apiKey = $this->provider->getConfig('api_key');

        $response = Http::baseUrl($baseUrl)
            ->withToken($apiKey)
            ->get('/models');

        if ($response->failed()) {
            throw new \RuntimeException('Failed to fetch models: ' . $response->body());
        }

        return $response->json('data');
    }
}
