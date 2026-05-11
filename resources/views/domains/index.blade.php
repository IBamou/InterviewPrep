@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-900">My Domains</h1>
        <a href="{{ route('domains.create') }}" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
            Add Domain
        </a>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if ($domains->isEmpty())
        <div class="text-center py-12">
            <p class="text-gray-500">No domains yet. Create your first domain to start organizing your concepts.</p>
            <a href="{{ route('domains.create') }}" class="mt-4 inline-block px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                Create Domain
            </a>
        </div>
    @else
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
            @foreach ($domains as $domain)
                <x-domain-card :domain="$domain" />
            @endforeach
        </div>
    @endif
</div>
@endsection