<?php

declare(strict_types=1);

namespace EventSauce\EventSourcing\AntiCorruptionLayer;

use EventSauce\EventSourcing\Message;
use PHPUnit\Framework\TestCase;

class AllowAllMessagesTest extends TestCase
{
    /**
     * @test
     * @dataProvider dpMessagesToCheck
     */
    public function it_always_allows(object $payload): void
    {
        $filter = new AllowAllMessages();

        $result = $filter->allows(new Message($payload));

        $this->assertTrue($result);
    }

    public static function dpMessagesToCheck(): iterable
    {
        yield [new StubPublicEvent('yes')];
        yield [new StubPrivateEvent('yes')];
        yield [new StubExcludedEvent('yes')];
    }
}
