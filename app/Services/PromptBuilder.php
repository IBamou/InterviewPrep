<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;

class PromptBuilder
{
    protected int $dedupQuestionCount = 15;

    protected function buildGenerateQuestionsSystemPrompt(bool $hasDomain = true): string
    {
        $generationInstruction = 'Generate exactly 5 mock interview questions.';

        $relevanceBlock = $hasDomain
            ? "First, check if the following concept is relevant to its parent domain. If it is NOT relevant, return: {\"error\": \"unrelated\", \"message\": \"The concept is not related to the domain.\"}\n\nIf it IS relevant, {$generationInstruction}"
            : $generationInstruction;

        $jsonTemplates = '{"questions": ["Question 1?", "Question 2?", "Question 3?", "Question 4?", "Question 5?"]}';

        if ($hasDomain) {
            $jsonTemplates = '{"error": "unrelated", "message": "..."}' . "\nOR\n" . $jsonTemplates;
        }

        return <<<PROMPT
You are a technical interview coach. Be simple, precise, and direct. No extra talking.

{$relevanceBlock}

Generate questions appropriate to the difficulty tier specified in the user prompt:
- Junior: Focus on definitions, basic concepts, "what is X", fundamental understanding
- Mid: Focus on comparisons, trade-offs, practical usage, "when to use X vs Y"
- Senior: Focus on system design, edge cases, deep internals, architecture decisions

Return ONLY a valid JSON object.
{$jsonTemplates}
PROMPT;
    }

    protected function buildGenerateQuestionsUserPrompt(Concept $concept, ?User $user = null): string
    {
        $hasDomain = (bool) $concept->domain;
        $domainContext = $hasDomain ? "Domain: {$concept->domain->name}" : '(No domain specified)';
        $domainDescription = ($hasDomain && $concept->domain->description) ? "\nDomain Description: {$concept->domain->description}" : '';

        $userContext = $this->buildUserContext($user);

        $dedupSection = $this->buildDedupSection($concept);

        $tier = $concept->getHighestUnlockedTier();

        $domainInstruction = $hasDomain
            ? " specifically within the context of the domain mentioned above"
            : '';

        $explanationBlock = trim($concept->explanation ?? '')
            ? $concept->explanation
            : '(No explanation written yet — generate questions based on the concept title alone)';

        return <<<PROMPT
{$userContext}{$domainContext}{$domainDescription}
Concept: {$concept->title}
Tier: {$tier}
Explanation:
{$explanationBlock}

Generate 5 interview questions at the {$tier} level that test understanding of this concept{$domainInstruction}.
{$dedupSection}
PROMPT;
    }

    public function buildGenerateQuestionsMessages(Concept $concept, ?User $user = null): array
    {
        $hasDomain = (bool) $concept->domain;

        return [
            ['role' => 'system', 'content' => $this->buildGenerateQuestionsSystemPrompt($hasDomain)],
            ['role' => 'user', 'content' => $this->buildGenerateQuestionsUserPrompt($concept, $user)],
        ];
    }

    protected function buildEvaluateAnswersSystemPrompt(): string
    {
        return <<<'PROMPT'
You are an interview coach evaluating candidate answers. Be simple, precise, and direct. No extra talking.

Rating scale:
- 0 = No answer provided (blank)
- 1 = Completely wrong or major misconceptions
- 2 = Partially correct but significant gaps
- 3 = Basic understanding, correct but lacks depth
- 4 = Strong answer with good detail
- 5 = Expert-level, comprehensive, covers edge cases

Adjust your expectations based on the difficulty tier specified in the user prompt:
- Junior: Basic understanding is sufficient for a good rating
- Mid: Expect practical knowledge and trade-off awareness
- Senior: Expect deep understanding, edge cases, and architectural thinking

For each question-answer pair below, provide:
1. A rating from 0 to 5 (integer)
2. Brief constructive feedback (1-2 sentences max)
3. A concise model answer (2-3 sentences max)

IMPORTANT: If the user's answer is empty or just whitespace, they don't know the answer. In this case:
- Give a rating of 0
- Use exactly this feedback: "No answer provided. Study the model answer below to learn this concept."
- Give a clear, concise model answer so the user can learn

Return ONLY valid JSON with this exact structure:
{"evaluations": [{"question_index": 0, "rating": 4, "feedback": "...", "model_answer": "..."}, ...]}
PROMPT;
    }

    protected function buildEvaluateAnswersUserPrompt(Concept $concept, array $answers): string
    {
        $questionsList = '';
        foreach ($answers as $i => $qa) {
            $n = $i + 1;
            $questionsList .= "Q{$n}: {$qa['question']}\nA{$n}: {$qa['answer']}\n\n";
        }

        $domainContext = $concept->domain ? "Domain: {$concept->domain->name}\n" : '';
        $domainDescription = ($concept->domain && $concept->domain->description) ? "Domain Description: {$concept->domain->description}\n" : '';

        $tier = $concept->getHighestUnlockedTier();

        return <<<PROMPT
{$domainContext}{$domainDescription}Concept: {$concept->title}
Difficulty Level: {$tier}

{$questionsList}
PROMPT;
    }

