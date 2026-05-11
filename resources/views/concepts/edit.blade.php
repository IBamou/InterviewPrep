@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('concepts.show', $concept) }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Back to Concept
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">Edit Concept</h2>

            <form action="{{ route('concepts.update', $concept) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="$concept->title" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="explanation" :value="__('Explanation')" />
                    <textarea id="explanation" name="explanation" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ $concept->explanation }}</textarea>
                    <x-input-error :messages="$errors->get('explanation')" class="mt-2" />
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <x-input-label for="difficulty" :value="__('Difficulty')" />
                        <select id="difficulty" name="difficulty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="junior" {{ $concept->difficulty->value === 'junior' ? 'selected' : '' }}>Junior</option>
                            <option value="mid" {{ $concept->difficulty->value === 'mid' ? 'selected' : '' }}>Mid</option>
                            <option value="senior" {{ $concept->difficulty->value === 'senior' ? 'selected' : '' }}>Senior</option>
                        </select>
                        <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                    </div>
                    <div>
                        <x-input-label for="status" :value="__('Status')" />
                        <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="to_review" {{ $concept->status->value === 'to_review' ? 'selected' : '' }}>To Review</option>
                            <option value="in_progress" {{ $concept->status->value === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                            <option value="mastered" {{ $concept->status->value === 'mastered' ? 'selected' : '' }}>Mastered</option>
                        </select>
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="flex justify-between items-center pt-4">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Update Concept
                    </button>
                </div>
            </form>

            <div class="mt-4 pt-4 border-t">
                <form action="{{ route('concepts.archive', $concept) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <x-danger-button onclick="return confirm('Are you sure you want to archive this concept?')">
                        Archive Concept
                    </x-danger-button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection