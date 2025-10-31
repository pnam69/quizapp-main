<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">My Completed Quizzes</h2>

    @if($completedQuizzes->isEmpty())
    <p>No completed quizzes yet.</p>
    @else
    <table class="w-full table-auto border-collapse border border-gray-200">
        <thead>
            <tr class="bg-gray-100">
                <th class="border px-4 py-2">Quiz</th>
                <th class="border px-4 py-2">Score</th>
                <th class="border px-4 py-2">Completed At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($completedQuizzes as $quiz)
            <tr>
                <td class="border px-4 py-2">{{ $quiz->title }}</td>
                <td class="border px-4 py-2">{{ $quiz->score ?? 'N/A' }}</td>
                <td class="border px-4 py-2">{{ $quiz->updated_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @endif
</x-filament-panels::page>