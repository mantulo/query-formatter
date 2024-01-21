<?php

declare(strict_types=1);

namespace Test\Query;

use Database\Query\Formatter\ArrayFormatter;
use Database\Query\Formatter\DecimalFormatter;
use Database\Query\Formatter\DefaultFormatter;
use Database\Query\Formatter\FloatFormatter;
use Database\Query\Formatter\IdentifierFormatter;
use Database\Query\FormatterRegistry;
use Database\QueryFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class QueryFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnFormattedQueryWithoutPlaceholders(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: false);
        $formattedString = $formatter->formattedString('SELECT name FROM users WHERE user_id = 1', []);

        assertThat(
            $formattedString,
            equalTo('SELECT name FROM users WHERE user_id = 1')
        );
    }

    #[Test]
    public function itShouldReturnFormattedQueryStringUsingDefaultFormatter(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: false);
        $formattedString = $formatter->formattedString('SELECT * FROM users WHERE name = ? AND block = 0', ['Jack']);

        assertThat(
            $formattedString,
            equalTo('SELECT * FROM users WHERE name = \'Jack\' AND block = 0')
        );
    }

    #[Test]
    public function itShouldReturnFormattedQueryStringUsingDecimalAndIdentifierFormatters(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: false);
        $formattedString = $formatter->formattedString('SELECT ?# FROM users WHERE user_id = ?d AND block = ?d', [['name', 'email'], 2, true]);

        assertThat(
            $formattedString,
            equalTo('SELECT `name`, `email` FROM users WHERE user_id = 2 AND block = 1')
        );
    }

    #[Test]
    public function itShouldReturnFormattedQueryStringUsingArrayFormatter(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: false);
        $formattedString = $formatter->formattedString('UPDATE users SET ?a WHERE user_id = -1', [['name' => 'Jack', 'email' => null]]);

        assertThat(
            $formattedString,
            equalTo('UPDATE users SET `name` = \'Jack\', `email` = NULL WHERE user_id = -1')
        );
    }

    #[Test]
    public function itShouldReturnFormattedQueryStringWithoutConditionalBlock(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: true);
        $formattedString = $formatter->formattedString('SELECT name FROM users WHERE ?# IN (?a){ AND block = ?d}', ['user_id', [1, 2, 3], null]);

        assertThat(
            $formattedString,
            equalTo('SELECT name FROM users WHERE `user_id` IN (1, 2, 3)')
        );
    }

    #[Test]
    public function itShouldReturnFormattedQueryStringWithConditionalBlock(): void
    {
        $formatter = $this->queryFormatter(skipConditionalBlocks: false);
        $formattedString = $formatter->formattedString('SELECT name FROM users WHERE ?# IN (?a){ AND block = ?d}', ['user_id', [1, 2, 3], true]);

        assertThat(
            $formattedString,
            equalTo('SELECT name FROM users WHERE `user_id` IN (1, 2, 3) AND block = 1')
        );
    }

    private function queryFormatter(bool $skipConditionalBlocks): QueryFormatter
    {
        return new QueryFormatter(
            new FormatterRegistry(
                new ArrayFormatter(),
                new IdentifierFormatter(),
                new DecimalFormatter(),
                new FloatFormatter(),
                new DefaultFormatter()
            ),
            $skipConditionalBlocks
        );
    }
}
