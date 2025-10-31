<?php if (isset($component)) { $__componentOriginalbe23554f7bded3778895289146189db7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalbe23554f7bded3778895289146189db7 = $attributes; } ?>
<?php $component = Filament\View\LegacyComponents\Page::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('filament::page'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(Filament\View\LegacyComponents\Page::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="space-y-4">
        <!--[if BLOCK]><![endif]--><?php $__empty_1 = true; $__currentLoopData = $this->hubs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $hub): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="p-4 rounded-xl shadow-sm bg-white dark:bg-gray-800 transition-colors hover:shadow-lg">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                <?php echo e($hub->title); ?>

            </h2>

            <!--[if BLOCK]><![endif]--><?php if($hub->description): ?>
            <p class="text-sm text-gray-700 dark:text-gray-300 mb-2">
                <?php echo e($hub->description); ?>

            </p>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->

            <p class="text-xs text-gray-500 dark:text-gray-400 mb-2">
                Type: <span class="text-gray-500 dark:text-gray-400"><?php echo e(strtoupper($hub->type)); ?></span>
            </p>

            <?php
            $files = (array) $hub->file_path;
            $icons = [
            'pdf' => '📄', 'doc' => '📝', 'docx' => '📝',
            'ppt' => '📊', 'pptx' => '📊', 'xls' => '📈', 'xlsx' => '📈',
            'jpg' => '🖼️', 'jpeg' => '🖼️', 'png' => '🖼️',
            'mp4' => '🎬', 'avi' => '🎬',
            'default' => '📁',
            ];
            ?>

            <!--[if BLOCK]><![endif]--><?php if(!empty($files)): ?>
            <div class="flex flex-wrap gap-2">
                <!--[if BLOCK]><![endif]--><?php $__currentLoopData = $files; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                $ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                $icon = $icons[$ext] ?? $icons['default'];
                $url = \Illuminate\Support\Facades\Storage::disk('public')->url($file);
                ?>
                <a href="<?php echo e($url); ?>" target="_blank"
                    class="inline-block text-primary-600 dark:text-primary-400 hover:underline transition-colors">
                    <span><?php echo e($icon); ?></span> <span><?php echo e(basename($file)); ?></span>
                </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><!--[if ENDBLOCK]><![endif]-->
            </div>
            <?php elseif($hub->link_url): ?>
            <a href="<?php echo e($hub->link_url); ?>" target="_blank"
                class="inline-block text-primary-600 dark:text-primary-400 hover:underline transition-colors">
                🔗 Open Link
            </a>
            <?php else: ?>
            <span class="text-gray-400 dark:text-gray-500 text-sm">No file or link available!</span>
            <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-gray-500 dark:text-gray-400 text-center">
            No study materials yet!
        </div>
        <?php endif; ?><!--[if ENDBLOCK]><![endif]-->
    </div>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $attributes = $__attributesOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__attributesOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalbe23554f7bded3778895289146189db7)): ?>
<?php $component = $__componentOriginalbe23554f7bded3778895289146189db7; ?>
<?php unset($__componentOriginalbe23554f7bded3778895289146189db7); ?>
<?php endif; ?><?php /**PATH D:\Android\quizapp1\quizapp-main\quizapp-main\resources\views/filament/member/pages/student-hub.blade.php ENDPATH**/ ?>