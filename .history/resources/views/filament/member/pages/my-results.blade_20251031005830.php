<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">My Completed Quizzes</h2>

    @forelse($completedQuizzes as $quiz)
        <h3 class="font-semibold">{{ $quiz->title }} — Score: {{ $quiz->score ?? 'N/A' }}%</h3>
        <ul class="pl-4 mb-4">
            @foreach($quiz->questions as $question)
                @php
                    $answer = $question->quizAnswers()
                        ->where('user_id', auth()->id())
                        ->first();
                @endphp
                <li class="{{ $answer && $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                    {{ $question->question }} <br>
                    Your answer: {{ $answer?->option?->option_text ?? 'No answer' }}
                </li>
            @endforeach
        </ul>
    @empty
        <p>You haven’t completed any quizzes yet.</p>
    @endforelse
</x-filament-panels::page>
