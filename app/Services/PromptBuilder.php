<?php

namespace App\Services;

use App\Models\Concept;
use App\Models\Domain;
use App\Models\User;
use App\Services\Prompts\Concerns\HasJsonEnforcement;
use App\Services\Prompts\Concerns\HasPersonas;
use App\Services\Prompts\Concerns\HasTierGuide;
use Illuminate\Support\Facades\Log;

class PromptBuilder
{
    use HasPersonas;
    use HasJsonEnforcement;
    use HasTierGuide;

    const VERSION_GENERATE_QUESTIONS = '1.1.0';
    const VERSION_EVALUATE_ANSWERS = '1.1.0';
    const VERSION_IMPROVE_DESCRIPTION = '1.1.0';
    const VERSION_IMPROVE_EXPLANATION = '1.1.0';
    const VERSION_GENERATE_EXPLANATION = '1.1.0';
    const VERSION_VERIFY_TITLE = '1.0.0';
    const VERSION_QUIZ = '1.1.0';

    protected int $dedupQuestionCount = 15;

    protected function logPrompt(string $type, string $version, array $context = []): void
    {
        Log::debug("PromptBuilder: {$type}", array_merge(
            ['version' => $version],
            $context
        ));
    }

    protected function buildGenerateQuestionsSystemPrompt(bool $hasDomain): string
    {
        $formatGuide = implode("\n", [
            'Vary the question formats across the 5 questions. Draw from these categories:',
            '- Conceptual: Tests core understanding of what something is and why it matters',
            '- Comparative: Tests awareness of alternatives, trade-offs, and when to use each',
            '- Practical: Tests ability to apply knowledge to real-world scenarios or implementation',
            '- Scenario: Tests debugging, troubleshooting, or working through a problem step by step',
            '- Depth: Tests knowledge of internals, edge cases, or advanced behavior under the hood',
        ]);

        $tierDistribution = implode("\n", [
            'Distribute question types based on the difficulty tier:',
            '- Junior: Mostly conceptual and practical. Few depth or comparative questions.',
            '- Mid: Balanced mix across all categories. Emphasize comparative and practical.',
            '- Senior: Heavy on depth, scenario, and practical. Minimal purely conceptual questions.',
        ]);

        $qualityRules = implode("\n", [
            'Quality guidelines:',
            '- Each question must be self-contained — the candidate should understand it without extra context.',
            '- Be specific. Prefer concrete examples over vague prompts.',
            '- Mirror real technical interviews. No trick questions, trivia, gotchas, or puzzles.',
            '- Questions should assess genuine understanding, not memorization of facts.',
            '- Cover different aspects of the concept. Do not ask the same thing in five different ways.',
            '- Use plain English. No markdown, no formatting inside questions.',
        ]);

        $generationInstruction = "Generate exactly 5 mock interview questions.\n\n{$formatGuide}\n\n{$tierDistribution}\n\n{$qualityRules}";

        $relevanceBlock = $hasDomain
            ? "First, check if the following concept is relevant to its parent domain ONLY. When checking relevance, ignore the user's profile — relevance is purely about whether the concept belongs under the given domain. If it is NOT relevant to the domain, return: {\"error\": \"unrelated\", \"message\": \"The concept is not related to the domain.\"}\n\nIf it IS relevant, use the user's profile (status, specialization, experience, tech stack, and goals) provided in the message below to tailor the questions to their background, then {$generationInstruction}"
            : $generationInstruction;

        $jsonTemplates = $this->jsonTemplate('{"questions": ["Question 1?", "Question 2?", "Question 3?", "Question 4?", "Question 5?"]}');

        if ($hasDomain) {
            $jsonTemplates = '{"error": "unrelated", "message": "..."}' . "\nOR\n" . $jsonTemplates;
        }

        return $this->enforceJson(
            $this->personaInterviewCoach() . "\n\n" .
            $relevanceBlock . "\n\n" .
            $this->tierGuide(),
            $jsonTemplates
        );
    }

