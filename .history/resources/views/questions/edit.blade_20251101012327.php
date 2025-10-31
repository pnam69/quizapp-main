@extends('layouts.app')
@section('title', 'Questions List')

@section('content')
<div class="header">
    <h2>Questions</h2>
    <a href="{{ route('questions.create') }}" class="btn">Add Question</a>
</div>

<table class="table" style="width:100%; border-collapse: collapse;">
    <thead>
        <tr style="background: #f0f0f0;">
            <th style="padding: 10px;">#</th>
            <th style="padding: 10px;">Question</th>
            <th style="padding: 10px;">Category</th>
            <th style="padding: 10px;">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($questions as $question)
        <tr>
            <td style="padding: 10px;">{{ $loop->iteration }}</td>
            <td style="padding: 10px;">{{ $question->text }}</td>
            <td style="padding: 10px;">{{ $question->category->name ?? 'N/A' }}</td>
            <td style="padding: 10px;">
                <a href="{{ route('questions.edit', $question->id) }}" class="btn">Edit</a>
                <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn" style="background: #dc3545;">Delete</button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
@endsection