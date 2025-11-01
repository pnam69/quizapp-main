<x-filament-panels::page>
    {{-- Background Decorations --}}
    <div class="fixed inset-0 -z-10 overflow-hidden">
        {{-- Floating Shapes --}}
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-green-200/30 to-emerald-300/30 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-gradient-to-br from-blue-200/30 to-indigo-300/30 rounded-full blur-xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-gradient-to-br from-purple-200/30 to-pink-300/30 rounded-full blur-xl animate-pulse delay-2000"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-gradient-to-br from-yellow-200/30 to-orange-300/30 rounded-full blur-xl animate-pulse delay-3000"></div>

        {{-- Grid Pattern --}}
        <div class="absolute inset-0 bg-[linear-gradient(rgba(0,0,0,.02)_1px,transparent_1px),linear-gradient(90deg,rgba(0,0,0,.02)_1px,transparent_1px)] bg-[size:50px_50px]"></div>

        {{-- Corner Decorations --}}
        <div class="absolute top-0 left-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-full"></div>
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-blue-500/10 to-transparent rounded-full"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-gradient-to-tr from-purple-500/10 to-transparent rounded-full"></div>
        <div class="absolute bottom-0 right-0 w-32 h-32 bg-gradient-to-tl from-orange-500/10 to-transparent rounded-full"></div>
    </div>

    <div class="max-w-7xl mx-auto space-y-6 relative lg:pr-96">
        {{-- Performance Insights Sidebar --}}
        <div class="fixed right-6 top-24 w-80 bg-white/80 dark:bg-gray-800/80 backdrop-blur-lg rounded-xl shadow-xl border border-white/20 dark:border-gray-700/20 p-6 hidden lg:block">
            <h3 class="text-lg font-bold text-gray-900 dark:text-gray-100 mb-4 flex items-center gap-2">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                </svg>
                Performance Insights
            </h3>

            @if(count($completedQuizzes) > 0)
            <div class="space-y-4">
                <div class="bg-gradient-to-r from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Average Score</div>
                    <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ round($completedQuizzes->avg('score'), 1) }}%</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                        @if($completedQuizzes->avg('score') >= 80)
                        Excellent performance! 🎉
                        @elseif($completedQuizzes->avg('score') >= 60)
                        Good progress! Keep it up! 📈
                        @else
                        Room for improvement! 💪
                        @endif
                    </div>
                </div>

                <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Quiz Completion Rate</div>
                    <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ count($completedQuizzes) }}</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Quizzes completed</div>
                </div>

                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Best Performance</div>
                    <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $completedQuizzes->max('score') }}%</div>
                    <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">Highest score achieved</div>
                </div>

                <div class="bg-gradient-to-r from-orange-50 to-red-50 dark:from-orange-900/20 dark:to-red-900/20 rounded-lg p-4">
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Improvement Tips</div>
                    <div class="text-xs text-gray-600 dark:text-gray-400">
                        @if($completedQuizzes->avg('score') < 60)
                        Focus on understanding core concepts and practice regularly.
                        @elseif($completedQuizzes->avg('score') < 80)
                        Review incorrect answers and strengthen weak areas.
                        @else
                        Maintain your excellent performance! Consider challenging yourself with advanced topics.
                        @endif
                    </div>
                </div>
            </div>
            @else
            <div class="text-center py-8">
                <div class="bg-gradient-to-r from-gray-50 to-slate-50 dark:from-gray-800 dark:to-slate-800 rounded-lg p-4 mb-4">
                    <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    <div class="text-sm text-gray-600 dark:text-gray-400">No data yet</div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">Complete your first quiz to see performance insights!</p>
            </div>
            @endif
        </div>
        {{-- Header --}}
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <div class="flex items-center gap-4 mb-2">
                        <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <h1 class="text-3xl font-bold">My Results</h1>
                            <p class="text-green-100 mt-1">Review your completed quiz results and performance</p>
                        </div>
                    </div>
                    <div class="flex gap-4 text-sm mt-4">
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            ✅ {{ count($completedQuizzes) }} Quiz{{ count($completedQuizzes) !== 1 ? 'zes' : '' }} Completed
                        </div>
                        @if(count($completedQuizzes) > 0)
                        @php
                        $avgScore = $completedQuizzes->avg('score');
                        @endphp
                        <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                            📊 Average Score: {{ round($avgScore, 1) }}%
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Results List --}}
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            @forelse($completedQuizzes as $index => $quiz)
            @php
            $score = $quiz->score ?? 0;
            $scoreColor = $score >= 80 ? 'green' : ($score >= 60 ? 'yellow' : 'red');
            @endphp
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200 group">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1 min-w-0">
                        <div class="flex items-start gap-4">
                            <div class="bg-gradient-to-br from-{{ $scoreColor }}-500 to-{{ $scoreColor }}-600 text-white rounded-lg p-3 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 group-hover:text-green-600 dark:group-hover:text-green-400 transition-colors">
                                    {{ $quiz->title ?? 'Untitled Quiz' }}
                                </h3>
                                <div class="flex flex-wrap gap-3 mt-3">
                                    <div class="inline-flex items-center gap-1.5 bg-{{ $scoreColor }}-100 dark:bg-{{ $scoreColor }}-900/30 text-{{ $scoreColor }}-700 dark:text-{{ $scoreColor }}-300 px-3 py-1 rounded-full text-sm font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        Score: {{ $score }}%
                                    </div>
                                    <div class="inline-flex items-center gap-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        Completed: {{ $quiz->updated_at->format('M d, Y') }}
                                    </div>
                                    @if($quiz->quiz_size)
                                    <div class="inline-flex items-center gap-1.5 bg-purple-100 dark:bg-purple-900/30 text-purple-700 dark:text-purple-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        {{ $quiz->quiz_size }} Questions
                                    </div>
                                    @endif
                                    @if($quiz->section)
                                    <div class="inline-flex items-center gap-1.5 bg-indigo-100 dark:bg-indigo-900/30 text-indigo-700 dark:text-indigo-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                        </svg>
                                        {{ $quiz->section->name }}
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 shrink-0">
                        <div class="text-right">
                            <div class="text-3xl font-bold text-{{ $scoreColor }}-600 dark:text-{{ $scoreColor }}-400">
                                {{ $score }}%
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                @if($score >= 80)
                                Excellent!
                                @elseif($score >= 60)
                                Good Job!
                                @else
                                Keep Trying!
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-20">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    No Completed Quizzes
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                    You haven't completed any quizzes yet. Start taking quizzes to see your results here!
                </p>
                <x-filament::button
                    color="primary"
                    tag="a"
                    href="{{ route('filament.member.pages.take-test') }}"
                    size="lg"
                    icon="heroicon-o-play">
                    Take a Test
                </x-filament::button>
            </div>
            @endforelse
        </div>

        @if(count($completedQuizzes) > 0)
        {{-- Statistics Summary --}}
        <div class="grid md:grid-cols-4 gap-4">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">{{ count($completedQuizzes) }}</div>
                        <div class="text-sm text-blue-700 dark:text-blue-300">Quizzes Taken</div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-green-200 dark:border-green-800">
                <div class="flex items-center gap-3">
                    <div class="bg-green-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-green-900 dark:text-green-100">{{ round($completedQuizzes->avg('score'), 1) }}%</div>
                        <div class="text-sm text-green-700 dark:text-green-300">Average Score</div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-purple-200 dark:border-purple-800">
                <div class="flex items-center gap-3">
                    <div class="bg-purple-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-purple-900 dark:text-purple-100">{{ $completedQuizzes->max('score') }}%</div>
                        <div class="text-sm text-purple-700 dark:text-purple-300">Highest Score</div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-orange-200 dark:border-orange-800">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-orange-900 dark:text-orange-100">{{ $completedQuizzes->where('score', '>=', 80)->count() }}</div>
                        <div class="text-sm text-orange-700 dark:text-orange-300">Excellent (≥80%)</div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</x-filament-panels::page>