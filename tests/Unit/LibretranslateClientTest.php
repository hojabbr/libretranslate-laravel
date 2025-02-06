<?php

namespace Hojabbr\LibretranslateLaravel\Tests\Unit;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Hojabbr\LibretranslateLaravel\Exceptions\TranslationException;
use Hojabbr\LibretranslateLaravel\LibretranslateClient;
use Hojabbr\LibretranslateLaravel\Tests\TestCase;
use Mockery;

class LibretranslateClientTest extends TestCase
{
    private MockHandler $mockHandler;
    private Client $mockClient;
    private LibretranslateClient $client;

    public function test_successful_request(): void
    {
        // Mock a successful response
        $this->mockHandler->append(
            new Response(200, [], json_encode(['translatedText' => '¡Hola Mundo!']))
        );

        $result = $this->client->request('/translate', [
            'q' => 'Hello World',
            'source' => 'en',
            'target' => 'es'
        ]);

        $this->assertEquals(['translatedText' => '¡Hola Mundo!'], $result);
    }

    public function test_it_throws_exception_on_invalid_request(): void
    {
        // Mock a failed response
        $this->mockHandler->append(
            new RequestException(
                'Error Communicating with Server',
                new Request('POST', '/invalid-endpoint'),
                new Response(400, [], json_encode(['error' => 'Bad Request']))
            )
        );

        $this->expectException(TranslationException::class);

        $this->client->request('/invalid-endpoint');
    }

    public function test_it_throws_exception_on_server_error(): void
    {
        // Mock a server error
        $this->mockHandler->append(
            new Response(500, [], json_encode(['error' => 'Internal Server Error']))
        );

        $this->expectException(TranslationException::class);

        $this->client->request('/translate');
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockHandler = new MockHandler();
        $handlerStack = HandlerStack::create($this->mockHandler);
        $this->mockClient = new Client(['handler' => $handlerStack]);

        // Use Mockery to create a partial mock of LibretranslateClient
        $this->client = Mockery::mock(LibretranslateClient::class)
            ->makePartial()
            ->shouldAllowMockingProtectedMethods();

        // Replace the internal HTTP client with our mock
        $this->client->shouldReceive('createHttpClient')
            ->andReturn($this->mockClient);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}