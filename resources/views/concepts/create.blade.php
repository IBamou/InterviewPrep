<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('concepts.index', $domain) }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Back to Concepts
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">Create New Concept</h2>

            <form action="{{ route('concepts.store', $domain) }}" method="POST">
                @csrf

                <div class="mb-4">
                    <x-input-label for="title" :value="__('Title')" />
                    <x-text-input id="title" name="title" type="text" class="mt-1 block w-full" :value="old('title')" required />
                    <x-input-error :messages="$errors->get('title')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="explanation" :value="__('Explanation')" />
                    <textarea id="explanation" name="explanation" rows="6" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('explanation') }}</textarea>
                    <x-input-error :messages="$errors->get('explanation')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="difficulty" :value="__('Difficulty')" />
                    <select id="difficulty" name="difficulty" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                        <option value="">Select difficulty</option>
                        <option value="junior" {{ old('difficulty') === 'junior' ? 'selected' : '' }}>Junior</option>
                        <option value="mid" {{ old('difficulty') === 'mid' ? 'selected' : '' }}>Mid</option>
                        <option value="senior" {{ old('difficulty') === 'senior' ? 'selected' : '' }}>Senior</option>
                    </select>
                    <x-input-error :messages="$errors->get('difficulty')" class="mt-2" />
                </div>

                <div class="flex justify-end">
                    <x-primary-button>Create Concept</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</div>
</x-app-layout>