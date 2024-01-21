<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

final readonly class FloatFormatter implements Formatter
{
    public function format(): string
    {
        return '?f';
    }

    public function formattedString(mixed $content): string
    {
        if ($content === null) {
            return 'NULL';
        }

        if (!is_numeric($content)) {
            throw new \InvalidArgumentException(
                sprintf('Could not use none numeric "%s" type with floating formatter.', gettype($content)),
            );
        }

        return (string) (float) $content;
    }
}