<?php
@if($randomQuote)
    <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">
        "{{ $randomQuote->quote }}"
    </p>
    <p class="ml-4 text-sm font-bold text-gray-500 dark:text-gray-400 align-content-end">
        -- {{ $randomQuote->author }}
    </p>
@else
    <p class="ml-3 text-sm text-gray-500 dark:text-gray-400">
        No quotes available.
    </p>
@endif
namespace App\Livewire;

use Filament\Widgets\Widget;
use App\Models\Quote;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;


class RandomQuoteWidget extends Widget
{
    use HasWidgetShield;

    protected static ?int $sort = 1;

    protected static string $view = 'livewire.random-quote-widget';

    protected static ?string $pollingInterval = '10s';

    public $randomQuote = '';

    public function mount(){

        $this->randomQuote = $quote = Quote::where('is_active',true)->inRandomOrder()->first();
    }
    
}
