<x-filament-panels::page>
    <div class="space-y-6">
        {{-- If no quiz selected --}}
        @if (!$selectedQuiz)
        <h2 class="text-xl font-bold mb-4">Select a Quiz</h2>

        @if ($quizzes->isEmpty())
        <p>No quizzes available for your sections or certifications.</p>
        @else
        <ul class="list-disc pl-6">
            @foreach ($quizzes as $quiz)
            <li class="mb-2">
                <button
                    wire:click="selectQuiz({{ $quiz->id }})"
                    class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    {{ $quiz->title ?? 'Untitled Quiz' }}
                </button>
            </li>
            @endforeach
        </ul>
        @endif

        {{-- If quiz selected --}}
        @else
        <h2 class="text-xl font-bold mb-4">{{ $selectedQuiz->title ?? 'Quiz' }}</h2>

        <form wire:submit.prevent="submit" class="space-y-4">
            @foreach ($questions as $question)
            <div class="p-4 border rounded-lg shadow-sm">
                <p class="font-semibold mb-2">{{ $loop->iteration }}. {{ $question->text }}</p>

                @foreach ($question->options as $option)
                <label class="flex items-center space-x-2 mb-1">
                    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $option->id }}">
                    <span>{{ $option->text }}</span>
                </label>
                @endforeach
            </div>
            @endforeach

            <div class="mt-6">
                <button
                    type="submit"
                    class="px-5 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                    Submit Quiz
                </button>

                <button
                    type="button"
                    wire:click="$set('selectedQuiz', null)"
                    class="px-4 py-2 ml-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                    Cancel
                </button>
            </div>
        </form>
        @endif
    </div>
</x-filament-panels::page>