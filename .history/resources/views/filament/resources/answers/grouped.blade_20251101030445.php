<x-filament::page>
    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-6 border rounded-lg shadow hover:shadow-lg transition-shadow bg-white">
            <h2 class="text-xl font-bold mb-3 text-gray-800">{{ $question->question }}</h2>

            <ul class="divide-y divide-gray-200">
                @foreach($question->answers as $answer)
                <li class="flex items-center justify-between py-2 px-3 hover:bg-gray-50 transition-colors">
                    <span class="text-gray-700">{{ $answer->answer }}</span>
                    @if($answer->is_checked)
                    <span class="text-green-600 font-semibold bg-green-100 px-2 py-1 rounded-full text-sm">Correct</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <div class="mt-6 flex items-center justify-center space-x-3">
        <button
            @click="$wire.goToPage({{ $page - 1 }})"
            class="px-4 py-2 border rounded hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $page <= 1 ? 'disabled' : '' }}>
            &larr; Prev
        </button>

        <span class="text-gray-700 font-medium">Page {{ $page }} of {{ $totalPages }}</span>

        <button
            @click="$wire.goToPage({{ $page + 1 }})"
            class="px-4 py-2 border rounded hover:bg-gray-100 disabled:opacity-50 disabled:cursor-not-allowed"
            {{ $page >= $totalPages ? 'disabled' : '' }}>
            Next &rarr;
        </button>
    </div>
</x-filament::page>