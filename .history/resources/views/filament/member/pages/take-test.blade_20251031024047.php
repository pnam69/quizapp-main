<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Available Quizzes</h2>

    @if($quizzes->isEmpty())
        <p>No quizzes available at the moment.</p>
    @else
        <ul class="list-disc pl-6 mb-4">
            @foreach($quizzes as $quiz)
                <li>
                    <button wire:click="selectQuiz({{ $quiz->id }})" class="text-blue-500 hover:underline">
                        {{ $quiz->title ?? "Quiz #{$quiz->id}" }}
                    </button>
                </li>
            @endforeach
        </ul>
    @endif

    @if($selectedQuiz)
        <h3 class="text-lg font-semibold mb-2">{{ $selectedQuiz->title ?? 'Selected Quiz' }}</h3>

        <form wire:submit.prevent="submit">
            @foreach($questions as $question)
                <div class="mb-4">
                    <p class="font-medium">{{ $question->text }}</p>
                    @foreach($question->answers as $answer)
                        <label class="block">
                            <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $answer->id }}">
                            {{ $answer->text }}
                        </label>
                    @endforeach
                </div>
            @endforeach

            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                Submit
            </button>
        </form>
    @endif
</x-filament-panels::page>
