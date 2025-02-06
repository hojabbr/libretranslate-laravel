<?php

namespace Hojabbr\LibretranslateLaravel\Tests\Feature;

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Hojabbr\LibretranslateLaravel\LibretranslateClient;
use Hojabbr\LibretranslateLaravel\Tests\TestCase;
use Hojabbr\LibretranslateLaravel\Translator;

class TranslatorTest extends TestCase
{
    private MockHandler $mockHandler;
    private Translator $translator;

    public function test_it_can_translate_text(): void
    {
        $this->mockHandler->append(
            new Response(200, [], json_encode(['translatedText' => '¡Hola!']))
        );

        $result = $this->translator->translate('Hello', 'en', 'es');

        $this->assertEquals('¡Hola!', $result);
    }

    public function test_it_can_translate_array_of_texts(): void
    {
        $texts = ['Hello', 'World'];
        $translations = ['¡Hola!', '¡Mundo!'];

        $this->mockHandler->append(
            new Response(200, [], json_encode(['translatedText' => $translations]))
        );

        $result = $this->translator->translate($texts, 'en', 'es');

        $this->assertEquals($translations, $result);
    }

    public function test_it_can_detect_language(): void
    {
        $this->mockHandler->append(
            new Response(200, [], json_encode([
                ['confidence' => 90, 'language' => 'en']
            ]))
        );

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

        $this->mockHandler->append(
            new Response(200, [], json_encode($expectedLanguages))
        );

        $result = $this->translator->languages();

        $this->assertEquals($expectedLanguages, $result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $mockClient = new Client(['handler' => $handlerStack]);

        $libreTranslateClient = new LibretranslateClient(
            'https://libretranslate.com',
            'test-key',
            $mockClient
        );

        $this->translator = new Translator($libreTranslateClient);
    }
}