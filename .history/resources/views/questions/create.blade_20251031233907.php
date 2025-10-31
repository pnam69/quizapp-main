@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Add Question</h2>
    <form action="{{ route('questions.store') }}" method="POST">
        @include('questions._form')
    </form>
</div>
@endsection