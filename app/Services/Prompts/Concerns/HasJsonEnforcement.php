<?php

namespace App\Services\Prompts\Concerns;

trait HasJsonEnforcement
{
    protected function enforceJson(string $content, ?string $template = null): string
    {
        $prompt = $content . "\n\nRespond ONLY with valid JSON. Do NOT wrap it in markdown code fences (```) or any other formatting. Do NOT include any text before or after the JSON. The response must be pure, parseable JSON.";

        if ($template !== null) {
            $prompt .= "\n\nExpected JSON structure:\n" . $template;
        }

        return $prompt;
    }

    protected function jsonTemplate(string $structure): string
    {
        return $structure;
    }
}
