<?php

namespace App\Services\Providers;

use App\Services\Contracts\AiProvider;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class AnthropicProvider implements AiProvider
{
    protected string $apiKey;

    protected string $model;

    protected array $defaults;

    public function __construct()
    {
        $this->apiKey = config('ai.providers.anthropic.api_key');
        $this->model = config('ai.providers.anthropic.model');
        $this->defaults = config('ai.defaults');
    }

    public function chat(array $messages, array $options = []): string
    {
        $anthropicMessages = $this->convertMessages($messages);

        $response = $this->postJson('/messages', array_merge([
            'model' => $options['model'] ?? $this->model,
            'messages' => $anthropicMessages,
            'max_tokens' => $options['max_tokens'] ?? $this->defaults['max_tokens'],
            'temperature' => $options['temperature'] ?? $this->defaults['temperature'],
        ], $options['extra'] ?? []));

        return $response->json('content.0.text');
    }

    public function chatJson(array $messages, array $options = []): array
    {
        $systemPrompt = '';
        $converted = [];

        foreach ($messages as $msg) {
            if ($msg['role'] === 'system') {
                $systemPrompt .= $msg['content'] . "\n";
            } else {
                $converted[] = $msg;
            }
        }

        $systemPrompt .= "\nReturn ONLY a valid JSON object. No markdown, no code fences, no explanation.";

        $anthropicMessages = $this->convertMessages($converted);

        $body = [
            'model' => $options['model'] ?? $this->model,
            'messages' => $anthropicMessages,
            'max_tokens' => $options['max_tokens'] ?? $this->defaults['max_tokens'],
            'temperature' => $options['temperature'] ?? $this->defaults['temperature'],
        ];

        if ($systemPrompt) {
            $body['system'] = $systemPrompt;
        }

        $response = $this->postJson('/messages', $body);

        $content = $response->json('content.0.text');

        if (!$content) {
            throw new \RuntimeException('Empty response from Anthropic.');
        }

        $parsed = json_decode($content, true);

        if (!is_array($parsed)) {
            throw new \RuntimeException('Failed to parse JSON from Anthropic response.');
        }

        return $parsed;
    }

    public function getConfig(string $key): mixed
    {
        return match ($key) {
            'base_url' => 'https://api.anthropic.com/v1',
            'api_key' => $this->apiKey,
            'model' => $this->model,
            'timeout' => $this->defaults['timeout'],
            default => null,
        };
    }

    protected function convertMessages(array $messages): array
    {
        $converted = [];

        foreach ($messages as $msg) {
            if ($msg['role'] === 'system') {
                continue;
            }

            $converted[] = [
                'role' => $msg['role'],
                'content' => $msg['content'],
            ];
        }

        return $converted;
    }

    protected function client()
    {
        return Http::baseUrl('https://api.anthropic.com/v1')
            ->withToken($this->apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'anthropic-version' => '2023-06-01',
            ])
            ->timeout($this->defaults['timeout'])
            ->retry(2, 1000);
    }

    protected function postJson(string $url, array $data): Response
    {
        try {
            $response = $this->client()->post($url, $data);

            if ($response->failed()) {
                $this->handleError($response);
            }

            return $response;
        } catch (\Exception $e) {
            if ($e instanceof \RuntimeException) {
                throw $e;
            }
            throw new \RuntimeException('Anthropic API request failed: ' . $e->getMessage());
        }
    }

    protected function handleError(Response $response): void
    {
        $body = $response->json();
        $message = $body['error']['message'] ?? 'Unknown error';
        $type = $body['error']['type'] ?? 'unknown';

        throw new \RuntimeException(
            "Anthropic API Error [{$response->status()}] ({$type}): {$message}"
        );
    }
}
