<?php

namespace App\Services\Providers;

use App\Services\Contracts\AiProvider;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class OpenAiCompatibleProvider implements AiProvider
{
    protected string $apiKey;

    protected string $baseUrl;

    protected string $model;

    protected array $defaults;

    public function __construct()
    {
        $this->apiKey = config('ai.providers.openai.api_key');
        $this->baseUrl = config('ai.providers.openai.base_url');
        $this->model = config('ai.providers.openai.model');
        $this->defaults = config('ai.defaults');
    }

    public function chat(array $messages, array $options = []): string
    {
        $response = $this->postJson('/chat/completions', array_merge([
            'model' => $options['model'] ?? $this->model,
            'messages' => $messages,
            'max_tokens' => $options['max_tokens'] ?? $this->defaults['max_tokens'],
            'temperature' => $options['temperature'] ?? $this->defaults['temperature'],
        ], $options['extra'] ?? []));

        $content = $response->json('choices.0.message.content');

        if (!$content) {
            throw new \RuntimeException('Empty response content from AI provider.');
        }

        return $content;
    }

    public function chatJson(array $messages, array $options = []): array
    {
        $response = $this->postJson('/chat/completions', array_merge([
            'model' => $options['model'] ?? $this->model,
            'messages' => $messages,
            'max_tokens' => $options['max_tokens'] ?? $this->defaults['max_tokens'],
            'temperature' => $options['temperature'] ?? $this->defaults['temperature'],
            'response_format' => ['type' => 'json_object'],
        ], $options['extra'] ?? []));

        $content = $response->json('choices.0.message.content');

        if (!$content) {
            throw new \RuntimeException('Empty response from AI provider.');
        }

        $parsed = json_decode($content, true);

        if (!is_array($parsed)) {
            throw new \RuntimeException('Failed to parse JSON from AI provider response.');
        }

        return $parsed;
    }

    public function getConfig(string $key): mixed
    {
        return match ($key) {
            'base_url' => $this->baseUrl,
            'api_key' => $this->apiKey,
            'model' => $this->model,
            'timeout' => $this->defaults['timeout'],
            default => null,
        };
    }

    protected function client()
    {
        return Http::baseUrl($this->baseUrl)
            ->withToken($this->apiKey)
            ->withHeaders([
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
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
            throw new \RuntimeException('AI provider request failed: ' . $e->getMessage());
        }
    }

    protected function handleError(Response $response): void
    {
        $body = $response->json();
        $message = $body['error']['message'] ?? 'Unknown error';
        $type = $body['error']['type'] ?? 'unknown';

        throw new \RuntimeException(
            "AI Provider Error [{$response->status()}] ({$type}): {$message}"
        );
    }
}
