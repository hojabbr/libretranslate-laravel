<?php

namespace Hojabbr\LibretranslateLaravel\Tests\Feature;

use Hojabbr\LibretranslateLaravel\LibretranslateClient;
use Hojabbr\LibretranslateLaravel\Tests\TestCase;
use Hojabbr\LibretranslateLaravel\Translator;
use Mockery;

class TranslatorTest extends TestCase
{
    private LibretranslateClient $mockClient;
    private Translator $translator;

    public function test_it_can_translate_text(): void
    {
        // Set up mock expectations
        $this->mockClient
            ->shouldReceive('request')
            ->once()
            ->with('/translate', [
                'q' => 'Hello',
                'source' => 'en',
                'target' => 'es',
                'format' => 'text',
            ])
            ->andReturn(['translatedText' => '¡Hola!']);

        $result = $this->translator->translate('Hello', 'en', 'es');

        $this->assertEquals('¡Hola!', $result);
    }

    public function test_it_can_translate_array_of_texts(): void
    {
        $texts = ['Hello', 'World'];
        $translations = ['¡Hola!', '¡Mundo!'];

        $this->mockClient
            ->shouldReceive('request')
            ->once()
            ->with('/translate', [
                'q' => $texts,
                'source' => 'en',
                'target' => 'es',
                'format' => 'text',
            ])
            ->andReturn(['translatedText' => $translations]);

        $result = $this->translator->translate($texts, 'en', 'es');

        $this->assertEquals($translations, $result);
    }

    public function test_it_can_detect_language(): void
    {
        $this->mockClient
            ->shouldReceive('request')
            ->once()
            ->with('/detect', ['q' => 'Hello'])
            ->andReturn([
                ['confidence' => 90, 'language' => 'en']
            ]);

        $result = $this->translator->detect('Hello');

        $this->assertIsArray($result);
        $this->assertEquals('en', $result[0]['language']);
    }

    public function test_it_can_get_languages(): void
    {
        $expectedLanguages = [
            ['code' => 'en', 'name' => 'English'],
            ['code' => 'es', 'name' => 'Spanish'],
        ];

        $this->mockClient
            ->shouldReceive('request')
            ->once()
            ->with('/languages')
            ->andReturn($expectedLanguages);

        $result = $this->translator->languages();

        $this->assertEquals($expectedLanguages, $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        // Create a mock of LibretranslateClient
        $this->mockClient = Mockery::mock(LibretranslateClient::class);

        // Create Translator with mock client
        $this->translator = new Translator($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}