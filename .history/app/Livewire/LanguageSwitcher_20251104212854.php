<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageSwitcher extends Component
{
    public $currentLocale;

    public $languages = [
        'en' => ['name' => 'English', 'flag' => '🇺🇸'],
        'vi' => ['name' => 'Tiếng Việt', 'flag' => '��'],
    ];

    public function mount()
    {
        $this->currentLocale = Session::get('locale', config('app.locale'));
    }

    public function switchLanguage($locale)
    {
        if (array_key_exists($locale, $this->languages)) {
            Session::put('locale', $locale);
            App::setLocale($locale);
            $this->currentLocale = $locale;

            // Refresh the page to apply the new language
            return redirect()->to(request()->header('Referer'));
        }
    }

    public function render()
    {
        return view('livewire.language-switcher');
    }
}
