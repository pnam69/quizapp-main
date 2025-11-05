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

    <!--[if BLOCK]><![endif]--><?php if($showSubmissionForm && $selectedHomework): ?>
    
    <div class="fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4" wire:click="closeForm">
        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl max-w-3xl w-full max-h-[90vh] overflow-y-auto"
            wire:click.stop>
            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white rounded-t-xl">
                <div class="flex justify-between items-start">
                    <div>
                        <h2 class="text-2xl font-bold"><?php echo e($selectedHomework->title); ?></h2>
                        <p class="text-blue-100 mt-1">
                            Due: <?php echo e($selectedHomework->due_date->format('M d, Y h:i A')); ?>

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
                
                <!--[if BLOCK]><![endif]--><?php if($selectedHomework->description): ?>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Description</h3>
                    <p class="text-gray-700 dark:text-gray-300"><?php echo e($selectedHomework->description); ?></p>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                <!--[if BLOCK]><![endif]--><?php if($selectedHomework->instructions): ?>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">Instructions</h3>
                    <div class="prose dark:prose-invert max-w-none text-gray-700 dark:text-gray-300">
                        <?php echo $selectedHomework->instructions; ?>

                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <!--[if BLOCK]><![endif]--><?php if($selectedHomework->attachments && count($selectedHomework->attachments) > 0): ?>
                <div class="bg-blue-50 dark:bg-blue-900/20 border-2 border-blue-200 dark:border-blue-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-blue-900 dark:text-blue-100 mb-3 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"></path>
                        </svg>
                        Assignment Files
                    </h3>
                    <div class="grid gap-2">
                        <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $selectedHomework->attachments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                        $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                        $icons = [
                        'pdf' => '📄', 'doc' => '📝', 'docx' => '📝',
                        'xls' => '📈', 'xlsx' => '📈',
                        'ppt' => '📊', 'pptx' => '📊',
                        'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️', 'gif' => '🖼️',
                        'txt' => '📃',
                        'default' => '📁',
                        ];
                        $icon = $icons[$ext] ?? $icons['default'];
                        $url = asset('storage/' . $file);
                        $fileName = basename($file);
                        ?>
                        <a href="<?php echo e($url); ?>" target="_blank" download
                            class="flex items-center gap-3 p-3 bg-white dark:bg-gray-700/50 rounded-lg hover:bg-blue-100 dark:hover:bg-blue-900/30 transition-colors group">
                            <span class="text-2xl"><?php echo e($icon); ?></span>
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                    <?php echo e($fileName); ?>

                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    <?php echo e(strtoupper($ext)); ?> File • Click to download
                                </p>
                            </div>
                            <svg class="w-5 h-5 text-blue-500 group-hover:text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                            </svg>
                        </a>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

                
                <?php
                $submission = $selectedHomework->submissions->first();
                ?>

                <!--[if BLOCK]><![endif]--><?php if($submission && $submission->status !== 'not_submitted'): ?>
                <div class="bg-green-50 dark:bg-green-900/20 border-2 border-green-200 dark:border-green-800 rounded-lg p-4">
                    <h3 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-2">
                        Your Submission
                    </h3>
                    <div class="space-y-2 text-sm">
                        <p><strong>Submitted:</strong> <?php echo e($submission->submitted_at->format('M d, Y h:i A')); ?></p>
                        <p><strong>Status:</strong>
                            <span class="px-2 py-1 rounded-full text-xs font-medium
                                <?php echo e($submission->status === 'graded' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $submission->status))); ?>

                            </span>
                        </p>
                        <!--[if BLOCK]><![endif]--><?php if($submission->score !== null): ?>
                        <p><strong>Score:</strong> <?php echo e($submission->score); ?>/<?php echo e($selectedHomework->max_points); ?></p>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <!--[if BLOCK]><![endif]--><?php if($submission->teacher_feedback): ?>
                        <div class="mt-3">
                            <strong>Teacher Feedback:</strong>
                            <p class="mt-1 text-gray-700 dark:text-gray-300"><?php echo e($submission->teacher_feedback); ?></p>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        <div class="mt-3">
                            <strong>Your Answer:</strong>
                            <p class="mt-1 text-gray-700 dark:text-gray-300 whitespace-pre-wrap"><?php echo e($submission->submission_text); ?></p>
                        </div>

                        <!--[if BLOCK]><![endif]--><?php if($submission->submitted_files && count($submission->submitted_files) > 0): ?>
                        <div class="mt-4">
                            <strong>Uploaded Files:</strong>
                            <div class="grid gap-2 mt-2">
                                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $submission->submitted_files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <?php
                                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                $icons = [
                                'pdf' => '📄', 'doc' => '📝', 'docx' => '📝',
                                'xls' => '📈', 'xlsx' => '📈',
                                'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️',
                                'txt' => '📃',
                                'default' => '📁',
                                ];
                                $icon = $icons[$ext] ?? $icons['default'];
                                $url = asset('storage/' . $file);
                                $fileName = basename($file);
                                ?>
                                <a href="<?php echo e($url); ?>" target="_blank"
                                    class="flex items-center gap-3 p-3 bg-white dark:bg-gray-700/50 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 transition-colors">
                                    <span class="text-2xl"><?php echo e($icon); ?></span>
                                    <div class="flex-1 min-w-0">
                                        <p class="text-sm font-medium text-gray-900 dark:text-gray-100 truncate">
                                            <?php echo e($fileName); ?>

                                        </p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">
                                            <?php echo e(strtoupper($ext)); ?> File
                                        </p>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                                    </svg>
                                </a>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                            </div>
                        </div>
                        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                    </div>
                </div>
                <?php else: ?>
                
                <form wire:submit.prevent="submitHomework">
                    <?php echo e($this->form); ?>


                    <div class="flex justify-end gap-3 mt-6">
                        <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'gray','outlined' => true,'wire:click' => 'closeForm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'gray','outlined' => true,'wire:click' => 'closeForm']); ?>
                            Cancel
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
                        <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['type' => 'submit','color' => 'success']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['type' => 'submit','color' => 'success']); ?>
                            Submit Homework
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
                </form>
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </div>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

    
    <div class="grid md:grid-cols-2 gap-6">
        <?php
        $pending = $this->getPendingHomework();
        $submitted = $this->getSubmittedHomework();
        $allHomework = $pending->concat($submitted);
        ?>

        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $allHomework; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php
        $submission = $item->submissions->first();
        $isOverdue = now()->gt($item->due_date);
        ?>

        <div class="bg-white dark:bg-gray-800 rounded-xl shadow-lg border-2 
                        <?php echo e($isOverdue && !$submission ? 'border-red-500' : 'border-gray-200 dark:border-gray-700'); ?>

                        hover:shadow-xl transition-shadow duration-200">
            <div class="p-6">
                <div class="flex justify-between items-start mb-4">
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                            <?php echo e($item->title); ?>

                        </h3>
                        <div class="flex flex-wrap gap-2 mb-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-blue-100 dark:bg-blue-900/30 text-blue-700 dark:text-blue-300">
                                📚 <?php echo e($item->certification->name); ?>

                            </span>
                            <!--[if BLOCK]><![endif]--><?php if($submission): ?>
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium 
                                      <?php echo e($submission->status === 'graded' ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300' : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300'); ?>">
                                <?php echo e(ucfirst(str_replace('_', ' ', $submission->status))); ?>

                            </span>
                            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                        </div>
                    </div>
                </div>

                <div class="space-y-2 text-sm text-gray-600 dark:text-gray-400 mb-4">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="<?php echo e($isOverdue && !$submission ? 'text-red-600 font-semibold' : ''); ?>">
                            Due: <?php echo e($item->due_date->format('M d, Y h:i A')); ?>

                        </span>
                    </div>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Worth: <?php echo e($item->max_points); ?> points</span>
                    </div>
                    <!--[if BLOCK]><![endif]--><?php if($submission && $submission->score !== null): ?>
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                        </svg>
                        <span class="font-semibold <?php echo e($submission->score / $item->max_points >= 0.7 ? 'text-green-600' : 'text-red-600'); ?>">
                            Score: <?php echo e($submission->score); ?>/<?php echo e($item->max_points); ?>

                        </span>
                    </div>
                    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
                </div>

                <div class="pt-4 border-t border-gray-200 dark:border-gray-700">
                    <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['wire:click' => 'viewHomework('.e($item->id).')','color' => ''.e($submission ? 'info' : 'primary').'','class' => 'w-full','icon' => 'heroicon-o-eye']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'viewHomework('.e($item->id).')','color' => ''.e($submission ? 'info' : 'primary').'','class' => 'w-full','icon' => 'heroicon-o-eye']); ?>
                        <?php echo e($submission ? 'View Submission' : 'Submit Homework'); ?>

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

            <!--[if BLOCK]><![endif]--><?php if($isOverdue && !$submission): ?>
            <div class="bg-red-50 dark:bg-red-900/20 border-t-2 border-red-200 dark:border-red-800 px-6 py-3 rounded-b-xl">
                <p class="text-sm text-red-800 dark:text-red-200 font-medium">
                    ⚠️ This assignment is overdue
                </p>
            </div>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
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
<?php endif; ?><?php /**PATH D:\Android\quizapp1\quizapp-main\quizapp-main\resources\views/filament/member/pages/my-homework.blade.php ENDPATH**/ ?>