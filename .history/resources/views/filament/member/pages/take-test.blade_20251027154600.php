<x-filament-panels::page>
    @if(!$selectedQuiz)
        <h2 class="text-xl font-bold mb-4">Available Quizzes</h2>

        @forelse($quizzes as $quiz)
            <div class="p-4 border rounded-lg mb-3 flex justify-between items-center">
                <div>
                    <h3 class="font-semibold">{{ $quiz->title }}</h3>
                    <p class="text-sm text-gray-500">{{ $quiz->description }}</p>
                </div>
                <x-filament::button wire:click="selectQuiz({{ $quiz->id }})">Take</x-filament::button>
            </div>
        @empty
            <p>No quizzes available right now.</p>
        @endforelse
    @else
        <h2 class="text-xl font-bold mb-4">{{ $selectedQuiz->title }}</h2>

        <form wire:submit.prevent="submit">
            @foreach($questions as $question)
                <div class="mb-4">
                    <p class="font-semibold">{{ $question->content }}</p>

                    @foreach($question->answers as $answer)
                        <label class="flex items-center space-x-2">
                            <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $answer->id }}">
                            <span>{{ $answer->content }}</span>
                        </label>
                    @endforeach
                </div>
            @endforeach

            <x-filament::button type="submit">Submit</x-filament::button>
        </form>
    @endif
</x-filament-panels::page>
