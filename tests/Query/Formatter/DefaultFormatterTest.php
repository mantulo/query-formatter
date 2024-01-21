<?php

declare(strict_types=1);

namespace Test\Query\Formatter;

use Database\Query\Formatter\DefaultFormatter;
use Database\Query\Formatter\Formatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class DefaultFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnNullString(): void
    {
        $formattedString = $this->formatter()->formattedString(null);
        assertThat($formattedString, equalTo('NULL'));
    }

    #[Test]
    public function itShouldReturnSingleString(): void
    {
        $formattedString = $this->formatter()->formattedString('user@example.com');

        assertThat($formattedString, equalTo("'user@example.com'"));
    }

    #[Test]
    public function itShouldReturnBooleanCastedToString(): void
    {
        $formattedString = $this->formatter()->formattedString(true);
        assertThat($formattedString, equalTo('1'));

        $formattedString = $this->formatter()->formattedString(false);
        assertThat($formattedString, equalTo('0'));
    }

    private function formatter(): Formatter
    {
        return new DefaultFormatter();
    }
}