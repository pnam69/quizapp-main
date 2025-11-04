<div class="space-y-6">
    {{-- Student Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Student Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Name:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->user->name }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Email:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->user->email }}</p>
            </div>
            @if($record->user->classrooms->count() > 0)
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Classroom:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->user->classrooms->pluck('name')->join(', ') }}</p>
            </div>
            @endif
            @if($record->user->sections->count() > 0)
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Faculty:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->user->sections->pluck('name')->join(', ') }}</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Assessment Information --}}
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Assessment Information</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Title:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->assessment->title }}</p>
            </div>
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Submitted:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->submitted_at->format('M d, Y h:i A') }}</p>
            </div>
            @if($record->started_at && $record->submitted_at)
            <div>
                <span class="text-sm text-gray-600 dark:text-gray-400">Time Taken:</span>
                <p class="font-semibold text-gray-900 dark:text-white">{{ $record->started_at->diffInMinutes($record->submitted_at) }} minutes</p>
            </div>
            @endif
        </div>
    </div>

    {{-- Score Information --}}
    <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-6">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Score Details</h3>
        <div class="grid grid-cols-3 gap-6">
            <div class="text-center">
                <div class="text-4xl font-bold {{ $record->total_points > 0 && (($record->score / $record->total_points) * 100) >= 80 ? 'text-green-600' : (($record->total_points > 0 && ($record->score / $record->total_points) * 100) >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                    {{ $record->total_points > 0 ? round(($record->score / $record->total_points) * 100, 1) : 0 }}%
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Percentage</p>
            </div>
            <div class="text-center">
                <div class="text-4xl font-bold text-blue-600">
                    {{ $record->score }} / {{ $record->total_points }}
                </div>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Points</p>
            </div>
            <div class="text-center">
                @if($record->passed)
                    <div class="inline-flex items-center gap-2 bg-green-100 dark:bg-green-900/30 text-green-800 dark:text-green-300 px-4 py-2 rounded-full text-xl font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        PASSED
                    </div>
                @else
                    <div class="inline-flex items-center gap-2 bg-red-100 dark:bg-red-900/30 text-red-800 dark:text-red-300 px-4 py-2 rounded-full text-xl font-bold">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        FAILED
                    </div>
                @endif
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-2">Status</p>
            </div>
        </div>
    </div>

    {{-- Answer Review --}}
    @if($record->attemptAnswers->count() > 0)
    <div class="bg-gray-50 dark:bg-gray-800 rounded-lg p-4">
        <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-3">Answer Review</h3>
        <div class="space-y-3">
            @foreach($record->attemptAnswers as $answer)
            <div class="bg-white dark:bg-gray-700 rounded-lg p-3 border-l-4 {{ $answer->is_correct ? 'border-green-500' : 'border-red-500' }}">
                <div class="flex items-start gap-3">
                    @if($answer->is_correct)
                        <svg class="w-5 h-5 text-green-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    @endif
                    <div class="flex-1">
                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $answer->question->question_text }}</p>
                        @if($answer->selectedOption)
                        <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
                            <span class="font-semibold">Student Answer:</span> {{ $answer->selectedOption->option_text }}
                        </p>
                        @endif
                    </div>
                    <span class="text-sm font-bold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                        {{ $answer->points_earned ?? 0 }} pts
                    </span>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif
</div>
