<x-app-layout activeNav="quizzes" title="Quiz History">
    <x-slot:topbar-actions>
        <a href="{{ route('quizzes.create') }}" class="px-3 py-1.5 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all">+ New Quiz</a>
    </x-slot:topbar-actions>

    <nav class="flex items-center gap-1.5 text-[12px] text-on-surface-variant/60 mb-4">
        <a class="hover:text-primary transition-colors" href="{{ route('quizzes.create') }}">Quizzes</a>
        <span class="material-symbols-outlined text-[14px]">chevron_right</span>
        <span class="text-on-surface font-medium">History</span>
    </nav>

    <div class="mb-6">
        <h2 class="font-display-lg text-display-lg text-on-surface">Quiz History</h2>
        <p class="font-body-md text-body-md text-on-surface-variant mt-0.5">Review your past quiz attempts and results.</p>
    </div>

    <div class="mb-4">
        <form method="GET" action="{{ route('quizzes.history') }}">
            <div class="flex items-center gap-2">
                <select name="status" onchange="this.form.submit()" class="rounded-lg border border-outline-variant/60 text-[13px] px-3 py-1.5 focus:border-primary focus:ring-2 focus:ring-primary/15 outline-none">
                    <option value="">All</option>
                    <option value="{{ \App\Enums\QuizStatus::InProgress->value }}" {{ request('status') === \App\Enums\QuizStatus::InProgress->value ? 'selected' : '' }}>In Progress</option>
                    <option value="{{ \App\Enums\QuizStatus::Submitted->value }}" {{ request('status') === \App\Enums\QuizStatus::Submitted->value ? 'selected' : '' }}>Submitted</option>
                </select>
            </div>
        </form>
    </div>

    @if ($quizzes->isEmpty())
    <div class="bg-white border border-outline-variant/50 rounded-xl p-8 text-center">
        <span class="material-symbols-outlined text-on-surface-variant/30 text-[48px] mb-3">history</span>
        <h3 class="text-[16px] font-semibold text-on-surface mb-1">No quizzes found</h3>
        <p class="text-[13px] text-on-surface-variant/60 mb-4">Take your first quiz to see results here.</p>
        <a href="{{ route('quizzes.create') }}" class="px-4 py-2 bg-primary text-white rounded-lg text-[13px] font-medium hover:bg-primary/90 transition-all inline-flex items-center gap-1.5">
            <span class="material-symbols-outlined text-[16px]">add</span>
            Start a Quiz
        </a>
    </div>
    @else
    <div class="space-y-2">
        @foreach ($quizzes as $q)
        <div class="bg-white border border-outline-variant/50 rounded-xl p-4 hover:border-primary/30 transition-all">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-primary/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-primary text-[20px]" style="font-variation-settings: 'FILL' 1;">quiz</span>
                    </div>
                    <div>
                        <h3 class="text-[14px] font-semibold text-on-surface">{{ $q->domain->name }}</h3>
                        <div class="flex items-center gap-2 text-[11px] text-on-surface-variant/60 mt-0.5">
                            <span>{{ $q->created_at->format('M j, Y g:i A') }}</span>
                            <span>&middot;</span>
                            <span>{{ $q->questions_count }} questions</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    @if ($q->status === 'submitted' && $q->max_score > 0)
                    @php $pct = round(($q->total_score / $q->max_score) * 100); @endphp
                    <div class="text-right">
                        <span class="text-[16px] font-bold {{ $pct >= 70 ? 'text-secondary' : ($pct >= 40 ? 'text-amber-600' : 'text-error') }}">{{ $pct }}%</span>
                        <span class="text-[11px] text-on-surface-variant/50 block">{{ $q->total_score }}/{{ $q->max_score }}</span>
                    </div>
                    @else
                    <span class="px-2 py-0.5 rounded text-[11px] font-medium bg-amber-50 text-amber-600">In Progress</span>
                    @endif
                    @if ($q->status === 'in_progress')
                    <a href="{{ route('quizzes.active', ['domain' => $q->domain_id, 'quiz' => $q]) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all">
                        Continue
                    </a>
                    @else
                    <a href="{{ route('quizzes.results', $q) }}" class="px-3 py-1.5 border border-outline-variant text-on-surface-variant rounded-lg text-[12px] font-medium hover:bg-surface-container transition-all">
                        View
                    </a>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-4">
        {{ $quizzes->links() }}
    </div>
    @endif
</x-app-layout>
