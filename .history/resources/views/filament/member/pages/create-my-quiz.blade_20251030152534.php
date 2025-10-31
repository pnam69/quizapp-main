{{-- resources/views/filament/member/pages/create-my-quiz.blade.php --}}
<x-filament::page>
    <form wire:submit.prevent="submit" class="space-y-6">
        {{-- Quiz Title --}}
        <x-forms::text-input
            label="Quiz Title"
            placeholder="Enter your quiz title"
            wire:model.defer="title"
            required />

        {{-- Questions Repeater --}}
        <x-forms::repeater
            label="Questions"
            wire:model="questions"
            :min-items="1"
            :columns="1">
            <x-slot name="fields">
                {{-- Question Text --}}
                <x-forms::text-input
                    label="Question"
                    placeholder="Type the question here"
                    wire:model.defer="questions.{{ $loop->index }}.question_text"
                    required />

                {{-- Options Repeater --}}
                <x-forms::repeater
                    label="Options"
                    wire:model="questions.{{ $loop->index }}.options"
                    :min-items="2"
                    :columns="1">
                    <x-slot name="fields">
                        <div class="flex items-center space-x-2">
                            <x-forms::text-input
                                label="Option Text"
                                placeholder="Option text"
                                wire:model.defer="questions.{{ $loop->parent->index }}.options.{{ $loop->index }}.option_text"
                                required
                                class="flex-1" />

                            <x-forms::toggle
                                label="Correct"
                                wire:model.defer="questions.{{ $loop->parent->index }}.options.{{ $loop->index }}.is_correct" />
                        </div>
                    </x-slot>
                </x-forms::repeater>

            </x-slot>
        </x-forms::repeater>

        {{-- Submit Button --}}
        <x-filament::button type="submit">
            Create Quiz
        </x-filament::button>
    </form>
</x-filament::page>