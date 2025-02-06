# LibreTranslate Laravel

A Laravel package for integrating with LibreTranslate API.

## Installation

```bash
composer require hojabbr/libretranslate-laravel
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --provider="Hojabbr\LibretranslateLaravel\LibretranslateServiceProvider"
```

Add these variables to your .env file:

```env
LIBRETRANSLATE_URL=https://your-libretranslate-instance.com
LIBRETRANSLATE_API_KEY=your-api-key
```

## Usage

```php
use Hojabbr\LibretranslateLaravel\Facades\Translator;

// Translate text
$translated = Translator::translate('Hello world', 'en', 'es', 'text');

// Translate HTML
$translated = Translator::translate('Hello world', 'en', 'es', 'html');

// Detect language
$detected = Translator::detect('Bonjour le monde');

// Get supported languages
$languages = Translator::languages();
```

## Testing

```bash
composer test
```

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
