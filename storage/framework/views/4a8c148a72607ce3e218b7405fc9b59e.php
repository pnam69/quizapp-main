<div class="space-y-6">
    
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
                        <h2 class="text-2xl font-bold text-white"><?php echo e($record->user->name); ?></h2>
                        <p class="text-blue-100 dark:text-blue-200 text-sm"><?php echo e($record->user->email); ?></p>
                    </div>
                </div>

                <?php
                $gradeLabel = $record->percentage >= 70 ? 'PASSED' : ($record->percentage >= 50 ? 'NEEDS IMPROVEMENT' : 'FAILED');
                $gradeBgColor = $record->percentage >= 70 ? 'bg-green-500/20' : ($record->percentage >= 50 ? 'bg-yellow-500/20' : 'bg-red-500/20');
                $gradeBorderColor = $record->percentage >= 70 ? 'border-green-400/50' : ($record->percentage >= 50 ? 'border-yellow-400/50' : 'border-red-400/50');
                $gradeTextColor = $record->percentage >= 70 ? 'text-green-300' : ($record->percentage >= 50 ? 'text-yellow-300' : 'text-red-300');
                ?>

                <div class="mt-4 flex items-center gap-3">
                    <span class="inline-flex items-center gap-2 px-4 py-2 <?php echo e($gradeBgColor); ?> backdrop-blur-sm border <?php echo e($gradeBorderColor); ?> rounded-lg <?php echo e($gradeTextColor); ?> text-sm font-semibold">
                        <!--[if BLOCK]><![endif]--><?php if($record->percentage >= 70): ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php elseif($record->percentage >= 50): ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <?php else: ?>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <?php echo e($gradeLabel); ?>

                    </span>
                    <span class="text-white/80 text-sm"><?php echo e($record->assessment->title); ?></span>
                </div>
            </div>

            <div class="text-right">
                <div class="inline-flex flex-col items-center justify-center w-28 h-28 bg-white dark:bg-slate-900 rounded-2xl shadow-xl border border-slate-200 dark:border-slate-700">
                    <div class="text-4xl font-black text-slate-900 dark:text-white">
                        <?php echo e(round($record->percentage, 1)); ?>%
                    </div>
                    <div class="text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wide mt-1">Score</div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        
        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border-2 <?php echo e($record->percentage >= 70 ? 'border-green-500/20' : ($record->percentage >= 50 ? 'border-yellow-500/20' : 'border-red-500/20')); ?> shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg <?php echo e($record->percentage >= 70 ? 'bg-green-100 dark:bg-green-900/50' : ($record->percentage >= 50 ? 'bg-yellow-100 dark:bg-yellow-900/50' : 'bg-red-100 dark:bg-red-900/50')); ?> flex items-center justify-center">
                    <svg class="w-5 h-5 <?php echo e($record->percentage >= 70 ? 'text-green-600 dark:text-green-400' : ($record->percentage >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400')); ?>" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold <?php echo e($record->percentage >= 70 ? 'text-green-600 dark:text-green-400' : ($record->percentage >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400')); ?>">
                <?php echo e(round($record->percentage, 1)); ?>%
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Final Score</div>
        </div>

        
        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border-2 border-purple-500/20 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-purple-100 dark:bg-purple-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">
                <!--[if BLOCK]><![endif]--><?php if($record->started_at && $record->submitted_at): ?>
                <?php echo e($record->started_at->diffInMinutes($record->submitted_at)); ?>

                <?php else: ?>
                --
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Minutes Spent</div>
        </div>

        
        <div class="bg-white dark:bg-slate-900 rounded-xl p-5 border-2 border-indigo-500/20 shadow-sm">
            <div class="flex items-center justify-between mb-3">
                <div class="w-10 h-10 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                    <svg class="w-5 h-5 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
            </div>
            <div class="text-3xl font-bold text-slate-900 dark:text-white">
                <?php echo e($record->attemptAnswers->where('is_correct', true)->count()); ?><span class="text-lg text-slate-500 dark:text-slate-400">/<?php echo e($record->attemptAnswers->count()); ?></span>
            </div>
            <div class="text-sm text-slate-600 dark:text-slate-400 font-medium mt-1">Correct Answers</div>
        </div>
    </div>

    
    <div class="bg-gradient-to-r from-slate-100 to-slate-50 dark:from-slate-900 dark:to-slate-800 rounded-xl p-5 border border-slate-200 dark:border-slate-700">
        <h3 class="text-sm font-semibold text-slate-900 dark:text-white mb-3 flex items-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            Grading Scale
        </h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-600">
                <div class="w-3 h-3 rounded-full bg-green-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Passed</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">70% and above</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-600">
                <div class="w-3 h-3 rounded-full bg-yellow-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Needs Improvement</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">50% - 69%</div>
                </div>
            </div>
            <div class="flex items-center gap-3 bg-white dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-600">
                <div class="w-3 h-3 rounded-full bg-red-500"></div>
                <div>
                    <div class="text-sm font-semibold text-slate-900 dark:text-white">Failed</div>
                    <div class="text-xs text-slate-600 dark:text-slate-400">Below 50%</div>
                </div>
            </div>
        </div>
    </div>

    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-blue-100 dark:bg-blue-900/50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900 dark:text-white">Student Information</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-start justify-between py-2">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Name</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->user->name); ?></span>
                </div>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Email</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->user->email); ?></span>
                </div>
                <!--[if BLOCK]><![endif]--><?php if($record->user->classrooms->count() > 0): ?>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Classroom</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->user->classrooms->pluck('name')->join(', ')); ?></span>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($record->user->sections->count() > 0): ?>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Faculty</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->user->sections->pluck('name')->join(', ')); ?></span>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                <!--[if BLOCK]><![endif]--><?php if($record->user->certifications->count() > 0): ?>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Department</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->user->certifications->pluck('name')->join(', ')); ?></span>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>

        
        <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 p-5 shadow-sm">
            <div class="flex items-center gap-2 mb-4">
                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-900/50 flex items-center justify-center">
                    <svg class="w-4 h-4 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-slate-900 dark:text-white">Assessment Information</h3>
            </div>
            <div class="space-y-3">
                <div class="flex items-start justify-between py-2">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Title</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white text-right"><?php echo e($record->assessment->title); ?></span>
                </div>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Date</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($record->submitted_at->format('M d, Y')); ?></span>
                </div>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Time</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white"><?php echo e($record->submitted_at->format('h:i A')); ?></span>
                </div>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Duration</span>
                    <span class="text-sm font-medium text-slate-900 dark:text-white">
                        <!--[if BLOCK]><![endif]--><?php if($record->started_at && $record->submitted_at): ?>
                        <?php echo e($record->started_at->diffInMinutes($record->submitted_at)); ?> minutes
                        <?php else: ?>
                        Not tracked
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </span>
                </div>
                <div class="flex items-start justify-between py-2 border-t border-slate-100 dark:border-slate-700">
                    <span class="text-sm text-slate-600 dark:text-slate-400">Status</span>
                    <span class="text-sm font-medium capitalize text-slate-900 dark:text-white"><?php echo e($record->status); ?></span>
                </div>
            </div>
        </div>
    </div>

    
    <!--[if BLOCK]><![endif]--><?php if($record->attemptAnswers->count() > 0): ?>
    <div class="bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden shadow-sm">
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 dark:from-slate-800 dark:to-slate-700 px-5 py-4 border-b border-slate-200 dark:border-slate-600">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-2">
                    <div class="w-8 h-8 rounded-lg bg-blue-600 dark:bg-blue-700 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <h3 class="text-base font-semibold text-slate-900 dark:text-white">Answer Review</h3>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-green-500"></div>
                        <span class="text-sm text-slate-700 dark:text-slate-300"><?php echo e($record->attemptAnswers->where('is_correct', true)->count()); ?> Correct</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="w-2 h-2 rounded-full bg-red-500"></div>
                        <span class="text-sm text-slate-700 dark:text-slate-300"><?php echo e($record->attemptAnswers->where('is_correct', false)->count()); ?> Incorrect</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="p-5 max-h-[500px] overflow-y-auto">
            <div class="space-y-3">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $record->attemptAnswers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $answer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="bg-slate-50 dark:bg-slate-800/50 rounded-xl p-4 border <?php echo e($answer->is_correct ? 'border-green-200 dark:border-green-900/50' : 'border-red-200 dark:border-red-900/50'); ?>">
                    <div class="flex items-start gap-3">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 rounded-lg <?php echo e($answer->is_correct ? 'bg-green-100 dark:bg-green-900/50' : 'bg-red-100 dark:bg-red-900/50'); ?> flex items-center justify-center">
                                <span class="text-sm font-bold <?php echo e($answer->is_correct ? 'text-green-700 dark:text-green-400' : 'text-red-700 dark:text-red-400'); ?>">
                                    <?php echo e($index + 1); ?>

                                </span>
                            </div>
                        </div>

                        <div class="flex-1 min-w-0">
                            <div class="flex items-start justify-between gap-3 mb-2">
                                <p class="text-sm font-medium text-slate-900 dark:text-white leading-relaxed">
                                    <?php echo e($answer->question->question_text); ?>

                                </p>
                                <div class="flex-shrink-0 flex items-center gap-2">
                                    <!--[if BLOCK]><![endif]--><?php if($answer->is_correct): ?>
                                    <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <?php else: ?>
                                    <svg class="w-5 h-5 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                                    <span class="text-sm font-bold <?php echo e($answer->is_correct ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400'); ?>">
                                        <?php echo e(intval($answer->points_earned ?? 0)); ?> pts
                                    </span>
                                </div>
                            </div>

                            <!--[if BLOCK]><![endif]--><?php if($answer->selectedOption): ?>
                            <div class="mt-2 bg-white dark:bg-slate-800 rounded-lg p-3 border border-slate-200 dark:border-slate-700">
                                <div class="flex items-center gap-2 mb-1">
                                    <svg class="w-3.5 h-3.5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                    <span class="text-xs font-semibold text-slate-600 dark:text-slate-400 uppercase tracking-wider">Answer</span>
                                </div>
                                <p class="text-sm text-slate-900 dark:text-white">
                                    <?php echo e($answer->selectedOption->option_text); ?>

                                </p>
                            </div>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
</div><?php /**PATH D:\Android\quizapp1\quizapp-main\quizapp-main\resources\views/filament/resources/student-grades/view-grade.blade.php ENDPATH**/ ?>