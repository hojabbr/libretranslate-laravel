<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel\DTOs;

final readonly class TranslationRequest
{
    public function __construct(
        public string|array $text,
        public string $source,
        public string $target,
        public string $format = 'text',
        public int $alternatives = 0
    ) {}
}
