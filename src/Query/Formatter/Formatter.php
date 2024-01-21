<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

interface Formatter
{
    public function format(): string;

    public function formattedString(mixed $content): string;
}