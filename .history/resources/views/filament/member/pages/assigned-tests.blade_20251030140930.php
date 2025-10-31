<x-filament-panels::page>
    <h2 class="text-xl font-bold mb-4">Assigned Tests</h2>

    @if($assignedQuizzes->isEmpty())
    <p>No assigned quizzes at the moment.</p>
    @else
    <ul>
        @foreach($assignedQuizzes as $quiz)
        <li class="mb-2 p-2 border rounded flex justify-between items-center">
            <span>{{ $quiz->title }}</span>
            <a href="{{ route('filament.member.pages.take-test', $quiz->id) }}" class="px-2 py-1 bg-blue-500 text-white rounded">
                Take Test
            </a>
        </li>
        @endforeach
    </ul>
    @endif
</x-filament-panels::page>