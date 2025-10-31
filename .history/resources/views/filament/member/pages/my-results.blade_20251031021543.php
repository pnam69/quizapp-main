<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">My Completed Quizzes</h2>

    @if($completedQuizzes->isEmpty())
    <p>You haven’t completed any quizzes yet.</p>
    @else
    <ul class="list-disc pl-6">
        @foreach($completedQuizzes as $quiz)
        @php
        $latestScore = $quiz->answers()
        ->where('user_id', Auth::guard('member')->id())
        ->orderByDesc('created_at')
        ->first()?->is_correct ? $quiz->score : 0;
        @endphp
        <li>{{ $quiz->title }} — Score: {{ $latestScore }}</li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>