@foreach($questions as $question)
<p>{{ $question->text }}</p>
@foreach($question->answers as $answer)
<label>
    <input type="radio" wire:model="answers.{{ $question->id }}" value="{{ $answer->id }}">
    {{ $answer->text }}
</label>
@endforeach
@endforeach

<button wire:click="submit">Submit</button>