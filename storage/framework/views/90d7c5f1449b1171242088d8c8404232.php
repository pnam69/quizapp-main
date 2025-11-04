<?php if (isset($component)) { $__componentOriginal166a02a7c5ef5a9331faf66fa665c256 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament-panels::components.page.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament-panels::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-20 left-10 w-32 h-32 bg-gradient-to-br from-green-400/10 to-emerald-500/10 rounded-full blur-xl animate-pulse"></div>
        <div class="absolute top-40 right-20 w-24 h-24 bg-gradient-to-br from-blue-400/10 to-indigo-500/10 rounded-full blur-xl animate-pulse delay-1000"></div>
        <div class="absolute bottom-32 left-1/4 w-40 h-40 bg-gradient-to-br from-purple-400/10 to-pink-500/10 rounded-full blur-xl animate-pulse delay-2000"></div>
        <div class="absolute bottom-20 right-10 w-28 h-28 bg-gradient-to-br from-yellow-400/10 to-orange-500/10 rounded-full blur-xl animate-pulse delay-3000"></div>
    </div>

    <div class="max-w-7xl mx-auto space-y-6 px-4 sm:px-6 lg:px-8 py-8">
        <!--[if BLOCK]><![endif]--><?php if(!$selectedAttempt): ?>
        
        <div class="bg-gradient-to-r from-green-500 to-emerald-600 dark:from-green-600 dark:to-emerald-700 rounded-xl shadow-lg p-8 text-white mb-6">
            <div class="flex items-center gap-4 mb-2">
                <div class="bg-white/20 backdrop-blur-sm rounded-lg p-3">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold">My Test Results</h1>
                    <p class="text-green-100 mt-1">Review your completed assessments and performance</p>
                </div>
            </div>
            <div class="flex gap-4 text-sm mt-4">
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                    ✓<?php echo e($assessmentAttempts->count()); ?> Assessment<?php echo e($assessmentAttempts->count() !== 1 ? 's' : ''); ?> Completed
                </div>
                <!--[if BLOCK]><![endif]--><?php if($assessmentAttempts->count() > 0): ?>
                <div class="bg-white/10 backdrop-blur-sm rounded-lg px-3 py-2">
                    📊 Average Score: <?php echo e(round($assessmentAttempts->avg('score'), 1)); ?>/<?php echo e($assessmentAttempts->first()->total_points ?? 100); ?>

                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        
        <!--[if BLOCK]><![endif]--><?php if($assessmentAttempts->count() > 0): ?>
        <div class="grid md:grid-cols-4 gap-4 mb-6">
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-blue-200 dark:border-blue-800">
                <div class="flex items-center gap-3">
                    <div class="bg-blue-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-blue-900 dark:text-blue-100"><?php echo e($assessmentAttempts->count()); ?></div>
                        <div class="text-sm text-blue-700 dark:text-blue-300">Tests Completed</div>
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
                        <div class="text-2xl font-bold text-green-900 dark:text-green-100"><?php echo e(round($assessmentAttempts->avg('score'), 1)); ?></div>
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
                        <div class="text-2xl font-bold text-purple-900 dark:text-purple-100"><?php echo e($assessmentAttempts->max('score')); ?></div>
                        <div class="text-sm text-purple-700 dark:text-purple-300">Best Score</div>
                    </div>
                </div>
            </div>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6 border-2 border-orange-200 dark:border-orange-800">
                <div class="flex items-center gap-3">
                    <div class="bg-orange-500 text-white rounded-lg p-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-orange-900 dark:text-orange-100"><?php echo e($assessmentAttempts->where('passed', true)->count()); ?></div>
                        <div class="text-sm text-orange-700 dark:text-orange-300">Tests Passed</div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

        
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $assessmentAttempts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attempt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php
            $percentage = $attempt->total_points > 0 ? round(($attempt->score / $attempt->total_points) * 100, 1) : 0;
            $scoreColor = $percentage >= 80 ? 'green' : ($percentage >= 60 ? 'yellow' : 'red');
            ?>
            <div class="p-6 border-b border-gray-200 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition-all duration-200">
                <div class="flex items-start justify-between gap-6">
                    <div class="flex-1">
                        <div class="flex items-start gap-4">
                            <div class="bg-gradient-to-br from-<?php echo e($scoreColor); ?>-500 to-<?php echo e($scoreColor); ?>-600 text-white rounded-lg p-3 shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100">
                                    <?php echo e($attempt->assessment->title); ?>

                                </h3>
                                <div class="flex flex-wrap gap-3 mt-3">
                                    <div class="inline-flex items-center gap-1.5 bg-<?php echo e($scoreColor); ?>-100 dark:bg-<?php echo e($scoreColor); ?>-900/30 text-<?php echo e($scoreColor); ?>-700 dark:text-<?php echo e($scoreColor); ?>-300 px-3 py-1 rounded-full text-sm font-bold">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                        </svg>
                                        Score: <?php echo e($attempt->score); ?>/<?php echo e($attempt->total_points); ?> (<?php echo e($percentage); ?>%)
                                    </div>
                                    <!--[if BLOCK]><![endif]--><?php if($attempt->passed !== null): ?>
                                    <div class="inline-flex items-center gap-1.5 bg-<?php echo e($attempt->passed ? 'green' : 'red'); ?>-100 dark:bg-<?php echo e($attempt->passed ? 'green' : 'red'); ?>-900/30 text-<?php echo e($attempt->passed ? 'green' : 'red'); ?>-700 dark:text-<?php echo e($attempt->passed ? 'green' : 'red'); ?>-300 px-3 py-1 rounded-full text-sm font-bold">
                                        <?php echo e($attempt->passed ? 'Passed' : 'Failed'); ?>

                                    </div>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <div class="inline-flex items-center gap-1.5 bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300 px-3 py-1 rounded-full text-sm font-medium">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                        </svg>
                                        <?php echo e($attempt->submitted_at->format('M d, Y g:i A')); ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'primary','wire:click' => 'viewAttempt('.e($attempt->id).')','icon' => 'heroicon-o-eye']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'primary','wire:click' => 'viewAttempt('.e($attempt->id).')','icon' => 'heroicon-o-eye']); ?>
                            View Details
                         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="text-center py-20">
                <div class="mb-6">
                    <div class="mx-auto w-24 h-24 bg-gradient-to-br from-green-100 to-emerald-100 dark:from-green-900/20 dark:to-emerald-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-12 h-12 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                    No Completed Assessments
                </h3>
                <p class="text-gray-600 dark:text-gray-400 mb-6">
                    You haven't completed any assessments yet. Take a test to see your results here!
                </p>
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'primary','tag' => 'a','href' => ''.e(route('filament.member.pages.take-test')).'','icon' => 'heroicon-o-play']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'primary','tag' => 'a','href' => ''.e(route('filament.member.pages.take-test')).'','icon' => 'heroicon-o-play']); ?>
                    Take a Test
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <?php else: ?>
        
        <div class="space-y-6">
            
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg p-6">
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'gray','wire:click' => 'backToList','icon' => 'heroicon-o-arrow-left','class' => 'mb-4']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','wire:click' => 'backToList','icon' => 'heroicon-o-arrow-left','class' => 'mb-4']); ?>
                    Back to Results
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $attributes = $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__attributesOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f)): ?>
<?php $component = $__componentOriginal6330f08526bbb3ce2a0da37da512a11f; ?>
<?php unset($__componentOriginal6330f08526bbb3ce2a0da37da512a11f); ?>
<?php endif; ?>

                <?php
                $percentage = $selectedAttempt->total_points > 0 ? round(($selectedAttempt->score / $selectedAttempt->total_points) * 100, 1) : 0;
                ?>

                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-4"><?php echo e($selectedAttempt->assessment->title); ?></h2>

                <div class="grid md:grid-cols-3 gap-4 mb-6">
                    <div class="bg-gradient-to-br from-blue-50 to-indigo-50 dark:from-blue-900/20 dark:to-indigo-900/20 rounded-xl p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Your Score</div>
                        <div class="text-3xl font-bold text-blue-900 dark:text-blue-100"><?php echo e($selectedAttempt->score); ?>/<?php echo e($selectedAttempt->total_points); ?></div>
                        <div class="text-sm text-blue-700 dark:text-blue-300 mt-1"><?php echo e($percentage); ?>%</div>
                    </div>
                    <div class="bg-gradient-to-br from-green-50 to-emerald-50 dark:from-green-900/20 dark:to-emerald-900/20 rounded-xl p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Status</div>
                        <div class="text-2xl font-bold text-green-900 dark:text-green-100">
                            <?php echo e($selectedAttempt->passed ? 'Passed ✓' : 'Failed ✗'); ?>

                        </div>
                        <div class="text-sm text-green-700 dark:text-green-300 mt-1">
                            Passing: <?php echo e($selectedAttempt->assessment->passing_score); ?>%
                        </div>
                    </div>
                    <div class="bg-gradient-to-br from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-6">
                        <div class="text-sm text-gray-600 dark:text-gray-400 mb-1">Completed</div>
                        <div class="text-lg font-bold text-purple-900 dark:text-purple-100">
                            <?php echo e($selectedAttempt->submitted_at->format('M d, Y')); ?>

                        </div>
                        <div class="text-sm text-purple-700 dark:text-purple-300 mt-1">
                            <?php echo e($selectedAttempt->submitted_at->format('g:i A')); ?>

                        </div>
                    </div>
                </div>
            </div>

            
            <div class="space-y-4">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedAttempt->assessment->questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $userAnswer = $selectedAttempt->attemptAnswers->firstWhere('question_id', $question->id);
                $selectedOptions = $userAnswer->selected_options ?? [];
                $correctOption = $question->options->firstWhere('is_correct', true);
                ?>
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden border-2 <?php echo e($userAnswer->is_correct ? 'border-green-500' : 'border-red-500'); ?>">
                    <div class="p-6">
                        <div class="flex items-start gap-3 mb-4">
                            <div class="rounded-full w-10 h-10 flex items-center justify-center font-bold text-lg shrink-0 <?php echo e($userAnswer->is_correct ? 'bg-green-500 text-white' : 'bg-red-500 text-white'); ?>">
                                <?php echo e($index + 1); ?>

                            </div>
                            <div class="flex-1">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                    <?php echo e($question->question_text); ?>

                                </h3>
                                <div class="mt-2 inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-medium <?php echo e($userAnswer->is_correct ? 'bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-300' : 'bg-red-100 dark:bg-red-900/30 text-red-700 dark:text-red-300'); ?>">
                                    <?php echo e($userAnswer->is_correct ? '✓ Correct' : '✗ Incorrect'); ?>

                                    <span class="ml-2"><?php echo e($userAnswer->points_earned); ?>/<?php echo e($question->points); ?> pts</span>
                                </div>
                            </div>
                        </div>

                        <div class="space-y-3">
                            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question->options; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php
                            $isSelected = in_array($option->id, $selectedOptions);
                            $isCorrect = $option->is_correct;
                            ?>
                            <div class="flex items-start p-4 border-2 rounded-xl <?php echo e($isCorrect ? 'border-green-500 bg-green-50 dark:bg-green-900/30' : ($isSelected ? 'border-red-500 bg-red-50 dark:bg-red-900/30' : 'border-gray-200 dark:border-gray-700')); ?>">
                                <div class="flex items-center gap-4 w-full">
                                    <div class="shrink-0 w-10 h-10 rounded-full border-2 flex items-center justify-center font-bold text-sm <?php echo e($isCorrect ? 'border-green-500 bg-green-500 text-white' : ($isSelected ? 'border-red-500 bg-red-500 text-white' : 'border-gray-300 dark:border-gray-600 text-gray-500 dark:text-gray-400')); ?>">
                                        <!--[if BLOCK]><![endif]--><?php if($isCorrect): ?>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                        <?php elseif($isSelected): ?>
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                        </svg>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                    <div class="flex-1">
                                        <span class="text-base <?php echo e($isCorrect ? 'text-green-700 dark:text-green-300 font-medium' : ($isSelected ? 'text-red-700 dark:text-red-300 font-medium' : 'text-gray-700 dark:text-gray-300')); ?>">
                                            <?php echo e($option->option_text); ?>

                                        </span>
                                        <!--[if BLOCK]><![endif]--><?php if($isCorrect): ?>
                                        <span class="ml-2 text-xs text-green-600 dark:text-green-400 font-semibold">✓ Correct Answer</span>
                                        <?php elseif($isSelected): ?>
                                        <span class="ml-2 text-xs text-red-600 dark:text-red-400 font-semibold">✗ Your Answer</span>
                                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    </div>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH D:\Android\quizapp1\quizapp-main\quizapp-main\resources\views/filament/member/pages/my-results.blade.php ENDPATH**/ ?>