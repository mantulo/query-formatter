<?php

declare(strict_types=1);

namespace Database;

use Database\Query\FormatterRegistry;

final readonly class QueryFormatter
{
    public function __construct(
        private FormatterRegistry $formatters,
        private bool $skipConditionalBlocks,
    ) {
    }

    /**
     * @param string      $query
     * @param list<mixed> $args
     *
     * @return string
     */
    public function formattedString(string $query, array $args): string
    {
        $currentCharIndex = 0;
        $currentArgumentIndex = 0;
        $queryStack = [''];
        
        while ($currentCharIndex < mb_strlen($query)) {
            if (!in_array($query[$currentCharIndex], ['?', '{', '}'], strict: true)) {
                $queryStack[count($queryStack) - 1] .= $query[$currentCharIndex];
            }

            if ($query[$currentCharIndex] === '{') {
                $queryStack[] = '';
            }

            if ($query[$currentCharIndex] === '}') {
                if (count($queryStack) === 1) {
                    throw new \InvalidArgumentException('There is no opening tag to close conditional block.');
                }

                $conditionalSubQuery = array_pop($queryStack);

                if (!$this->skipConditionalBlocks) {
                    $queryStack[count($queryStack) - 1] .= $conditionalSubQuery;
                }
            }

            if ($query[$currentCharIndex] === '?') {
                $candidateFormat = '?';

                if ($currentCharIndex + 1 < mb_strlen($query)
                    && $this->formatters->isAllowedSpecialFormat($query[$currentCharIndex + 1])
                ) {
                    $candidateFormat .= $query[++$currentCharIndex];
                }

                $formatter = $this->formatters->byFormat($candidateFormat);

                if ($currentArgumentIndex >= count($args)) {
                    throw new \InvalidArgumentException(
                        sprintf('Missing argument for formatter "%s".', $candidateFormat)
                    );
                }

                $queryStack[count($queryStack) - 1] .= $formatter->formattedString($args[$currentArgumentIndex++]);
            }

            $currentCharIndex += 1;
        }

        if (count($queryStack) !== 1) {
            throw new \InvalidArgumentException('There is no closing tag for conditional block.');
        }

        return array_pop($queryStack);
    }
}
