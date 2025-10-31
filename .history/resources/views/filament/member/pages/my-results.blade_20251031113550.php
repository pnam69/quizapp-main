<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">My Completed Quizzes</h2>

    @if($completedQuizzes->isEmpty())
    <p>You haven’t completed any quizzes yet.</p>
    @else
    <ul class="list-disc pl-6">
        @foreach($completedQuizzes as $quiz)
        <li>
            {{ $quiz->title ?? 'Untitled Quiz' }} —
            Score: {{ $quiz->score ?? 'N/A' }}%
        </li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>