@extends('layouts.app')

@section('title', $mode . ' Question')
@section('header', $mode . ' Question')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow rounded p-6">

    <form wire:submit.prevent="submit">
        <div class="mb-6 border-b border-gray-200">
            <nav class="-mb-px flex space-x-6" aria-label="Tabs">
                <button type="button"
                    class="tab-link px-3 py-2 font-medium text-gray-700 border-b-2 border-transparent focus:outline-none"
                    data-tab="general">General</button>

                <button type="button"
                    class="tab-link px-3 py-2 font-medium text-gray-700 border-b-2 border-transparent focus:outline-none"
                    data-tab="content">Content</button>

                <button type="button"
                    class="tab-link px-3 py-2 font-medium text-gray-700 border-b-2 border-transparent focus:outline-none"
                    data-tab="settings">Settings</button>
            </nav>
        </div>

        <div class="tab-content">
            <!-- General Tab -->
            <div class="tab-pane" id="general">
                <div class="space-y-4">
                    <x-filament::form :form="$this->form->getComponent('domain_id')" />
                    <x-filament::form :form="$this->form->getComponent('level')" />
                    <x-filament::form :form="$this->form->getComponent('is_active')" />
                </div>
            </div>

            <!-- Content Tab -->
            <div class="tab-pane hidden" id="content">
                <div class="space-y-4">
                    <x-filament::form :form="$this->form->getComponent('question')" />
                    <x-filament::form :form="$this->form->getComponent('explanation')" />
                    <x-filament::form :form="$this->form->getComponent('thumbnail')" />
                </div>
            </div>

            <!-- Settings Tab -->
            <div class="tab-pane hidden" id="settings">
                <div class="space-y-4">
                    {{-- You can add extra settings here later --}}
                    <p class="text-gray-500">Additional question settings can go here.</p>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-end space-x-2">
            <a href="{{ route('filament.resources.questions.index') }}"
                class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Cancel</a>

            <button type="submit"
                class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                {{ $mode == 'Create' ? 'Save' : 'Update' }}
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const tabs = document.querySelectorAll('.tab-link');
    const panes = document.querySelectorAll('.tab-pane');

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            const target = tab.dataset.tab;

            // switch active class on tabs
            tabs.forEach(t => t.classList.remove('border-blue-600', 'text-blue-600'));
            tab.classList.add('border-blue-600', 'text-blue-600');

            // switch visible pane
            panes.forEach(p => p.classList.add('hidden'));
            document.getElementById(target).classList.remove('hidden');
        });
    });

    // Activate first tab by default
    tabs[0].click();
</script>
@endpush
@endsection