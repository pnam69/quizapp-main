<div class="space-y-8 max-w-4xl mx-auto">
    {{-- Header Section --}}
    <div class="bg-gradient-to-r from-slate-50 to-gray-50 dark:from-slate-800 dark:to-gray-800 rounded-xl p-6 border border-slate-200 dark:border-slate-700">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold text-slate-900 dark:text-white">{{ $record->user->name }}</h2>
                <p class="text-slate-600 dark:text-slate-400 mt-1">{{ $record->user->email }}</p>
            </div>
            <div class="text-right">
                <div class="text-sm text-slate-500 dark:text-slate-400">Assessment</div>
                <div class="font-semibold text-slate-900 dark:text-white">{{ $record->assessment->title }}</div>
            </div>
        </div>
    </div>

    {{-- Score Overview Card --}}
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center gap-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
                Performance Overview
            </h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                {{-- Percentage Score --}}
                <div class="text-center">
                    <div class="relative inline-flex items-center justify-center">
                        <svg class="w-24 h-24 transform -rotate-90" viewBox="0 0 36 36">
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="100, 100"
                                class="text-slate-200 dark:text-slate-600" />
                            <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-dasharray="{{ round($record->percentage, 1) }}, 100"
                                class="{{ $record->percentage >= 80 ? 'text-green-500' : ($record->percentage >= 60 ? 'text-yellow-500' : 'text-red-500') }}" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-2xl font-bold {{ $record->percentage >= 80 ? 'text-green-600' : ($record->percentage >= 60 ? 'text-yellow-600' : 'text-red-600') }}">
                                {{ round($record->percentage, 1) }}%
                            </span>
                        </div>
                    </div>
                    <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-2">Score Percentage</p>
                </div>

                {{-- Points Breakdown --}}
                <div class="text-center">
                    <div class="bg-slate-50 dark:bg-slate-700 rounded-lg p-4">
                        <div class="text-3xl font-bold text-slate-900 dark:text-white">
                            {{ $record->score }}<span class="text-lg text-slate-500">/{{ $record->total_points }}</span>
                        </div>
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-1">Points Earned</p>
                        <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-2 mt-2">
                            <div class="bg-blue-600 h-2 rounded-full transition-all duration-300"
                                style="width: {{ $record->percentage }}%"></div>
                        </div>
                    </div>
                </div>

                {{-- Pass/Fail Status --}}
                <div class="text-center">
                    <div class="flex flex-col items-center">
                        @if($record->passed)
                        <div class="w-16 h-16 bg-green-100 dark:bg-green-900/30 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-bold text-green-600 dark:text-green-400">PASSED</div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Score ≥ {{ $record->assessment->passing_score }}%</p>
                        @else
                        <div class="w-16 h-16 bg-red-100 dark:bg-red-900/30 rounded-full flex items-center justify-center mb-3">
                            <svg class="w-8 h-8 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div class="text-lg font-bold text-red-600 dark:text-red-400">FAILED</div>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Score < {{ $record->assessment->passing_score }}%</p>
                        @endif
                        <p class="text-sm font-medium text-slate-600 dark:text-slate-400 mt-2">Assessment Status</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Assessment Details --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Student Details --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
                Student Details
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Full Name</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->user->name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Email Address</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->user->email }}</span>
                </div>
                @if($record->user->classrooms->count() > 0)
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Classroom</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->user->classrooms->pluck('name')->join(', ') }}</span>
                </div>
                @endif
                @if($record->user->sections->count() > 0)
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Faculty</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->user->sections->pluck('name')->join(', ') }}</span>
                </div>
                @endif
            </div>
        </div>

        {{-- Assessment Details --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 p-6">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Assessment Details
            </h3>
            <div class="space-y-3">
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Assessment Title</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->assessment->title }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Submitted Date</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->submitted_at->format('M d, Y') }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-100 dark:border-slate-700">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Submitted Time</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">{{ $record->submitted_at->format('h:i A') }}</span>
                </div>
                @if($record->started_at && $record->submitted_at)
                <div class="flex justify-between items-center py-2">
                    <span class="text-sm font-medium text-slate-600 dark:text-slate-400">Time Spent</span>
                    <span class="text-sm font-semibold text-slate-900 dark:text-white">
                        {{ $record->started_at->diffInMinutes($record->submitted_at) }} min
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Answer Review Section --}}
    @if($record->attemptAnswers->count() > 0)
    <div class="bg-white dark:bg-slate-800 rounded-xl shadow-sm border border-slate-200 dark:border-slate-700 overflow-hidden">
        <div class="bg-gradient-to-r from-slate-50 to-gray-50 dark:from-slate-700 dark:to-slate-700 px-6 py-4 border-b border-slate-200 dark:border-slate-600">
            <h3 class="text-lg font-semibold text-slate-900 dark:text-white flex items-center gap-2">
                <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                Detailed Answer Review
                <span class="text-sm font-normal text-slate-500 dark:text-slate-400 ml-2">
                    ({{ $record->attemptAnswers->count() }} questions)
                </span>
            </h3>
        </div>

        <div class="p-6">
            <div class="space-y-4">
                @foreach($record->attemptAnswers as $index => $answer)
                <div class="bg-slate-50 dark:bg-slate-700/50 rounded-lg p-4 border-l-4 {{ $answer->is_correct ? 'border-l-green-500' : 'border-l-red-500' }}">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <div class="flex items-center gap-3 mb-2">
                                <span class="flex items-center justify-center w-6 h-6 bg-slate-200 dark:bg-slate-600 text-slate-700 dark:text-slate-300 text-xs font-bold rounded-full">
                                    {{ $index + 1 }}
                                </span>
                                @if($answer->is_correct)
                                <div class="flex items-center gap-1 text-green-600 dark:text-green-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Correct</span>
                                </div>
                                @else
                                <div class="flex items-center gap-1 text-red-600 dark:text-red-400">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    <span class="text-sm font-medium">Incorrect</span>
                                </div>
                                @endif
                            </div>

                            <div class="mb-3">
                                <p class="text-sm font-medium text-slate-900 dark:text-white leading-relaxed">
                                    {{ $answer->question->question_text }}
                                </p>
                            </div>

                            @if($answer->selectedOption)
                            <div class="bg-white dark:bg-slate-600 rounded-md p-3 border border-slate-200 dark:border-slate-500">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="text-xs font-medium text-slate-600 dark:text-slate-400 uppercase tracking-wide">Student's Answer</span>
                                </div>
                                <p class="text-sm text-slate-900 dark:text-white">
                                    {{ $answer->selectedOption->option_text }}
                                </p>
                            </div>
                            @endif
                        </div>

                        <div class="ml-4 flex flex-col items-end">
                            <div class="text-lg font-bold {{ $answer->is_correct ? 'text-green-600' : 'text-red-600' }}">
                                {{ $answer->points_earned ?? 0 }}
                            </div>
                            <div class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                points
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
</div>