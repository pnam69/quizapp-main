@extends('layouts.app')
@section('title', isset($question) ? 'Edit Question' : 'Add Question')

@section('content')
<div class="header">
    <h2>{{ isset($question) ? 'Edit Question' : 'Add Question' }}</h2>
    <a href="{{ route('questions.index') }}" class="btn">Back</a>
</div>

<form method="POST"
    action="{{ isset($question) ? route('questions.update', $question->id) : route('questions.store') }}">
    @csrf
    @if(isset($question))
    @method('PUT')
    @endif

    <div style="margin-bottom: 20px;">
        <label for="text">Question</label><br>
        <textarea name="text" id="text" rows="3" style="width:100%; padding:10px;">{{ old('text', $question->text ?? '') }}</textarea>
    </div>

    <div style="margin-bottom: 20px;">
        <label for="category_id">Category</label><br>
        <select name="category_id" id="category_id" style="width:100%; padding:10px;">
            @foreach ($categories as $cat)
            <option value="{{ $cat->id }}"
                {{ (isset($question) && $question->category_id == $cat->id) ? 'selected' : '' }}>
                {{ $cat->name }}
            </option>
            @endforeach
        </select>
    </div>

    <button type="submit" class="btn">{{ isset($question) ? 'Update' : 'Save' }}</button>
</form>
@endsection