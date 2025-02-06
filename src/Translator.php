<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel;

use Hojabbr\LibretranslateLaravel\Contracts\TranslatorInterface;
use Hojabbr\LibretranslateLaravel\DTOs\TranslationRequest;

final class Translator implements TranslatorInterface
{
    public function __construct(
        private readonly LibretranslateClient $client
    ) {}

    public function translate(string|array $text, string $source, string $target, string $format = 'text'): string|array
    {
        $request = new TranslationRequest($text, $source, $target, $format);

        $response = $this->client->request('/translate', [
            'q' => $request->text,
            'source' => $request->source,
            'target' => $request->target,
            'format' => $request->format,
        ]);

        return $response['translatedText'];
    }

    public function detect(string $text): array
    {
        $response = $this->client->request('/detect', [
            'q' => $text,
        ]);

        return $response;
    }

    public function languages(): array
    {
        return $this->client->request('/languages');
    }
}
