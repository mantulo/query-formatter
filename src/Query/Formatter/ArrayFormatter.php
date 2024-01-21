<?php

declare(strict_types=1);

namespace Database\Query\Formatter;

final readonly class ArrayFormatter implements Formatter
{
    public function __construct(
        private DefaultFormatter $defaultFormatter = new DefaultFormatter(),
    ) {
    }

    public function format(): string
    {
        return '?a';
    }

    public function formattedString(mixed $content): string
    {
        if (!is_array($content)) {
            throw new \InvalidArgumentException(
                sprintf("Could not use type '%s' with array data formatter.", gettype($content))
            );
        }

        if (array_is_list($content)) {
            return implode(', ', $content);
        }

        $formatted = [];

        foreach ($content as $key => $value) {
            $formatted[] = sprintf("`%s` = %s", $key, $this->defaultFormatter->formattedString($value));
        }

        return implode(', ', $formatted);
    }
}