    protected function buildGenerateQuestionsUserPrompt(Concept $concept, ?User $user = null): string
    {
        $hasDomain = $concept->relationLoaded('domain') ? (bool) $concept->domain : $concept->domain_id !== null;
        $domainContext = $hasDomain ? "Domain: {$concept->domain->name}" : '(No domain specified)';
        $domainDescription = ($hasDomain && $concept->domain->description) ? "\nDomain Description: {$concept->domain->description}" : '';

        $userContext = $this->buildUserContext($user);

        $dedupSection = $this->buildDedupSection($concept);

        $tier = $concept->getHighestUnlockedTier();

        $domainContextLine = $hasDomain
            ? " in the context of {$concept->domain->name}"
            : '';

        $parts = [
            "{$userContext}{$domainContext}{$domainDescription}",
            "Concept: {$concept->title}",
            "Tier: {$tier}",
        ];

        if (trim($concept->explanation ?? '')) {
            $parts[] = 'Explanation:';
            $parts[] = $concept->explanation;
        } else {
            $parts[] = 'Note: No explanation has been written for this concept yet. Generate questions based on the concept title and tier alone.';
        }

        $parts[] = '';
        $parts[] = "Generate 5 interview questions at the {$tier} level that test understanding of this concept{$domainContextLine}. Cover different aspects — avoid asking about the same sub-topic multiple times.";
        $parts[] = $dedupSection;

        return implode("\n", $parts);
    }

    public function buildGenerateQuestionsMessages(Concept $concept, ?User $user = null): array
    {
        $this->logPrompt('generate_questions', self::VERSION_GENERATE_QUESTIONS, [
            'concept_id' => $concept->id,
            'domain_id' => $concept->domain_id,
            'tier' => $concept->getHighestUnlockedTier(),
        ]);

        $hasDomain = $concept->relationLoaded('domain') ? (bool) $concept->domain : $concept->domain_id !== null;

        return [
            ['role' => 'system', 'content' => $this->buildGenerateQuestionsSystemPrompt($hasDomain)],
            ['role' => 'user', 'content' => $this->buildGenerateQuestionsUserPrompt($concept, $user)],
        ];
    }

    protected function buildEvaluateAnswersSystemPrompt(): string
    {
        $ratingScale = implode("\n", [
            'Rating scale:',
            '- 0 = No answer provided (blank)',
            '- 1 = Completely wrong or major misconceptions',
            '- 2 = Partially correct but significant gaps',
            '- 3 = Basic understanding, correct but lacks depth',
            '- 4 = Strong answer with good detail',
            '- 5 = Expert-level, comprehensive, covers edge cases',
        ]);

        $blankAnswerRule = implode("\n", [
            'IMPORTANT: If the user\'s answer is empty or just whitespace, they don\'t know the answer. In this case:',
            '- Give a rating of 0',
            '- Use exactly this feedback: "No answer provided. Study the model answer below to learn this concept."',
            '- Give a clear, concise model answer so the user can learn',
        ]);

        return $this->enforceJson(
            $this->personaEvaluationCoach() . "\n\n" .
            $ratingScale . "\n\n" .
            $this->tierEvaluationGuide() . "\n\n" .
            'For each question-answer pair below, provide:' . "\n" .
            '1. A rating from 0 to 5 (integer)' . "\n" .
            '2. Brief constructive feedback (1-2 sentences max)' . "\n" .
            '3. A concise model answer (2-3 sentences max)' . "\n\n" .
            $blankAnswerRule,
            '{"evaluations": [{"question_index": 0, "rating": 4, "feedback": "...", "model_answer": "..."}, ...]}'
        );
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

        return "{$domainContext}{$domainDescription}Concept: {$concept->title}\nDifficulty Level: {$tier}\n\n{$questionsList}";
    }

    public function buildEvaluateAnswersMessages(Concept $concept, array $answers): array
    {
        $this->logPrompt('evaluate_answers', self::VERSION_EVALUATE_ANSWERS, [
            'concept_id' => $concept->id,
            'answer_count' => count($answers),
        ]);

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
        return $this->enforceJson(
            $this->personaEducationExpert() . "\n\n" .
            'If a description is provided, rewrite it to be a solid, concise definition (1-2 sentences max). Focus on what the domain is and its core purpose. Do not add fluff, history, or unnecessary details.' . "\n" .
            'If no description is provided, generate one from scratch based on the domain name.',
            '{"improved_description": "Your improved text here"}'
        );
    }

