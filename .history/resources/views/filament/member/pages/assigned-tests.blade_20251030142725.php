<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Assigned Quizzes</h2>

    @if($assignedQuizzes->isEmpty())
    <p>No quizzes assigned yet.</p>
    @else
    <ul class="list-disc pl-6">
        @foreach($assignedQuizzes as $quiz)
        <li>{{ $quiz->title }} — Available from: {{ $quiz->created_at->format('Y-m-d') }}</li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>