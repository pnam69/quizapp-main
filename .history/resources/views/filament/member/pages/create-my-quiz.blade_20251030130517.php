<x-filament-panels::page>
    <form wire:submit.prevent="submit">
        {{ static$this->form }}
        <x-filament::button type="submit" class="mt-4">
            Create Quiz
        </x-filament::button>
    </form>
</x-filament-panels::page>