<?php

namespace App\Services\Prompts\Concerns;

trait HasTierGuide
{
    protected function tierGuide(): string
    {
        return implode("\n", [
            'Generate questions appropriate to the difficulty tier specified:',
            '- Junior: Definitions, fundamental understanding, "what is X and how does it work". Expect straightforward answers.',
            '- Mid: Comparisons, trade-offs, practical usage, "when to use X vs Y", implementation choices. Expect reasoned answers.',
            '- Senior: System design, edge cases, deep internals, architecture decisions, debugging complex scenarios. Expect thorough answers.',
        ]);
    }

    protected function tierEvaluationGuide(): string
    {
        return implode("\n", [
            'Adjust your expectations based on the difficulty tier:',
            '- Junior: Basic understanding is sufficient for a good rating',
            '- Mid: Expect practical knowledge and trade-off awareness',
            '- Senior: Expect deep understanding, edge cases, and architectural thinking',
        ]);
    }
}
