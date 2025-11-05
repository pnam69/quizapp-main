@php
$currentLocale = Session::get('locale', config('app.locale'));
$languages = [
'en' => ['name' => 'English', 'flag' => 'US'],
'vi' => ['name' => 'Tiếng Việt', 'flag' => 'VN'],
];
@endphp

<div x-data="{ open: false }" class="relative">
    <!-- Language Switcher Button -->
    <button
        @click="open = !open"
        @click.away="open = false"
        type="button"
        class="flex items-center gap-2 px-3 py-2 text-sm font-medium text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-500">
        <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded">
            {{ $languages[$currentLocale]['flag'] }}
        </span>
        <span>{{ $languages[$currentLocale]['name'] }}</span>
        <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>

    <!-- Dropdown Menu -->
    <div
        x-show="open"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 scale-95"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-95"
        class="absolute right-0 mt-2 w-48 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg shadow-lg z-50"
        style="display: none;">
        <div class="py-1">
            @foreach($languages as $code => $language)
            <form action="{{ route('language.switch') }}" method="POST" class="inline w-full">
                @csrf
                <input type="hidden" name="locale" value="{{ $code }}">
                <button
                    type="submit"
                    class="w-full flex items-center gap-3 px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition-colors duration-150 {{ $currentLocale === $code ? 'bg-gray-50 dark:bg-gray-900 font-semibold' : '' }}">
                    <span class="inline-flex items-center justify-center w-6 h-6 text-xs font-bold bg-primary-100 dark:bg-primary-900 text-primary-700 dark:text-primary-300 rounded">
                        {{ $language['flag'] }}
                    </span>
                    <span>{{ $language['name'] }}</span>
                    @if($currentLocale === $code)
                    <svg class="w-4 h-4 ml-auto text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    @endif
                </button>
            </form>
            @endforeach
        </div>
    </div>
</div>