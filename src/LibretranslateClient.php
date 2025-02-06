<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel;

use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Hojabbr\LibretranslateLaravel\Exceptions\TranslationException;

final class LibretranslateClient
{
    private ClientInterface $httpClient;

    public function __construct(
        private readonly string  $baseUrl,
        private readonly ?string $apiKey = null,
        ?ClientInterface         $httpClient = null
    )
    {
        $this->httpClient = $httpClient ?? new Client([
            'base_uri' => $this->baseUrl,
            'timeout' => 30,
        ]);
    }

    public function request(string $endpoint, array $data = []): array
    {
        if ($this->apiKey) {
            $data['api_key'] = $this->apiKey;
        }

        try {
            $response = $this->httpClient->request('POST', $endpoint, [
                'form_params' => $data,
            ]);

            return json_decode($response->getBody()->getContents(), true);
        } catch (\Exception $e) {
            throw new TranslationException($e->getMessage(), $e->getCode(), $e);
        }
    }
}