<x-filament-panels::page>
    <div class="max-w-4xl mx-auto">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm rounded-lg">
            <div class="p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-900 dark:text-white">
                        Study: {{ $this->record->title }}
                    </h2>
                    <div class="flex items-center space-x-4">
                        <span class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $this->currentCardIndex + 1 }} / {{ count($this->flashcards) }}
                        </span>
                        <button
                            wire:click="resetStudy"
                            class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors"
                        >
                            Reset
                        </button>
                    </div>
                </div>

                @if(count($this->flashcards) > 0)
                    <div class="relative">
                        <!-- Flashcard -->
                        <div
                            class="min-h-64 bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-gray-700 dark:to-gray-600 rounded-xl p-8 cursor-pointer transition-all duration-300 hover:shadow-lg"
                            wire:click="flipCard"
                        >
                            <div class="flex items-center justify-center h-full">
                                @if($this->showAnswer)
                                    <!-- Answer Side -->
                                    <div class="text-center">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">Answer</div>
                                        <div class="text-xl font-medium text-gray-900 dark:text-white">
                                            {!! nl2br(e($this->currentCard->back_content)) !!}
                                        </div>
                                    </div>
                                @else
                                    <!-- Question Side -->
                                    <div class="text-center">
                                        <div class="text-sm text-gray-500 dark:text-gray-400 mb-4">Question</div>
                                        <div class="text-xl font-medium text-gray-900 dark:text-white">
                                            {!! nl2br(e($this->currentCard->front_content)) !!}
                                        </div>
                                    </div>
                                @endif
                            </div>

                            <!-- Flip indicator -->
                            <div class="absolute bottom-4 right-4 text-sm text-gray-400 dark:text-gray-500">
                                Click to {{ $this->showAnswer ? 'show question' : 'reveal answer' }}
                            </div>
                        </div>

                        <!-- Navigation -->
                        <div class="flex items-center justify-between mt-6">
                            <button
                                wire:click="previousCard"
                                @if($this->currentCardIndex === 0) disabled @endif
                                class="px-6 py-3 bg-gray-500 text-white rounded-lg hover:bg-gray-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors"
                            >
                                ← Previous
                            </button>

                            <div class="flex items-center space-x-4">
                                <button
                                    wire:click="markDifficult"
                                    class="px-4 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors"
                                >
                                    Difficult
                                </button>
                                <button
                                    wire:click="markGood"
                                    class="px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors"
                                >
                                    Good
                                </button>
                                <button
                                    wire:click="markEasy"
                                    class="px-4 py-2 bg-green-500 text-white rounded-lg hover:bg-green-600 transition-colors"
                                >
                                    Easy
                                </button>
                            </div>

                            <button
                                wire:click="nextCard"
                                @if($this->currentCardIndex >= count($this->flashcards) - 1) disabled @endif
                                class="px-6 py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 disabled:bg-gray-300 disabled:cursor-not-allowed transition-colors"
                            >
                                Next →
                            </button>
                        </div>

                        <!-- Progress Bar -->
                        <div class="mt-6">
                            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                <div
                                    class="bg-blue-500 h-2 rounded-full transition-all duration-300"
                                    style="width: {{ count($this->flashcards) > 0 ? (($this->currentCardIndex + 1) / count($this->flashcards)) * 100 : 0 }}%"
                                ></div>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="text-center py-12">
                        <div class="text-gray-500 dark:text-gray-400 text-lg">
                            No flashcards found in this deck.
                        </div>
                        <div class="mt-4">
                            <a
                                href="{{ route('filament.member.resources.flashcard-decks.edit', $this->record) }}"
                                class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 transition-colors"
                            >
                                Add Flashcards
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-filament-panels::page>
