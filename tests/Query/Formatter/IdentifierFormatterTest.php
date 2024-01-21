<?php

declare(strict_types=1);

namespace Test\Query\Formatter;

use Database\Query\Formatter\IdentifierFormatter;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

use function PHPUnit\Framework\assertThat;
use function PHPUnit\Framework\equalTo;

final class IdentifierFormatterTest extends TestCase
{
    #[Test]
    public function itShouldReturnFormattedListOfIdentifiers(): void
    {
        $formatter = new IdentifierFormatter();
        $formattedString = $formatter->formattedString(['user_id', 'email', 'first_name']);

        assertThat($formattedString, equalTo('`user_id`, `email`, `first_name`'));
    }

    #[Test]
    public function itShouldReturnFormattedSingleIdentifier(): void
    {
        $formatter = new IdentifierFormatter();

        assertThat($formatter->formattedString(['user_id']), equalTo('`user_id`'));
        assertThat($formatter->formattedString('user_id'), equalTo('`user_id`'));
    }
}