    protected function buildImproveDomainDescriptionUserPrompt(Domain $domain): string
    {
        $hasDescription = trim($domain->description ?? '');

        $parts = [
            "Domain: {$domain->name}",
        ];

        if ($hasDescription) {
            $parts[] = 'Current description:';
            $parts[] = $domain->description;
            $parts[] = '';
            $parts[] = "Rewrite this as a concise, solid definition (1-2 sentences max).";
        } else {
            $parts[] = '';
            $parts[] = "Generate a concise, solid definition (1-2 sentences max) for this domain based on its name.";
        }

        return implode("\n", $parts);
    }

    public function buildImproveDomainDescriptionMessages(Domain $domain): array
    {
        $this->logPrompt('improve_description', self::VERSION_IMPROVE_DESCRIPTION, [
            'domain_id' => $domain->id,
        ]);

        return [
            ['role' => 'system', 'content' => $this->buildImproveDomainDescriptionSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveDomainDescriptionUserPrompt($domain)],
        ];
    }

    protected function buildImproveConceptExplanationSystemPrompt(): string
    {
        return $this->enforceJson(
            $this->personaEducationExpert() . "\n\n" .
            'If an explanation is provided, rewrite it to be a solid, concise definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.' . "\n" .
            'If no explanation is provided, generate one from scratch based on the concept title.',
            '{"improved_explanation": "Your improved text here"}'
        );
    }

    protected function buildImproveConceptExplanationUserPrompt(Concept $concept): string
    {
        $domainName = $concept->domain?->name ?? 'General';
        $hasExplanation = trim($concept->explanation ?? '');

        $parts = [
            "Domain: {$domainName}",
            "Concept: {$concept->title}",
        ];

        if ($hasExplanation) {
            $parts[] = 'Current explanation:';
            $parts[] = $concept->explanation;
            $parts[] = '';
            $parts[] = "Rewrite this as a concise, solid definition (2-3 short sentences max).";
        } else {
            $parts[] = '';
            $parts[] = "Generate a concise, solid definition (2-3 short sentences max) for this concept in the context of {$domainName}. Cover what it is and why it matters for interviews.";
        }

        return implode("\n", $parts);
    }

    public function buildImproveConceptExplanationMessages(Concept $concept): array
    {
        $this->logPrompt('improve_explanation', self::VERSION_IMPROVE_EXPLANATION, [
            'concept_id' => $concept->id,
        ]);

        return [
            ['role' => 'system', 'content' => $this->buildImproveConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildImproveConceptExplanationUserPrompt($concept)],
        ];
    }

    protected function buildGenerateConceptExplanationSystemPrompt(): string
    {
        return $this->enforceJson(
            $this->personaEducationExpert() . "\n\n" .
            'First, check if the concept title is a valid technical term related to the given domain. Be lenient with typos — attempt to interpret what the user meant (e.g., "type castng" → "Type Casting", "routng" → "Routing"). Only reject if the input is truly gibberish, random characters, or completely unrelated to the domain.' . "\n\n" .
            'If rejected, return: {"error": "invalid", "message": "The concept title is not valid or not related to this domain."}' . "\n\n" .
            'If valid, generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews. Do not add long examples, history, or unnecessary details. Keep it tight and focused.',
            '{"error": "invalid", "message": "..."}' . "\nOR\n" . '{"explanation": "Your explanation here"}'
        );
    }

    protected function buildGenerateConceptExplanationUserPrompt(string $title, string $domainName): string
    {
        return implode("\n", [
            "Domain: {$domainName}",
            "Concept: {$title}",
            '',
            'Generate a concise, solid definition (2-3 short sentences max). Cover what it is and why it matters for interviews.',
        ]);
    }

    public function buildGenerateConceptExplanationMessages(string $title, string $domainName): array
    {
        $this->logPrompt('generate_explanation', self::VERSION_GENERATE_EXPLANATION, [
            'title' => $title,
            'domain' => $domainName,
        ]);

        return [
            ['role' => 'system', 'content' => $this->buildGenerateConceptExplanationSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildGenerateConceptExplanationUserPrompt($title, $domainName)],
        ];
    }

