@props(['concept'])

<div class="border rounded-lg p-4 hover:shadow-md transition-shadow">
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <a href="{{ route('concepts.show', $concept) }}" class="text-lg font-medium text-gray-900 hover:text-indigo-600">
                {{ $concept->title }}
            </a>
            <p class="text-sm text-gray-500 mt-1 line-clamp-2">{{ Str::limit($concept->explanation, 100) }}</p>
        </div>
        <div class="ml-4 flex flex-col items-end gap-2">
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
    <div class="mt-3 flex items-center justify-between">
        <div class="flex gap-2">
            <a href="{{ route('concepts.show', $concept) }}" class="text-gray-500 hover:text-gray-700 text-sm">
                View
            </a>
            <a href="{{ route('concepts.edit', $concept) }}" class="text-gray-500 hover:text-gray-700 text-sm">
                Edit
            </a>
        </div>
        <form action="{{ route('concepts.updateStatus', $concept) }}" method="POST">
            @csrf
            @method('PATCH')
            <button type="submit" class="text-indigo-600 hover:text-indigo-900 text-sm">
                Next Status
            </button>
        </form>
    </div>
</div>