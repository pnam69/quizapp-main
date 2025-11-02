<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Homework;
use App\Models\HomeworkSubmission;
use App\Models\Test;
use App\Models\QuizHeader;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SystemHealthCheck extends Command
{
    protected $signature = 'system:health-check';
    protected $description = 'Run health checks on the school management system';

    public function handle()
    {
        $this->info('🏥 Running System Health Check...');
        $this->newLine();

        $allPassed = true;

        // Database Connection
        $allPassed = $this->checkDatabase() && $allPassed;
        
        // Storage Permissions
        $allPassed = $this->checkStorage() && $allPassed;
        
        // Models & Tables
        $allPassed = $this->checkModels() && $allPassed;
        
        // File Upload Directories
        $allPassed = $this->checkFileDirectories() && $allPassed;
        
        // Critical Configuration
        $allPassed = $this->checkConfiguration() && $allPassed;
        
        // Security Settings
        $allPassed = $this->checkSecurity() && $allPassed;

        $this->newLine();
        if ($allPassed) {
            $this->info('✅ All health checks passed!');
            return Command::SUCCESS;
        } else {
            $this->error('❌ Some health checks failed. Please review the output above.');
            return Command::FAILURE;
        }
    }

    private function checkDatabase(): bool
    {
        $this->line('📊 Checking Database Connection...');
        
        try {
            DB::connection()->getPdo();
            $this->info('  ✓ Database connection successful');
            
            // Check critical tables
            $tables = ['users', 'homework', 'homework_submissions', 'tests', 'quiz_headers'];
            foreach ($tables as $table) {
                if (DB::getSchemaBuilder()->hasTable($table)) {
                    $count = DB::table($table)->count();
                    $this->info("  ✓ Table '{$table}' exists ({$count} records)");
                } else {
                    $this->error("  ✗ Table '{$table}' does not exist");
                    return false;
                }
            }
            
            return true;
        } catch (\Exception $e) {
            $this->error('  ✗ Database connection failed: ' . $e->getMessage());
            return false;
        }
    }

    private function checkStorage(): bool
    {
        $this->line('💾 Checking Storage Permissions...');
        
        $directories = [
            'storage/app',
            'storage/logs',
            'storage/framework/cache',
            'bootstrap/cache',
        ];

        $allWritable = true;
        foreach ($directories as $dir) {
            $path = base_path($dir);
            if (is_writable($path)) {
                $this->info("  ✓ {$dir} is writable");
            } else {
                $this->error("  ✗ {$dir} is NOT writable");
                $allWritable = false;
            }
        }

        return $allWritable;
    }

    private function checkModels(): bool
    {
        $this->line('🗂️  Checking Models...');
        
        try {
            // Test basic model queries
            $userCount = User::count();
            $this->info("  ✓ User model working ({$userCount} users)");
            
            $homeworkCount = Homework::count();
            $this->info("  ✓ Homework model working ({$homeworkCount} assignments)");
            
            $submissionCount = HomeworkSubmission::count();
            $this->info("  ✓ HomeworkSubmission model working ({$submissionCount} submissions)");
            
            $testCount = Test::count();
            $this->info("  ✓ Test model working ({$testCount} tests)");
            
            $quizCount = QuizHeader::count();
            $this->info("  ✓ QuizHeader model working ({$quizCount} quiz attempts)");
            
            return true;
        } catch (\Exception $e) {
            $this->error('  ✗ Model check failed: ' . $e->getMessage());
            return false;
        }
    }

    private function checkFileDirectories(): bool
    {
        $this->line('📁 Checking File Upload Directories...');
        
        $directories = [
            'homework_attachments',
            'homework_submissions',
            'study_materials',
        ];

        $allExist = true;
        foreach ($directories as $dir) {
            $disk = Storage::disk('public');
            
            if (!$disk->exists($dir)) {
                $this->warn("  ⚠ Directory 'storage/app/public/{$dir}' does not exist, creating...");
                $disk->makeDirectory($dir);
            }
            
            if ($disk->exists($dir)) {
                $fileCount = count($disk->files($dir));
                $this->info("  ✓ {$dir} exists ({$fileCount} files)");
            } else {
                $this->error("  ✗ {$dir} could not be created");
                $allExist = false;
            }
        }

        // Check if storage is linked
        $publicLink = public_path('storage');
        if (is_link($publicLink) || is_dir($publicLink)) {
            $this->info('  ✓ Storage is linked to public directory');
        } else {
            $this->error('  ✗ Storage is NOT linked. Run: php artisan storage:link');
            $allExist = false;
        }

        return $allExist;
    }

    private function checkConfiguration(): bool
    {
        $this->line('⚙️  Checking Configuration...');
        
        $allGood = true;

        // APP_ENV
        $env = config('app.env');
        if ($env === 'production') {
            $this->info('  ✓ APP_ENV is set to production');
        } else {
            $this->warn("  ⚠ APP_ENV is set to '{$env}' (should be 'production' for deployment)");
        }

        // APP_DEBUG
        $debug = config('app.debug');
        if ($debug === false) {
            $this->info('  ✓ APP_DEBUG is disabled');
        } else {
            $this->error('  ✗ APP_DEBUG is enabled (MUST be false in production!)');
            $allGood = false;
        }

        // APP_KEY
        $key = config('app.key');
        if (!empty($key)) {
            $this->info('  ✓ APP_KEY is set');
        } else {
            $this->error('  ✗ APP_KEY is not set. Run: php artisan key:generate');
            $allGood = false;
        }

        // APP_URL
        $url = config('app.url');
        if (str_starts_with($url, 'https://') || $env !== 'production') {
            $this->info("  ✓ APP_URL is set to: {$url}");
        } else {
            $this->warn("  ⚠ APP_URL should use HTTPS in production: {$url}");
        }

        // Mail Configuration
        $mailDriver = config('mail.default');
        $mailFrom = config('mail.from.address');
        if (!empty($mailFrom) && $mailFrom !== 'hello@example.com') {
            $this->info("  ✓ Mail is configured ({$mailDriver}, {$mailFrom})");
        } else {
            $this->warn('  ⚠ Mail configuration may need updating');
        }

        // Database
        $dbConnection = config('database.default');
        $this->info("  ✓ Database driver: {$dbConnection}");

        return $allGood;
    }

    private function checkSecurity(): bool
    {
        $this->line('🔐 Checking Security Settings...');
        
        $allGood = true;

        // Check if policies are registered
        $policies = app('Illuminate\Contracts\Auth\Access\Gate')->policies();
        $requiredPolicies = [
            'App\Models\Homework',
            'App\Models\HomeworkSubmission',
        ];

        foreach ($requiredPolicies as $model) {
            if (isset($policies[$model])) {
                $policyClass = class_basename($policies[$model]);
                $this->info("  ✓ Policy registered for {$model}: {$policyClass}");
            } else {
                $this->error("  ✗ No policy registered for {$model}");
                $allGood = false;
            }
        }

        // Check file upload limits
        $maxUpload = ini_get('upload_max_filesize');
        $maxPost = ini_get('post_max_size');
        $this->info("  ✓ PHP upload_max_filesize: {$maxUpload}");
        $this->info("  ✓ PHP post_max_size: {$maxPost}");

        // Check if .env is protected
        $envPath = base_path('.env');
        if (file_exists($envPath) && !is_readable(public_path('.env'))) {
            $this->info('  ✓ .env file is not publicly accessible');
        } else {
            $this->warn('  ⚠ Ensure .env file is not publicly accessible');
        }

        return $allGood;
    }
}
