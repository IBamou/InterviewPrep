@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">
                Concepts - {{ $domain->name }}
            </h1>
            <a href="{{ route('domains.show', $domain) }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                &larr; Back to {{ $domain->name }}
            </a>
        </div>
        <div class="flex gap-3">
            <a href="{{ route('concepts.archives', $domain) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                Archives
            </a>
            <a href="{{ route('concepts.create', $domain) }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Add Concept
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-sm rounded-lg mb-6">
        <div class="p-4 border-b">
            <form method="GET" class="flex gap-4 items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All</option>
                        <option value="to_review" {{ request('status') === 'to_review' ? 'selected' : '' }}>To Review</option>
                        <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="mastered" {{ request('status') === 'mastered' ? 'selected' : '' }}>Mastered</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Difficulty</label>
                    <select name="difficulty" class="rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        <option value="">All</option>
                        <option value="junior" {{ request('difficulty') === 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="mid" {{ request('difficulty') === 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="senior" {{ request('difficulty') === 'senior' ? 'selected' : '' }}>Senior</option>
                    </select>
                </div>
                <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-700">
                    Filter
                </button>
                @if(request('status') || request('difficulty'))
                    <a href="{{ route('concepts.index', $domain) }}" class="px-4 py-2 text-gray-600 hover:text-gray-900">
                        Clear
                    </a>
                @endif
            </form>
        </div>
    </div>

    @if ($concepts->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <p class="text-gray-500">No concepts found. Create your first concept to start learning!</p>
            <a href="{{ route('concepts.create', $domain) }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Create Concept
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($concepts as $concept)
                <x-concept-card :concept="$concept" />
            @endforeach
        </div>
    @endif
</div>
@endsection