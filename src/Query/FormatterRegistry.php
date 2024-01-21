<?php

declare(strict_types=1);

namespace Database\Query;

use Database\Query\Formatter\Formatter;

final class FormatterRegistry
{
    /**
     * @var array<string, Formatter>
     */
    private array $formatters;

    public function __construct(Formatter ...$formatters)
    {
        $this->formatters = [];

        foreach ($formatters as $formatter) {
            $this->formatters[$formatter->format()] = $formatter;
        }
    }

    public function byFormat(string $format): Formatter
    {
        $formatter = $this->formatters[$format];

        if (!$formatter instanceof Formatter) {
            throw new \InvalidArgumentException(
                sprintf('Could not find formatter for "%s" data format.', $format)
            );
        }

        return $formatter;
    }

    public function isAllowedSpecialFormat(string $format): bool
    {
        return in_array(sprintf('?%s',$format), array_keys($this->formatters), strict: true);
    }
}
