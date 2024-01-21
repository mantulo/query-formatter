<?php

declare(strict_types=1);

namespace Test\Query\Formatter;

use Database\Query\Formatter\DecimalFormatter;
use Database\Query\Formatter\FloatFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class FloatFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnFormattedFloatNumber(): void
    {
        $formatter = new FloatFormatter();
        $formattedString = $formatter->formattedString(1.1);

        assertThat($formattedString, equalTo('1.1'));
    }

    #[Test]
    public function itShouldReturnStringNull(): void
    {
        $formatter = new FloatFormatter();
        $formattedString = $formatter->formattedString(null);

        assertThat($formattedString, equalTo('NULL'));
    }

    #[Test]
    public function itThrowsAnExceptionForInvalidDecimalNumber(): void
    {
        $formatter = new FloatFormatter();
        $this->expectException(\InvalidArgumentException::class);
        $formatter->formattedString('a');
    }
}