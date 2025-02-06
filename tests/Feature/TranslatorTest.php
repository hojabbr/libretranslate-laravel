<?php

namespace Hojabbr\LibretranslateLaravel\Tests\Feature;

use Hojabbr\LibretranslateLaravel\Tests\TestCase;
use Hojabbr\LibretranslateLaravel\Translator;

class TranslatorTest extends TestCase
{
    private Translator $translator;

    public function test_it_can_translate_text(): void
    {
        // Note: This is a basic test. In real-world scenarios,
        // you'd want to mock the HTTP client to avoid actual API calls
        $result = $this->translator->translate('Hello', 'en', 'es');

        $this->assertIsString($result);
    }

    public function test_it_can_detect_language(): void
    {
        $result = $this->translator->detect('Hello');

        $this->assertIsArray($result);
    }

    public function test_it_can_get_languages(): void
    {
        $result = $this->translator->languages();

        $this->assertIsArray($result);
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->translator = $this->app->make(Translator::class);
    }
}
