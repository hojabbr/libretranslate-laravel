<?php

declare(strict_types=1);

namespace Hojabbr\LibretranslateLaravel\Contracts;

interface TranslatorInterface
{
    public function translate(string|array $text, string $source, string $target, string $format = 'text'): string|array;

    public function detect(string $text): array;

    public function languages(): array;
}
