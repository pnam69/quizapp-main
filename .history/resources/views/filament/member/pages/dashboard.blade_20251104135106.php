<x-filament::page>
    <div class="space-y-6">
        {{-- Quick Stats Overview --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Total Tests</h3>
                        <p class="text-2xl font-bold text-primary-600 dark:text-primary-400">{{ $totalAssessments }}</p>
                    </div>
                    <div class="p-3 bg-primary-100 dark:bg-primary-900 rounded-full">
                        <svg class="w-6 h-6 text-primary-600 dark:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Completed Tests</h3>
                        <p class="text-2xl font-bold text-success-600 dark:text-success-400">{{ $completedAssessments }}</p>
                    </div>
                    <div class="p-3 bg-success-100 dark:bg-success-900 rounded-full">
                        <svg class="w-6 h-6 text-success-600 dark:text-success-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Pending Homework</h3>
                        <p class="text-2xl font-bold text-warning-600 dark:text-warning-400">{{ $pendingHomework }}</p>
                    </div>
                    <div class="p-3 bg-warning-100 dark:bg-warning-900 rounded-full">
                        <svg class="w-6 h-6 text-warning-600 dark:text-warning-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
            </x-filament::card>

            <x-filament::card>
                <div class="flex items-center justify-between">
                    <div>
                        <h3 class="text-sm font-medium text-gray-600 dark:text-gray-400">Average Score</h3>
                        <p class="text-2xl font-bold text-info-600 dark:text-info-400">{{ number_format($averageScore, 1) }}%</p>
                    </div>
                    <div class="p-3 bg-info-100 dark:bg-info-900 rounded-full">
                        <svg class="w-6 h-6 text-info-600 dark:text-info-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                        </svg>
                    </div>
                </div>
            </x-filament::card>
        </div>

        {{-- Main Content Grid --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Recent Quiz Results --}}
            <x-filament::card>
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                    Recent Tesst Results
                </h3>
                @if($recentResults->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                    <p class="mt-2 text-gray-500">No completed assessments yet.</p>
                </div>
                @else
                <div class="space-y-3">
                    @foreach($recentResults as $attempt)
                    @php
                    $percentage = $attempt->percentage ?? ($attempt->total_points > 0 ? round(($attempt->points_earned / $attempt->total_points) * 100, 1) : 0);
                    @endphp
                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="flex-1 min-w-0">
                            <p class="font-medium truncate">{{ $attempt->assessment->title ?? 'Untitled Assessment' }}</p>
                            <p class="text-xs text-gray-500">
                                {{ $attempt->submitted_at ? $attempt->submitted_at->diffForHumans() : 'In Progress' }}
                                • {{ $attempt->points_earned ?? $attempt->score }}/{{ $attempt->total_points }} points
                            </p>
                        </div>
                        <div class="flex items-center gap-2 ml-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @if($percentage >= 70) bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300
                                    @elseif($percentage >= 50) bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300
                                    @else bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300
                                    @endif">
                                {{ $percentage }}%
                            </span>
                            @if($attempt->passed)
                            <span class="text-success-600 dark:text-success-400 font-bold">✓</span>
                            @else
                            <span class="text-danger-600 dark:text-danger-400 font-bold">✗</span>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </x-filament::card>

            {{-- Recent Graded Homework --}}
            <x-filament::card>
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-success-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Recent Graded Homework
                </h3>
                @if($gradedHomework->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="mt-2 text-gray-500">No graded homework yet.</p>
                </div>
                @else
                <div class="space-y-3">
                    @foreach($gradedHomework as $submission)
                    <div class="flex justify-between items-center p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                        <div class="flex-1">
                            <p class="font-medium">{{ $submission->homework->title }}</p>
                            <p class="text-xs text-gray-500">Graded {{ $submission->graded_at->diffForHumans() }}</p>
                            @if($submission->feedback)
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1 line-clamp-1">{{ $submission->feedback }}</p>
                            @endif
                        </div>
                        <div class="text-right ml-4">
                            <span class="px-3 py-1 rounded-full text-sm font-semibold
                                    @php
                                        $percentage = ($submission->score / $submission->homework->max_points) * 100;
                                    @endphp
                                    @if($percentage >= 70) bg-success-100 text-success-700 dark:bg-success-900 dark:text-success-300
                                    @elseif($percentage >= 50) bg-warning-100 text-warning-700 dark:bg-warning-900 dark:text-warning-300
                                    @else bg-danger-100 text-danger-700 dark:bg-danger-900 dark:text-danger-300
                                    @endif">
                                {{ $submission->score }}/{{ $submission->homework->max_points }}
                            </span>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </x-filament::card>
        </div>

        {{-- Next Quiz & Recent Materials --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Next Assessment --}}
            <x-filament::card>
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-warning-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Next Assessment
                </h3>
                @if($nextAssessment)
                <div class="p-4 bg-primary-50 dark:bg-primary-900/20 rounded-lg border border-primary-200 dark:border-primary-800">
                    <p class="font-medium text-lg mb-2">{{ $nextAssessment->title ?? 'Untitled Assessment' }}</p>
                    <div class="text-sm text-gray-600 dark:text-gray-400 mb-4 space-y-1">
                        <p>📝 {{ $nextAssessment->questions_count ?? 0 }} questions</p>
                        <p>⏱️ {{ $nextAssessment->time_limit ?? 'No' }} time limit</p>
                        <p>📅 Created {{ $nextAssessment->created_at->diffForHumans() }}</p>
                    </div>
                    <x-filament::button
                        tag="a"
                        color="primary"
                        size="lg"
                        href="{{ route('filament.member.pages.take-test') }}">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Start Assessment
                    </x-filament::button>
                </div>
                @else
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <p class="mt-2 text-gray-500">You have no pending assessments.</p>
                    <p class="text-sm text-gray-400">Great job staying on top of your work!</p>
                </div>
                @endif
            </x-filament::card>

            {{-- Recent Study Materials --}}
            <x-filament::card>
                <h3 class="text-lg font-semibold mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-info-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                    </svg>
                    Recent Study Materials
                </h3>
                @if($recentMaterials->isEmpty())
                <div class="text-center py-8">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-2 text-gray-500">No study materials available yet.</p>
                </div>
                @else
                <div class="space-y-2">
                    @foreach($recentMaterials as $material)
                    <a href="{{ route('filament.member.pages.learning-hub') }}"
                        class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-gray-800 rounded-lg hover:bg-gray-100 dark:hover:bg-gray-700 transition group">
                        <div class="p-2 bg-info-100 dark:bg-info-900 rounded">
                            @if($material->file_type === 'pdf')
                            <svg class="w-5 h-5 text-danger-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                            </svg>
                            @elseif(in_array($material->file_type, ['doc', 'docx']))
                            <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-gray-600" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z" />
                            </svg>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <p class="font-medium text-sm truncate group-hover:text-primary-600 dark:group-hover:text-primary-400">
                                {{ $material->title }}
                            </p>
                            <p class="text-xs text-gray-500">
                                {{ $material->category ?? 'General' }} • {{ $material->created_at->diffForHumans() }}
                            </p>
                        </div>
                        <svg class="w-5 h-5 text-gray-400 group-hover:text-primary-600 dark:group-hover:text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                    </a>
                    @endforeach
                </div>
                @endif
            </x-filament::card>
        </div>
    </div>
</x-filament::page>