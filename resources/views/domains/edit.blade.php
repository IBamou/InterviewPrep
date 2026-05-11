@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="mb-6">
        <a href="{{ route('domains.index') }}" class="text-indigo-600 hover:text-indigo-900">
            &larr; Back to Domains
        </a>
    </div>

    <div class="bg-white shadow-sm rounded-lg">
        <div class="p-6">
            <h2 class="text-xl font-semibold mb-6">Edit Domain</h2>

            <form action="{{ route('domains.update', $domain) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-4">
                    <x-input-label for="name" :value="__('Domain Name')" />
                    <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="$domain->name" required />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <div class="mb-4">
                    <x-input-label for="color" :value="__('Color (hex code)')" />
                    <x-text-input id="color" name="color" type="text" class="mt-1 block w-full" :value="$domain->color" required />
                    <x-input-error :messages="$errors->get('color')" class="mt-2" />
                </div>

                <div class="flex justify-between items-center">
                    <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                        Update Domain
                    </button>

                    <form action="{{ route('domains.destroy', $domain) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <x-danger-button onclick="return confirm('Are you sure you want to delete this domain?')">
                            Delete Domain
                        </x-danger-button>
                    </form>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection