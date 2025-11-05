# Language Switcher - Quick Guide

## What's Been Added

### 1. **Three Languages Supported**
   - 🇺🇸 English (en)
   - 🇪🇸 Spanish (es)
   - 🇫🇷 French (fr)

### 2. **Files Created**

#### Language Files
- `lang/en/messages.php` - English translations
- `lang/es/messages.php` - Spanish translations
- `lang/fr/messages.php` - French translations

#### Livewire Component
- `app/Livewire/LanguageSwitcher.php` - Language switcher logic
- `resources/views/livewire/language-switcher.blade.php` - Switcher UI
- `resources/views/livewire/language-switcher-widget.blade.php` - Widget wrapper

#### Middleware
- `app/Http/Middleware/SetLocale.php` - Sets language from session

### 3. **Where It Appears**
The language switcher appears in the **top navigation bar** next to the user menu in:
- Admin Panel (`/admin`)
- Member Panel (`/member`)

### 4. **How It Works**
1. User clicks the language button (shows current language with flag)
2. Dropdown menu appears with all available languages
3. User selects a language
4. Page refreshes with the new language
5. Choice is saved in session (persists across pages)

### 5. **Using Translations in Your Code**

In Blade templates:
```php
{{ __('messages.dashboard') }}
{{ __('messages.my_results') }}
{{ __('messages.take_test') }}
```

In PHP code:
```php
trans('messages.dashboard')
__('messages.my_results')
```

### 6. **Adding More Translations**

To add more translatable text:

1. Add to language files (`lang/*/messages.php`):
```php
'new_key' => 'Translation text',
```

2. Use in templates:
```php
{{ __('messages.new_key') }}
```

### 7. **Adding More Languages**

1. Create new language directory: `lang/de/`
2. Add `messages.php` file with translations
3. Update `LanguageSwitcher.php`:
```php
public $languages = [
    'en' => ['name' => 'English', 'flag' => '🇺🇸'],
    'es' => ['name' => 'Español', 'flag' => '🇪🇸'],
    'fr' => ['name' => 'Français', 'flag' => '🇫🇷'],
    'de' => ['name' => 'Deutsch', 'flag' => '🇩🇪'], // New language
];
```
4. Update middleware allowed locales in `SetLocale.php`
5. Update config: `config/app.php` → `available_locales`

### 8. **Testing**

1. Visit your admin or member panel
2. Look for the language switcher in the top navigation
3. Click it and select a different language
4. The page will refresh with the new language

### 9. **Customization**

#### Change Position
Edit the `renderHook` in panel providers:
- `panels::user-menu.before` - Before user menu (current)
- `panels::topbar.end` - End of top bar
- `panels::sidebar.footer` - Sidebar footer

#### Change Styling
Edit `resources/views/livewire/language-switcher.blade.php` to customize the appearance.

## Notes

- Language preference is stored in the **session** (not database)
- Default language is English (`en`)
- You can add as many languages as needed
- Translations can be added for any part of your application

## Next Steps

To fully internationalize your app, you'll need to:
1. Replace hardcoded text with translation keys
2. Add more translation keys to the language files
3. Consider translating Filament's UI elements (see Filament docs)
