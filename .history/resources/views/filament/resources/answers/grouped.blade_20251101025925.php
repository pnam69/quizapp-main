<x-filament::page>
    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-4 border rounded-lg shadow-sm bg-white">
            <h2 class="text-lg font-semibold mb-2">{{ $question->question }}</h2>

            <ul class="space-y-1">
                @foreach($question->answers as $answer)
                <li class="flex items-center justify-between p-2 border-b last:border-b-0">
                    <span>{{ $answer->answer }}</span>
                    <span class="text-green-600 font-semibold">
                        @if($answer->is_checked)
                        Correct
                        @endif
                    </span>
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>

    <div class="mt-4 flex space-x-2">
        <button @click="$wire.goToPage({{ $page - 1 }})"
            class="px-3 py-1 border rounded"
            {{ $page <= 1 ? 'disabled' : '' }}>Prev</button>

        <span>Page {{ $page }} of {{ $totalPages }}</span>

        <button @click="$wire.goToPage({{ $page + 1 }})"
            class="px-3 py-1 border rounded"
            {{ $page >= $totalPages ? 'disabled' : '' }}>Next</button>
    </div>
</x-filament::page>