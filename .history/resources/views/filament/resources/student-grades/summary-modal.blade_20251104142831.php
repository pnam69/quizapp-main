@props([
'totalStudents' => 0,
'totalAssessments' => 0,
'averageScore' => 0,
'passRate' => 0,
'totalAttempts' => 0,
])

<div class="space-y-6">
    <div class="text-center">
        <h3 class="text-lg font-semibold text-slate-900 dark:text-white mb-2">Grade Summary Overview</h3>
        <p class="text-sm text-slate-600 dark:text-slate-400">Comprehensive statistics across all student assessments</p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">{{ $totalStudents }}</div>
            <div class="text-sm font-medium text-blue-800 dark:text-blue-300">Total Students</div>
        </div>

        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-green-600 dark:text-green-400">{{ $totalAssessments }}</div>
            <div class="text-sm font-medium text-green-800 dark:text-green-300">Assessments</div>
        </div>

        <div class="bg-purple-50 dark:bg-purple-900/20 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-purple-600 dark:text-purple-400">{{ $totalAttempts }}</div>
            <div class="text-sm font-medium text-purple-800 dark:text-purple-300">Total Attempts</div>
        </div>

        <div class="bg-orange-50 dark:bg-orange-900/20 rounded-lg p-4 text-center">
            <div class="text-2xl font-bold text-orange-600 dark:text-orange-400">{{ $averageScore }}%</div>
            <div class="text-sm font-medium text-orange-800 dark:text-orange-300">Average Score</div>
        </div>
    </div>

    <div class="bg-slate-50 dark:bg-slate-800 rounded-lg p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-sm font-medium text-slate-700 dark:text-slate-300">Pass Rate</span>
            <span class="text-sm font-bold text-slate-900 dark:text-white">{{ $passRate }}%</span>
        </div>
        <div class="w-full bg-slate-200 dark:bg-slate-600 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full transition-all duration-300"
                style="width: {{ $passRate }}%"></div>
        </div>
    </div>

    <div class="text-xs text-slate-500 dark:text-slate-400 text-center">
        Data is updated in real-time • Last updated: {{ now()->format('M d, Y H:i') }}
    </div>
</div>