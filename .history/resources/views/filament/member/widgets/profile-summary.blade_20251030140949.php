<div class="p-4 bg-white rounded shadow">
    <h3 class="font-bold mb-2">Profile Summary</h3>
    <p><strong>Sections:</strong> {{ $sections->implode(', ') ?: 'None' }}</p>
    <p><strong>Certifications:</strong> {{ $certifications->implode(', ') ?: 'None' }}</p>
    <p><strong>Progress:</strong> {{ $completedQuizzes }}/{{ $totalQuizzes }} quizzes completed</p>
</div>