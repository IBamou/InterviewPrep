@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('concepts.index', $concept->domain) }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Back to Concepts
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $concept->title }}</h1>
                    <div class="flex gap-2 mt-2">
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($concept->difficulty->value === 'junior') bg-blue-100 text-blue-800
                            @elseif($concept->difficulty->value === 'mid') bg-yellow-100 text-yellow-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ $concept->difficulty->label() }}
                        </span>
                        <span class="px-2 py-1 text-xs rounded-full
                            @if($concept->status->value === 'mastered') bg-green-100 text-green-800
                            @elseif($concept->status->value === 'in_progress') bg-yellow-100 text-yellow-800
                            @else bg-gray-100 text-gray-800 @endif">
                            {{ $concept->status->label() }}
                        </span>
                    </div>
                </div>
                <a href="{{ route('concepts.edit', $concept) }}" class="px-4 py-2 bg-gray-200 text-gray-700 rounded-md hover:bg-gray-300">
                    Edit
                </a>
            </div>
        </div>

        <div class="p-6">
            <h2 class="text-lg font-semibold mb-3">Explanation</h2>
            <div class="prose max-w-none text-gray-700">
                {{ $concept->explanation }}
            </div>
        </div>

        <div class="p-6 border-t border-gray-100">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Generated Interview Questions</h2>
                <button type="button" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700" disabled>
                    Generate Questions (Coming Soon)
                </button>
            </div>
            <div class="bg-gray-50 rounded-lg p-4 text-center text-gray-500">
                <p>No questions generated yet.</p>
                <p class="text-sm mt-1">This feature will use the Groq API to generate 5 realistic interview questions based on this concept.</p>
            </div>
        </div>
    </div>
</div>
@endsection