<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

final class DecimalFormatter implements Formatter
{
    public function format(): string
    {
        return '?d';
    }

    public function formattedString(mixed $content): string
    {
        if ($content === null) {
            return 'NULL';
        }

        if (!is_numeric($content) && !(is_bool($content))) {
            throw new \InvalidArgumentException(
                sprintf('Invalid numeric type was given "%s" for decimal formatter.', gettype($content))
            );
        }

        return (string) (int) $content;
    }
}