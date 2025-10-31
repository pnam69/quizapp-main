<x-filament::page class="space-y-6">
    @foreach($questions as $question)
        <div class="p-4 border rounded-lg shadow-sm bg-white dark:bg-gray-800 dark:border-gray-700">
            <h2 class="text-lg font-semibold mb-2 text-gray-900 dark:text-gray-100">
                {{ $question->question }}
            </h2>

            <ul class="space-y-1">
                @foreach($question->answers as $answer)
                    <li class="flex items-center justify-between p-2 border-b last:border-b-0 border-gray-200 dark:border-gray-700">
                        <span class="text-gray-700 dark:text-gray-300">{{ $answer->answer }}</span>
                        <span class="text-green-600 dark:text-green-400 font-semibold">
                            @if($answer->is_checked)
                                Correct
                            @endif
                        </span>
                        <a href="{{ route('filament.admin.resources.answers.edit', $answer) }}" 
                           class="ml-4 text-blue-600 dark:text-blue-400 hover:underline">
                           Edit
                        </a>
                    </li>
                @endforeach
            </ul>
        </div>
    @endforeach
</x-filament::page>
