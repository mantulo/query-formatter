<?php

declare(strict_types=1);

namespace Test\Query\Formatter;

use Database\Query\Formatter\ArrayFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class ArrayFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnFormattedList(): void
    {
        $formatter = new ArrayFormatter();
        $formattedString = $formatter->formattedString([1,2,3]);

        assertThat($formattedString, equalTo('1, 2, 3'));
    }

    #[Test]
    public function itShouldReturnFormattedStringForArrayMap(): void
    {
        $formatter = new ArrayFormatter();
        $formattedString = $formatter->formattedString([
            'user_id' => 1,
            'email' => 'user@example.com',
            'first_name' => null,
        ]);

        assertThat($formattedString, equalTo('`user_id` = 1, `email` = \'user@example.com\', `first_name` = NULL'));
    }
}