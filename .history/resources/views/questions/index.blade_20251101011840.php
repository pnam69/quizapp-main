@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6">
    <h1 class="text-2xl font-bold mb-4">Questions</h1>

    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
        @foreach($questions as $question)
        <div class="bg-white shadow rounded-lg p-4">
            <div class="mb-2">
                <span class="font-semibold">Question:</span>
                <p>{{ $question->question }}</p>
            </div>
            <div class="mb-2">
                <span class="font-semibold">Domain:</span> {{ $question->domain->name ?? '-' }}
            </div>
            <div class="mb-2">
                <span class="font-semibold">Difficulty:</span>
                @switch($question->level)
                @case(1) Easy @break
                @case(2) Medium @break
                @case(3) Hard @break
                @default Unknown
                @endswitch
            </div>
            <div class="mb-2">
                <span class="font-semibold">Answers:</span>
                <ul class="list-disc list-inside">
                    @foreach($question->answers as $answer)
                    <li>
                        {{ $answer->answer }}
                        @if($answer->is_checked)
                        <span class="text-green-600 font-semibold">(Correct)</span>
                        @endif
                    </li>
                    @endforeach
                </ul>
            </div>
            @if($question->explanation)
            <div class="mt-2 text-gray-600">
                <span class="font-semibold">Explanation:</span>
                <p>{{ $question->explanation }}</p>
            </div>
            @endif
        </div>
        @endforeach
    </div>
</div>
@endsection