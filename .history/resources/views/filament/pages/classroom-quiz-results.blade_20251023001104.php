<?php
<h2 class="text-lg font-semibold mb-4">Results — Class {{ $this->classroomId }} — Quiz {{ $this->quizId }}</h2>

<table class="w-full table-auto border-collapse">
    <thead>
        <tr class="text-left">
            <th class="py-2">Student</th>
            <th class="py-2">Email</th>
            <th class="py-2">Score</th>
            <th class="py-2">Submitted</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($this->results as $r)
        <tr>
            <td class="py-1">{{ $r->user->name ?? '—' }}</td>
            <td class="py-1">{{ $r->user->email ?? '—' }}</td>
            <td class="py-1">{{ $r->score ?? 'N/A' }}</td>
            <td class="py-1">{{ optional($r->created_at)->toDateTimeString() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>