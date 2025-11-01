<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
            <div class="mb-4">
                <h2 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Create Your Own Quiz
                </h2>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Create a custom quiz with your own questions and answers. You can share it with others or use it for practice.
                </p>
            </div>

            <form wire:submit.prevent="submit">
                {{ $this->form }}

                <div class="mt-6 flex justify-end gap-3">
                    <x-filament::button 
                        color="gray" 
                        tag="a" 
                        href="{{ route('filament.member.pages.my-quizzes') }}"
                    >
                        Cancel
                    </x-filament::button>
                    
                    <x-filament::button type="submit" color="primary">
                        Create Quiz
                    </x-filament::button>
                </div>
            </form>
        </div>

        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4">
            <h3 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-2">
                📝 Tips for Creating Quizzes:
            </h3>
            <ul class="text-sm text-blue-800 dark:text-blue-200 space-y-1 list-disc list-inside">
                <li>Make sure each question has at least one correct answer</li>
                <li>Use clear and concise language</li>
                <li>Add multiple options to make questions more challenging</li>
                <li>You can reorder questions and options using the drag handles</li>
            </ul>
        </div>
    </div>
</x-filament-panels::page>
