<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

final class DefaultFormatter implements Formatter
{
    public function format(): string
    {
        return '?';
    }

    public function formattedString(mixed $content): string
    {
        if (is_null($content)) {
            return 'NULL';
        }

        if (is_bool($content)) {
            return (string) (int) $content;
        }

        if (is_string($content)) {
            return sprintf("'%s'", addslashes($content));
        }

        $formatter = match (true) {
            is_float($content) => new FloatFormatter(),
            is_int($content) => new DecimalFormatter(),
            is_array($content) => new ArrayFormatter(),
            default => throw new \InvalidArgumentException(
                sprintf('Could not find strategy to parse "%s" data type.', gettype($content))
            ),
        };

        return $formatter->formattedString($content);
    }
}