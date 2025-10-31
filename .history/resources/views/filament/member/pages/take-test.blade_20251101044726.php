@foreach ($question->answers as $option)
@php
$optionClass = '';
if ($isAnswered) {
if ($option->id == $correct) {
$optionClass = 'bg-green-100 dark:bg-green-700 border-green-400';
} elseif ($option->id == $chosen) {
$optionClass = 'bg-red-100 dark:bg-red-700 border-red-400';
}
}
@endphp
<label class="flex items-center space-x-2 cursor-pointer border px-3 py-2 rounded {{ $optionClass }}">
    <input type="radio"
        wire:model="answers.{{ $question->id }}"
        value="{{ $option->id }}"
        class="text-primary-600 focus:ring-primary-500"
        {{ $isAnswered ? 'disabled' : '' }}>
    <span class="text-gray-700 dark:text-gray-300">{{ $option->answer }}</span>
</label>
@endforeach