@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Questions List</h2>

    <div class="text-end mb-3">
        <a href="{{ route('questions.create') }}" class="btn btn-primary">Add Question</a>
    </div>

    <table class="table table-bordered table-striped align-middle">
        <thead>
            <tr>
                <th>ID</th>
                <th>Question Text</th>
                <th>Type</th>
                <th>Section</th>
                <th>Certification</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($questions as $question)
            <tr>
                <td>{{ $question->id }}</td>
                <td>{{ Str::limit($question->text, 60) }}</td>
                <td>{{ $question->type }}</td>
                <td>{{ $question->section->name ?? '—' }}</td>
                <td>{{ $question->certification->name ?? '—' }}</td>
                <td>
                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('questions.destroy', $question) }}" method="POST" class="d-inline">
                        @csrf @method('DELETE')
                        <button class="btn btn-sm btn-danger" onclick="return confirm('Delete this question?')">Delete</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center">No questions found.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection