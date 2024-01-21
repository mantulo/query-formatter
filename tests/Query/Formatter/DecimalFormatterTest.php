<?php

declare(strict_types=1);

namespace Test\Query\Formatter;

use Database\Query\Formatter\DecimalFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class DecimalFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnFormattedDecimalNumber(): void
    {
        $formatter = new DecimalFormatter();
        $formattedString = $formatter->formattedString(1);

        assertThat($formattedString, equalTo('1'));
    }

    #[Test]
    public function itShouldReturnStringNull(): void
    {
        $formatter = new DecimalFormatter();
        $formattedString = $formatter->formattedString(null);

        assertThat($formattedString, equalTo('NULL'));
    }

    #[Test]
    public function itThrowsAnExceptionForInvalidDecimalNumber(): void
    {
        $formatter = new DecimalFormatter();
        $this->expectException(\InvalidArgumentException::class);
        $formatter->formattedString('a');
    }
}