    protected function buildVerifyConceptTitleSystemPrompt(): string
    {
        return $this->enforceJson(
            $this->personaEducationExpert() . "\n\n" .
            'Check if the given concept title is a valid technical term related to the domain. Be lenient with typos — detect what the user likely meant.',
            '1. If valid and correctly spelled: {"valid": true}' . "\n" .
            '2. If valid but has a typo: {"valid": false, "suggestion": "Corrected Title", "message": "Did you mean \'Corrected Title\'?"}' . "\n" .
            '3. If gibberish or unrelated: {"valid": false, "message": "This doesn\'t appear to be a valid technical concept for this domain."}'
        );
    }

    protected function buildVerifyConceptTitleUserPrompt(string $title, string $domainName): string
    {
        return implode("\n", [
            "Domain: {$domainName}",
            "Concept title to verify: {$title}",
            '',
            'Check if this is a valid technical concept for this domain. If there\'s a typo, suggest the correct spelling.',
        ]);
    }

    public function buildVerifyConceptTitleMessages(string $title, string $domainName): array
    {
        $this->logPrompt('verify_title', self::VERSION_VERIFY_TITLE, [
            'title' => $title,
            'domain' => $domainName,
        ]);

        return [
            ['role' => 'system', 'content' => $this->buildVerifyConceptTitleSystemPrompt()],
            ['role' => 'user', 'content' => $this->buildVerifyConceptTitleUserPrompt($title, $domainName)],
        ];
    }

    protected function buildQuizSystemPrompt(int $questionCount): string
    {
        return $this->enforceJson(
            $this->personaInterviewCoach() . "\n\n" .
            "Generate {$questionCount} mock interview questions covering ALL the concepts listed below. Mix questions across concepts — don't ask about the same concept twice in a row." . "\n\n" .
            $this->tierGuide() . "\n\n" .
            'CRITICAL — DO NOT repeat or rephrase any questions listed in the "Previously generated questions" section. Every question must be new and unique.',
            '{"questions": [{"question": "What is X?", "concept": "Concept Name"}, ...]}'
        );
    }

    protected function buildQuizUserPrompt(Domain $domain, iterable $concepts, int $questionCount): string
    {
        $conceptList = '';
        foreach ($concepts as $i => $c) {
            $tier = $c->getHighestUnlockedTier();
            $conceptList .= ($i + 1) . ". {$c->title} [Tier: {$tier}]";
            if (trim($c->explanation ?? '')) {
                $conceptList .= " — {$c->explanation}";
            }
            $conceptList .= "\n";
        }

        $domainContext = "Domain: {$domain->name}\n";
        if ($domain->description) {
            $domainContext .= "Domain Description: {$domain->description}\n";
        }

        $dedupSection = $this->buildQuizDedupSection($concepts);

        return implode("\n", [
            $domainContext,
            'Concepts to cover:',
            $conceptList,
            '',
            "Generate {$questionCount} interview questions that test understanding of these concepts within the context of {$domain->name}. Mix the questions across concepts evenly. For each question, set the \"concept\" field to the EXACT concept title from the list above.",
            $dedupSection,
        ]);
    }

    protected function buildQuizDedupSection(iterable $concepts): string
    {
        $allQuestions = [];
        $limit = 10;

        foreach ($concepts as $concept) {
            $questions = $concept->generatedQuestions()
                ->orderBy('id', 'desc')
                ->limit($limit)
                ->pluck('question')
                ->toArray();
            $allQuestions = array_merge($allQuestions, $questions);
        }

        $allQuestions = array_unique($allQuestions);

        if (empty($allQuestions)) {
            return '';
        }

        $list = implode("\n", array_map(fn ($q) => "- {$q}", $allQuestions));

        return "\nPreviously generated questions — DO NOT repeat or rephrase these:\n{$list}\n";
    }

    public function buildQuizMessages(Domain $domain, iterable $concepts, int $questionCount): array
    {
        $concepts = collect($concepts);

        $this->logPrompt('quiz', self::VERSION_QUIZ, [
            'domain_id' => $domain->id,
            'question_count' => $questionCount,
            'concept_count' => $concepts->count(),
        ]);

        return [
            ['role' => 'system', 'content' => $this->buildQuizSystemPrompt($questionCount)],
            ['role' => 'user', 'content' => $this->buildQuizUserPrompt($domain, $concepts, $questionCount)],
        ];
    }
}
