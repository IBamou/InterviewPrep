<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="mb-6">
            <a href="{{ route('domains.index') }}" class="text-indigo-600 hover:text-indigo-900">
                &larr; Back to Domains
            </a>
        </div>

        <div class="bg-white shadow-sm rounded-lg">
            <div class="p-6">
                <h2 class="text-xl font-semibold mb-6">Create New Domain</h2>

                <form action="{{ route('domains.store') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <x-input-label for="name" :value="__('Domain Name')" />
                        <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name')" required />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <div class="mb-4">
                        <x-input-label for="color" :value="__('Color (hex code)')" />
                        <x-text-input id="color" name="color" type="text" class="mt-1 block w-full" placeholder="#3B82F6" :value="old('color')" required />
                        <x-input-error :messages="$errors->get('color')" class="mt-2" />
                    </div>

                    <div class="flex justify-end">
                        <x-primary-button>Create Domain</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>