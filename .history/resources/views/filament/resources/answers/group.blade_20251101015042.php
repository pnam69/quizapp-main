<x-filament::page>
    <div class="space-y-6">
        @foreach($questions as $question)
        <div class="p-4 border rounded-lg shadow-sm bg-white">
            <h3 class="font-bold text-lg mb-2">{{ $question->question }}</h3>
            <ul class="list-disc pl-5">
                @foreach($question->answers as $answer)
                <li>
                    {{ $answer->answer }}
                    @if($answer->is_checked)
                    <span class="text-green-600 font-semibold">(Correct)</span>
                    @endif
                </li>
                @endforeach
            </ul>
        </div>
        @endforeach
    </div>
</x-filament::page>