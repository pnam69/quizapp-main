<x-filament-panels::page>
    {{-- Header --}}
    <div class="bg-gradient-to-r from-blue-500 to-indigo-600 dark:from-blue-600 dark:to-indigo-700 rounded-xl shadow-lg p-8 text-white mb-6">
        <div class="flex items-center gap-4">
            <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-3xl font-bold">My Homework</h1>
                <p class="text-blue-100 mt-1">View assignments and submit your work</p>
            </div>
        </div>
    </div>

    @if ($showSubmissionForm && $selectedHomework)
    {{-- Submission Form Modal --}}
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeForm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
            wire:click.stop>
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white rounded-t-xl">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $selectedHomework->title }}</h2>
                        <p class="text-blue-100 mt-1">
                            Due: {{ $selectedHomework->due_date->format('M d, Y h:i A') }}
                        </p>
                    </div>
                    <button wire:click="closeForm" class="text-white hover:text-gray-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <div class="p-6 space-y-6">
                {{-- Assignment Details --}}
                @if($selectedHomework->description)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Description</h3>
                    <p class="text-gray-700 dark:text-gray-300">{{ $selectedHomework->description }}</p>
                </div>
                @endif

                @if($selectedHomework->instructions)
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Instructions</h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        {!! $selectedHomework->instructions !!}
                    </div>
                </div>
                @endif

                {{-- Existing Submission or Form --}}
                @php
                $submission = $selectedHomework->submissions->first();
                @endphp

                @if($submission && $submission->status !== 'not_submitted')
                <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-2">
                        Your Submission
                    </h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Submitted:</strong> {{ $submission->submitted_at->format('M d, Y h:i A') }}</p>
                        @if($submission->score !== null)
                        <p><strong>Score:</strong> {{ $submission->score }}/{{ $selectedHomework->max_points }}</p>
                        @endif
                        @if($submission->teacher_feedback)
                        <div class="mt-3">
                            <strong>Teacher Feedback:</strong>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $submission->teacher_feedback }}</p>
                        </div>
                        @endif
                        <div class="mt-3">
                            <strong>Your Answer:</strong>
                            <p class="mt-1 text-gray-700 dark:text-gray-300">{{ $submission->submission_text }}</p>
                        </div>
                    </div>
                </div>
                @else
                {{-- Submission Form --}}
                <form wire:submit.prevent="submitHomework">
                    {{ $this->form }}

                    <div class="flex justify-end gap-3 mt-6">
                        <x-filament::button color="gray" outlined wire:click="closeForm">
                            Cancel
                        </x-filament::button>
                        <x-filament::button type="submit" color="success">
                            Submit Homework
                        </x-filament::button>
                    </div>
                </form>
                @endif
            </div>
        </div>
    </div>
    @endif

    {{-- Homework List --}}
    <div class="grid md:grid-cols-2 gap-6">
        @php
        $pending = $this->getPendingHomework();
        $submitted = $this->getSubmittedHomework();
        $allHomework = $pending->concat($submitted);
        @endphp

        @forelse($allHomework as $item)
        @php
        $submission = $item->submissions->first();
        $isOverdue = now()->gt($item->due_date);
        @endphp

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 
                        {{ $isOverdue && !$submission ? 'border-red-500' : 'border-gray-200 dark:border-gray-700' }}
                        hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            {{ $item->title }}
                        </h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                {{ $item->certification->name }}
                            </span>
                            @if($submission)
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                      {{ $submission->status === 'graded' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300' }}">
                                {{ ucfirst(str_replace('_', ' ', $submission->status)) }}
                            </span>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="{{ $isOverdue && !$submission ? 'text-red-600 font-semibold' : '' }}">
                            Due: {{ $item->due_date->format('M d, Y h:i A') }}
                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Worth: {{ $item->max_points }} points</span>
                    </div>
                    @if($submission && $submission->score !== null)
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <span class="font-semibold {{ $submission->score / $item->max_points >= 0.7 ? 'text-green-600' : 'text-red-600' }}">
                            Score: {{ $submission->score }}/{{ $item->max_points }}
                        </span>
                    </div>
                    @endif
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <x-filament::button
                        wire:click="viewHomework({{ $item->id }})"
                        color="{{ $submission ? 'info' : 'primary' }}"
                        class="w-full"
                        icon="heroicon-o-eye">
                        {{ $submission ? 'View Submission' : 'Submit Homework' }}
                    </x-filament::button>
                </div>
            </div>

            @if($isOverdue && !$submission)
            <div class="bg-red-50 dark:bg-red-900/20 border-t-2 border-red-200 dark:border-red-800 px-6 py-3 rounded-b-xl">
                <p class="text-sm text-red-800 dark:text-red-200 font-medium">
                    ⚠️ This assignment is overdue
                </p>
            </div>
            @endif
        </div>
        @empty
        <div class="col-span-2 text-center py-20">
            <div class="mb-6">
                <div class="mx-auto w-24 h-24 bg-gradient-to-br from-blue-100 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-full flex items-center justify-center">
                    <svg class="w-12 h-12 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                No Homework Assigned
            </h3>
            <p class="text-gray-600 dark:text-gray-400">
                You have no homework assignments at this time.
            </p>
        </div>
        @endforelse
    </div>
</x-filament-panels::page>