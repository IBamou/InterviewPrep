@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('domains.index') }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Back to Domains
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg overflow-hidden">
        <div class="p-6 border-b border-gray-100">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <span class="px-3 py-1 rounded-full text-sm font-medium text-white" style="background-color: {{ $domain->color }}">
                        {{ $domain->name }}
                    </span>
                </div>
                <a href="{{ route('domains.edit', $domain) }}" class="text-gray-500 hover:text-gray-700">
                    Edit
                </a>
            </div>
            <div class="mt-4 text-sm text-gray-500">
                {{ $domain->concepts_count }} concepts total
            </div>
        </div>

        <div class="p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-medium">Concepts</h3>
                <a href="#" class="text-indigo-600 hover:text-indigo-900">Add Concept</a>
            </div>

            @if ($domain->concepts->isEmpty())
                <p class="text-gray-500 text-center py-4">No concepts yet.</p>
            @else
                <div class="space-y-3">
                    @foreach ($domain->concepts as $concept)
                        <div class="border rounded-lg p-4">
                            <div class="flex justify-between items-start">
                                <div>
                                    <h4 class="font-medium">{{ $concept->title }}</h4>
                                    <p class="text-sm text-gray-500 mt-1">{{ $concept->difficulty }}</p>
                                </div>
                                <span class="px-2 py-1 text-xs rounded {{ $concept->status === 'mastered' ? 'bg-green-100 text-green-800' : ($concept->status === 'in_progress' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $concept->status }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection