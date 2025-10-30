<x-filament::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-filament::card>
                <h3 class="text-lg font-semibold">Total Quizzes</h3>
                <p class="text-2xl font-bold text-primary">{{ $totalQuizzes }}</p>
            </x-filament::card>

            <x-filament::card>
                <h3 class="text-lg font-semibold">Completed</h3>
                <p class="text-2xl font-bold text-success">{{ $completedQuizzes }}</p>
            </x-filament::card>

            <x-filament::card>
                <h3 class="text-lg font-semibold">Pending</h3>
                <p class="text-2xl font-bold text-danger">
                    {{ $totalQuizzes - $completedQuizzes }}
                </p>
            </x-filament::card>
        </div>

        <x-filament::card>
            <h3 class="text-lg font-semibold mb-3">Recent Results</h3>
            @if($recentResults->isEmpty())
            <p class="text-gray-500">No completed quizzes yet.</p>
            @else
            <ul class="divide-y divide-gray-200">
                @foreach($recentResults as $quiz)
                <li class="py-2 flex justify-between">
                    <span>{{ $quiz->title ?? 'Untitled Quiz' }}</span>
                    <span class="text-sm text-gray-600">
                        {{ $quiz->score ?? 'N/A' }}%
                    </span>
                </li>
                @endforeach
            </ul>
            @endif
        </x-filament::card>

        <x-filament::card>
            <h3 class="text-lg font-semibold mb-3">Next Quiz</h3>
            @if($nextQuiz)
            <p class="mb-2">{{ $nextQuiz->title ?? 'Untitled Quiz' }}</p>
            <x-filament::button
                tag="a"
                color="primary"
                href="{{ route('filament.member.pages.take-test', ['quiz' => $nextQuiz->id]) }}">
                Start Quiz
            </x-filament::button>
            @else
            <p class="text-gray-500">You have no pending quizzes.</p>
            @endif
        </x-filament::card>
    </div>
</x-filament::page>