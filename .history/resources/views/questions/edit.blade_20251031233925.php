@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Edit Question</h2>
    <form action="{{ route('questions.update', $question) }}" method="POST">
        @method('PUT')
        @include('questions._form')
    </form>
</div>
@endsection