    public function buildEvaluateAnswersMessages(Concept $concept, array $answers): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildEvaluateAnswersSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildEvaluateAnswersUserPrompt($concept, $answers)],
        ];
    }

    protected function buildDedupSection(Concept $concept): string
    {
        if (!$concept->exists) {
            return '';
        }

        $existingQuestions = $concept->generatedQuestions()
            ->orderBy('id', 'desc')
            ->limit($this->dedupQuestionCount)
            ->pluck('question')
            ->toArray();

        if (empty($existingQuestions)) {
            return '';
        }

        $list = implode("\n", array_map(fn ($q) => "- {$q}", $existingQuestions));

        return "\n\nPreviously generated questions for this concept — DO NOT repeat or rephrase these:\n{$list}\n";
    }

    protected function buildUserContext(?User $user): string
    {
        if (!$user) {
            return '';
        }

        $parts = [];

        if ($user->status) {
            $parts[] = "User Status: {$user->status->label()}";
        }

        if ($user->specialization) {
            $parts[] = "Specialization: {$user->specialization->label()} Developer";
        }

        if ($user->experience_years) {
            $parts[] = "Experience: {$user->experience_years->label()}";
        }

        if ($user->tech_stack && is_array($user->tech_stack) && !empty($user->tech_stack)) {
            $techList = implode(', ', $user->tech_stack);
            $parts[] = "Tech Stack: {$techList}";
        }

        if ($user->interview_goal) {
            $parts[] = "Goal: {$user->interview_goal->label()}";
        }

        if (empty($parts)) {
            return '';
        }

        return "User Profile:\n" . implode("\n", $parts) . "\n\n";
    }

    protected function buildImproveDomainDescriptionSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert. Be simple, precise, and direct. No extra talking.

If a description is provided, rewrite it to be a solid, concise definition (1-2 sentences max). Focus on what the domain is and its core purpose. Do not add fluff, history, or unnecessary details.
If no description is provided, generate one from scratch based on the domain name.

Return ONLY a valid JSON object:
{"improved_description": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveDomainDescriptionUserPrompt(Domain $domain): string
    {
        $isEmpty = empty(trim($domain->description ?? ''));
        $current = $isEmpty ? '(No description provided — generate one from scratch)' : $domain->description;

        $instruction = $isEmpty
            ? "Generate a concise, solid definition (1-2 sentences max) for this domain based on its name."
            : "Rewrite this as a concise, solid definition (1-2 sentences max).";

        return <<<PROMPT
Domain: {$domain->name}
Current description:
{$current}

{$instruction}
PROMPT;
    }

    public function buildImproveDomainDescriptionMessages(Domain $domain): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildImproveDomainDescriptionSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveDomainDescriptionUserPrompt($domain)],
        ];
    }

    protected function buildImproveConceptExplanationSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert. Be simple, precise, and direct. No extra talking.

If an explanation is provided, rewrite it to be a solid, concise definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.
If no explanation is provided, generate one from scratch based on the concept title.

Return ONLY a valid JSON object:
{"improved_explanation": "Your improved text here"}
PROMPT;
    }

    protected function buildImproveConceptExplanationUserPrompt(Concept $concept): string
    {
        $isEmpty = empty(trim($concept->explanation ?? ''));
        $current = $isEmpty ? '(No explanation provided — generate one from scratch)' : $concept->explanation;

        $instruction = $isEmpty
            ? "Generate a concise, solid definition (2-3 short sentences max) for this concept. Cover what it is and why it matters for interviews."
            : "Rewrite this as a concise, solid definition (2-3 short sentences max).";

        return <<<PROMPT
Concept: {$concept->title}
Current explanation:
{$current}

{$instruction}
PROMPT;
    }

    public function buildImproveConceptExplanationMessages(Concept $concept): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildImproveConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveConceptExplanationUserPrompt($concept)],
        ];
    }

    protected function buildGenerateConceptExplanationSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert. Be simple, precise, and direct. No extra talking.

First, check if the concept title is a valid technical term related to the given domain. Be lenient with typos — attempt to interpret what the user meant (e.g., "type castng" → "Type Casting", "routng" → "Routing"). Only reject if the input is truly gibberish, random characters, or completely unrelated to the domain.

If rejected, return: {"error": "invalid", "message": "The concept title is not valid or not related to this domain."}

If valid, generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.

Return ONLY a valid JSON object. Either:
{"error": "invalid", "message": "..."}
OR
{"explanation": "Your explanation here"}
PROMPT;
    }

    protected function buildGenerateConceptExplanationUserPrompt(string $title, string $domainName): string
    {
        return <<<PROMPT
Domain: {$domainName}
Concept: {$title}

Generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews.
PROMPT;
    }

    public function buildGenerateConceptExplanationMessages(string $title, string $domainName): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildGenerateConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildGenerateConceptExplanationUserPrompt($title, $domainName)],
        ];
    }

    protected function buildVerifyConceptTitleSystemPrompt(): string
    {
        return <<<'PROMPT'
You are a technical education expert. Be simple, precise, and direct. No extra talking.

Check if the given concept title is a valid technical term related to the domain. Be lenient with typos — detect what the user likely meant.

Return ONLY a valid JSON object with one of these structures:
1. If valid and correctly spelled: {"valid": true}
2. If valid but has a typo: {"valid": false, "suggestion": "Corrected Title", "message": "Did you mean 'Corrected Title'?"}
3. If gibberish or unrelated: {"valid": false, "message": "This doesn't appear to be a valid technical concept for this domain."}
PROMPT;
    }

    protected function buildVerifyConceptTitleUserPrompt(string $title, string $domainName): string
    {
        return <<<PROMPT
Domain: {$domainName}
Concept title to verify: {$title}

Check if this is a valid technical concept for this domain. If there's a typo, suggest the correct spelling.
PROMPT;
    }

    public function buildVerifyConceptTitleMessages(string $title, string $domainName): array
    {
        return [
            ['role' => 'system', 'content' => $this->buildVerifyConceptTitleSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildVerifyConceptTitleUserPrompt($title, $domainName)],
        ];
    }
}
