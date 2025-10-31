@extends('layouts.app')

@section('title', 'Create Question')
@section('header', 'Create New Question')

@section('content')
<div class="max-w-4xl mx-auto bg-white shadow rounded p-6">
    <form wire:submit.prevent="submit">
        <x-filament::form :form="$this->form" />

        <div class="mt-4 flex justify-end space-x-2">
            <a href="{{ route('filament.resources.questions.index') }}"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>

            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                Save
            </button>
        </div>
    </form>
</div>
@endsection
@include('questions.form', ['mode' => 'Create'])
@include('questions.form', ['mode' => 'Edit'])