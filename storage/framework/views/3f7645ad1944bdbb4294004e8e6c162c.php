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
    <!--[if BLOCK]><![endif]--><?php if(!$selectedTest): ?>
    <div class="space-y-6">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $tests; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $test): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-5 rounded-xl shadow-sm border border-gray-200 bg-white dark:bg-gray-900 flex justify-between items-center hover:shadow-md transition">
            <div>
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                    <?php echo e($test->name ?? 'Untitled Test'); ?>

                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Questions: <?php echo e(is_string($test->question_ids) ? count(json_decode($test->question_ids)) : count($test->question_ids)); ?>

                </p>
            </div>
            <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'primary','wire:click' => 'selectTest('.e($test->id).')']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'primary','wire:click' => 'selectTest('.e($test->id).')']); ?>
                Start Test
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
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <p class="text-gray-500 dark:text-gray-400 text-center">
            No active tests available.
        </p>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
    <?php else: ?>
    <div class="space-y-6">
        <div class="p-6 rounded-xl shadow-md border border-gray-200 bg-white dark:bg-gray-900">
            <h2 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-2">
                <?php echo e($selectedTest->name ?? 'Test'); ?>

            </h2>

            <!--[if BLOCK]><![endif]--><?php if(empty($results)): ?>
            <p class="text-sm text-gray-500">
                Answer all questions carefully and click <strong>Submit</strong> when done.
            </p>
            <?php else: ?>
            <?php
            $total = count($questions);
            $correct = collect($results)->where('isCorrect', true)->count();
            $score = $total ? round(($correct / $total) * 100, 2) : 0;
            ?>
            <p class="text-sm font-semibold text-gray-700 dark:text-gray-300">
                You scored <span class="text-green-600 dark:text-green-400"><?php echo e($score); ?>%</span> (<?php echo e($correct); ?>/<?php echo e($total); ?>)
            </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>

        <form wire:submit.prevent="submit" class="space-y-6">
            <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $questions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $question): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php
            $isAnswered = isset($results[$question->id]);
            $chosen = $results[$question->id]['chosen'] ?? null;
            $correct = $results[$question->id]['correct'] ?? null;
            ?>
            <div class="p-5 rounded-lg border border-gray-200 bg-white dark:bg-gray-800 shadow-sm">
                <p class="font-semibold text-gray-900 dark:text-gray-100 mb-3">
                    <?php echo e($index + 1); ?>. <?php echo e($question->question); ?>

                </p>
                <div class="space-y-2">
                    <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $question->answers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $option): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                    $optionClass = '';
                    if ($isAnswered) {
                    if ($option->id == $correct) {
                    $optionClass = 'bg-green-100 dark:bg-green-700 border-green-400';
                    } elseif ($option->id == $chosen) {
                    $optionClass = 'bg-red-100 dark:bg-red-700 border-red-400';
                    }
                    }
                    ?>
                    <label class="flex items-center space-x-2 cursor-pointer border px-3 py-2 rounded <?php echo e($optionClass); ?>">
                        <input type="radio"
                            wire:model="answers.<?php echo e($question->id); ?>"
                            value="<?php echo e($option->id); ?>"
                            class="text-primary-600 focus:ring-primary-500"
                            <?php echo e($isAnswered ? 'disabled' : ''); ?>>
                        <span class="text-gray-700 dark:text-gray-300"><?php echo e($option->answer); ?></span>
                    </label>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->

            <div class="flex justify-between pt-4">
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'secondary','wire:click' => 'resetTest']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'secondary','wire:click' => 'resetTest']); ?>
                    Back
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
                <!--[if BLOCK]><![endif]--><?php if(empty($results)): ?>
                <?php if (isset($component)) { $__componentOriginal6330f08526bbb3ce2a0da37da512a11f = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal6330f08526bbb3ce2a0da37da512a11f = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'filament::components.button.index','data' => ['color' => 'success','type' => 'submit']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Illuminate\View\AnonymousComponent::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => 'success','type' => 'submit']); ?>
                    Submit Test
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
                <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
            </div>
        </form>
    </div>
    <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $attributes = $__attributesOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__attributesOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256)): ?>
<?php $component = $__componentOriginal166a02a7c5ef5a9331faf66fa665c256; ?>
<?php unset($__componentOriginal166a02a7c5ef5a9331faf66fa665c256); ?>
<?php endif; ?><?php /**PATH D:\Android\quizapp1\quizapp-main\quizapp-main\resources\views/filament/member/pages/take-test.blade.php ENDPATH**/ ?>