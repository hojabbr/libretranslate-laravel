<?php

namespace Hojabbr\LibretranslateLaravel\Tests\Unit;

use Hojabbr\LibretranslateLaravel\Exceptions\TranslationException;
use Hojabbr\LibretranslateLaravel\LibretranslateClient;
use Hojabbr\LibretranslateLaravel\Tests\TestCase;

class LibretranslateClientTest extends TestCase
{
    private LibretranslateClient $client;

    public function test_it_throws_exception_on_invalid_request(): void
    {
        $this->expectException(TranslationException::class);

        $this->client->request('/invalid-endpoint');
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->client = new LibretranslateClient('https://libretranslate.com', 'test-key');
    }
}
