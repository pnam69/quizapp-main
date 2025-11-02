<x-filament-widgets::widget>
    <x-filament::section>
        <div class="space-y-4">
            {{-- Header --}}
            <div class="flex items-center justify-between">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Quick Actions
                </h2>
            </div>

            @php
                $data = $this->getViewData();
                $pendingHomework = $data['pendingHomework'];
                $nextQuiz = $data['nextQuiz'];
                $overdueHomework = $data['overdueHomework'];
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                {{-- Pending Homework --}}
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-blue-900 dark:text-blue-100">Pending Homework</h3>
                            <p class="text-2xl font-bold text-blue-700 dark:text-blue-300 mt-1">
                                {{ $pendingHomework->count() }}
                            </p>
                        </div>
                        <div class="p-2 bg-blue-200 dark:bg-blue-800 rounded-lg">
                            <svg class="w-6 h-6 text-blue-700 dark:text-blue-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                    </div>
                    
                    @if($pendingHomework->count() > 0)
                        <div class="space-y-2 mb-3">
                            @foreach($pendingHomework->take(2) as $homework)
                                <div class="text-sm">
                                    <p class="font-medium text-blue-900 dark:text-blue-100 truncate">{{ $homework->title }}</p>
                                    <p class="text-xs text-blue-700 dark:text-blue-300">
                                        Due: {{ $homework->due_date->format('M d, h:i A') }}
                                    </p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <x-filament::button
                        tag="a"
                        href="{{ route('filament.member.pages.my-homework') }}"
                        size="sm"
                        color="primary"
                        class="w-full">
                        View All Homework
                    </x-filament::button>
                </div>

                {{-- Next Quiz --}}
                <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-green-900 dark:text-green-100">Next Quiz</h3>
                            @if($nextQuiz)
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">Ready to start</p>
                            @else
                                <p class="text-sm text-green-700 dark:text-green-300 mt-1">All caught up!</p>
                            @endif
                        </div>
                        <div class="p-2 bg-green-200 dark:bg-green-800 rounded-lg">
                            <svg class="w-6 h-6 text-green-700 dark:text-green-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    @if($nextQuiz)
                        <div class="mb-3">
                            <p class="font-medium text-green-900 dark:text-green-100 mb-1">
                                {{ $nextQuiz->title ?? 'Untitled Quiz' }}
                            </p>
                            <p class="text-xs text-green-700 dark:text-green-300">
                                {{ $nextQuiz->quiz_size ?? 0 }} questions
                            </p>
                        </div>
                        <x-filament::button
                            tag="a"
                            href="{{ route('filament.member.pages.take-test', ['quiz' => $nextQuiz->id]) }}"
                            size="sm"
                            color="success"
                            class="w-full">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Start Quiz
                        </x-filament::button>
                    @else
                        <x-filament::button
                            tag="a"
                            href="{{ route('filament.member.pages.assigned-tests') }}"
                            size="sm"
                            color="success"
                            class="w-full">
                            Browse Tests
                        </x-filament::button>
                    @endif
                </div>

                {{-- Overdue Alert --}}
                <div class="bg-gradient-to-br from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-lg p-4 border border-red-200 dark:border-red-800">
                    <div class="flex items-start justify-between mb-3">
                        <div>
                            <h3 class="font-semibold text-red-900 dark:text-red-100">Overdue</h3>
                            <p class="text-2xl font-bold text-red-700 dark:text-red-300 mt-1">
                                {{ $overdueHomework }}
                            </p>
                        </div>
                        <div class="p-2 bg-red-200 dark:bg-red-800 rounded-lg">
                            <svg class="w-6 h-6 text-red-700 dark:text-red-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                    </div>
                    
                    @if($overdueHomework > 0)
                        <div class="mb-3">
                            <p class="text-sm text-red-700 dark:text-red-300">
                                You have {{ $overdueHomework }} overdue assignment{{ $overdueHomework > 1 ? 's' : '' }} that still accept{{ $overdueHomework == 1 ? 's' : '' }} late submissions.
                            </p>
                        </div>
                        <x-filament::button
                            tag="a"
                            href="{{ route('filament.member.pages.my-homework') }}"
                            size="sm"
                            color="danger"
                            class="w-full">
                            Submit Now
                        </x-filament::button>
                    @else
                        <div class="mb-3">
                            <p class="text-sm text-red-700 dark:text-red-300">
                                Great! You're all caught up with your assignments.
                            </p>
                        </div>
                        <x-filament::button
                            tag="a"
                            href="{{ route('filament.member.pages.student-hub') }}"
                            size="sm"
                            outlined
                            color="danger"
                            class="w-full">
                            Browse Materials
                        </x-filament::button>
                    @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                    <a href="{{ route('filament.member.pages.student-hub') }}" 
                       class="flex flex-col items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Learning Hub</span>
                    </a>

                    <a href="{{ route('filament.member.pages.my-results') }}" 
                       class="flex flex-col items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">My Results</span>
                    </a>

                    <a href="{{ route('filament.member.pages.assigned-tests') }}" 
                       class="flex flex-col items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Tests</span>
                    </a>

                    <a href="{{ route('filament.member.pages.notifications') }}" 
                       class="flex flex-col items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                        <svg class="w-8 h-8 text-gray-600 dark:text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                        </svg>
                        <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Notifications</span>
                    </a>
                </div>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
