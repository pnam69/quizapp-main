<x-filament-panels::page>
    <div>
        @if (!$selectedQuiz)
        <h2 class="text-xl font-bold mb-4">Available Quizzes</h2>
        @if($quizzes->isEmpty())
        <p>No quizzes available.</p>
        @else
        <ul class="space-y-2">
            @foreach ($quizzes as $quiz)
            <li>
                <button wire:click="selectQuiz({{ $quiz->id }})" class="px-4 py-2 bg-blue-500 text-white rounded">
                    {{ $quiz->title ?? 'Untitled Quiz' }}
                </button>
            </li>
            @endforeach
        </ul>
        @endif
        @else
        <h2 class="text-xl font-bold mb-4">{{ $selectedQuiz->title }}</h2>
        <form wire:submit.prevent="submit">
            @foreach ($questions as $question)
            <div class="mb-4">
                <p class="font-semibold">{{ $question->question_text }}</p>
                @foreach ($question->answers as $answer)
                <label class="block">
                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $answer->id }}">
                    {{ $answer->answer_text }}
                </label>
                @endforeach
            </div>
            @endforeach
            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded">Submit</button>
        </form>
        @endif
    </div>
</x-filament-panels::page>