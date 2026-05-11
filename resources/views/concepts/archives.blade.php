<x-app-layout>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
    <div class="flex justify-between items-center mb-6">
        <div>
            <h1 class="text-2xl font-semibold text-gray-900">Archived Concepts - {{ $domain->name }}</h1>
            <a href="{{ route('concepts.index', $domain) }}" class="text-sm text-indigo-600 hover:text-indigo-900">
                &larr; Back to Concepts
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-md">
            {{ session('success') }}
        </div>
    @endif

    @if ($concepts->isEmpty())
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <p class="text-gray-500">No archived concepts.</p>
        </div>
    @else
        <div class="space-y-3">
            @foreach ($concepts as $concept)
                <div class="border border-gray-200 rounded-lg p-4 bg-gray-50">
                    <div class="flex justify-between items-start">
                        <div>
                            <h3 class="font-medium text-gray-900">{{ $concept->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">Deleted {{ $concept->deleted_at->diffForHumans() }}</p>
                        </div>
                        <div class="flex gap-2">
                            <form action="{{ route('concepts.restore', $concept) }}" method="POST">
                                @csrf
                                <button type="submit" class="px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700">
                                    Restore
                                </button>
                            </form>
                            <form action="{{ route('concepts.forceDelete', $concept) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700" onclick="return confirm('Permanently delete this concept?')">
                                    Delete Forever
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
</x-app-layout>