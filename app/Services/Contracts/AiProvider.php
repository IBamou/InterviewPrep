<?php

namespace App\Services\Contracts;

interface AiProvider
{
    public function chat(array $messages, array $options = []): string;

    public function chatJson(array $messages, array $options = []): array;

    public function getConfig(string $key): mixed;
}
