<div class="space-y-6">
    {{-- Header with Grade Badge --}}
    <div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-600 dark:from-blue-900 dark:via-indigo-900 dark:to-purple-900 rounded-2xl p-6 overflow-hidden">
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
        
        <div class="relative flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-2">
                    <div class="w-12 h-12 bg-white/20 backdrop-blur-sm rounded-xl flex items-center justify-center">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">{{ $record->user->name }}</h2>
                        <p class="text-blue-100 dark:text-blue-200 text-sm">{{ $record->user->email }}</p>
                    </div>
                </div>
                
                @php
                    $gradeLabel = $record->percentage >= 70 ? 'PASSED' : ($record->percentage >= 50 ? 'NEEDS IMPROVEMENT' : 'FAILED');
                    $gradeBgColor = $record->percentage >= 70 ? 'bg-green-500/20' : ($record->percentage >= 50 ? 'bg-yellow-500/20' : 'bg-red-500/20');
                    $gradeBorderColor = $record->percentage >= 70 ? 'border-green-400/50' : ($record->percentage >= 50 ? 'border-yellow-400/50' : 'border-red-400/50');
                    $gradeTextColor = $record->percentage >= 70 ? 'text-green-300' : ($record->percentage >= 50 ? 'text-yellow-300' : 'text-red-300');
                @endphp
                
                <div class="mt-4 flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 {{ $gradeBgColor }} backdrop-blur-sm border {{ $gradeBorderColor }} rounded-lg {{ $gradeTextColor }} text-sm font-semibold">
                        @if($record->percentage >= 70)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @elseif($record->percentage >= 50)
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        @else
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                        {{ $gradeLabel }}
                    </span>
                    <span class="text-white/80 text-sm">{{ $record->assessment->title }}</span>
                </div>
            </div>
            
            <div class="text-right">
                <div class="inline-flex flex-col items-center justify-center w-28 h-28 bg-white dark:bg-slate-800 rounded-2xl shadow-xl">
                    <div class="text-4xl font-black bg-gradient-to-br {{ $record->percentage >= 70 ? 'from-green-600 to-emerald-600' : ($record->percentage >= 50 ? 'from-yellow-600 to-orange-600' : 'from-red-600 to-rose-600') }} bg-clip-text text-transparent">
                        {{ round($record->percentage, 1) }}%
                    </div>
                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mt-1">Score</div>
                </div>
            </div>
        </div>
    </div>

    {{-- Performance Metrics --}}
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        {{-- Score Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border-2 {{ $record->percentage >= 70 ? 'border-green-500/20' : ($record->percentage >= 50 ? 'border-yellow-500/20' : 'border-red-500/20') }}">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg {{ $record->percentage >= 70 ? 'bg-green-100 dark:bg-green-900/30' : ($record->percentage >= 50 ? 'bg-yellow-100 dark:bg-yellow-900/30' : 'bg-red-100 dark:bg-red-900/30') }} flex items-center justify-center">
                    <svg class="w-5 h-5 {{ $record->percentage >= 70 ? 'text-green-600 dark:text-green-400' : ($record->percentage >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold {{ $record->percentage >= 70 ? 'text-green-600 dark:text-green-400' : ($record->percentage >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                {{ round($record->percentage, 1) }}%
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Final Score</div>
        </div>

        {{-- Points Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border-2 border-blue-500/20">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-blue-100 dark:bg-blue-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ $record->score }}<span class="text-lg text-slate-500 dark:text-slate-400">/{{ $record->total_points }}</span>
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Points Earned</div>
        </div>

        {{-- Time Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border-2 border-purple-500/20">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">
                @if($record->started_at && $record->submitted_at)
                    {{ $record->started_at->diffInMinutes($record->submitted_at) }}
                @else
                    --
                @endif
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Minutes Spent</div>
        </div>

        {{-- Questions Card --}}
        <div class="bg-white dark:bg-slate-800 rounded-xl p-5 border-2 border-indigo-500/20">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/30 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">
                {{ $record->attemptAnswers->where('is_correct', true)->count() }}<span class="text-lg text-slate-500 dark:text-slate-400">/{{ $record->attemptAnswers->count() }}</span>
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Correct Answers</div>
        </div>
    </div>

    {{-- Grade Scale Info --}}
    <div class="bg-gradient-to-r from-slate-100 to-slate-50 dark:from-slate-800 dark:to-slate-700 rounded-xl p-5 border border-slate-200 dark:border-slate-600">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Grading Scale
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900/50 rounded-lg p-3">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Passed</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">70% and above</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900/50 rounded-lg p-3">
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Needs Improvement</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">50% - 69%</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-900/50 rounded-lg p-3">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Failed</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">Below 50%</div>
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