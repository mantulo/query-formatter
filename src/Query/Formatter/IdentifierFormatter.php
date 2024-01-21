<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

final readonly class IdentifierFormatter implements Formatter
{
    public function format(): string
    {
        return '?#';
    }

    public function formattedString(mixed $content): string
    {
        if ($content === null) {
            throw new \InvalidArgumentException('Null can not be used as an identifier.');
        }

        if (is_string($content)) {
            return sprintf('`%s`', addslashes($content));
        }

        if (!is_array($content)) {
            throw new \InvalidArgumentException(
                sprintf('Could not use identifier data formatter with "%s" data type.', gettype($content))
            );
        }

        $list = [];

        foreach ($content as $identifier) {
            $list[] = sprintf('`%s`', $identifier);
        }

        return implode(', ', $list);
    }
}