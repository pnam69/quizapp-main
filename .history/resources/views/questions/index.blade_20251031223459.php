@extends('layouts.app')

@section('title', 'Questions List')
@section('header', 'All Questions')

@section('content')
<div class="mb-4">
    <a href="{{ route('filament.resources.questions.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
        + Add Question
    </a>
</div>

<div class="bg-white shadow rounded p-4">
    <x-filament::table :table="$this->table" />
</div>
@endsection