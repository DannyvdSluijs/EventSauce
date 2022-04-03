<?php

declare(strict_types=1);

namespace EventSauce\EventSourcing\LibraryConsumptionTests\AggregateWithDelegatedBehavior;

use EventSauce\EventSourcing\Serialization\SerializablePayload;

class DelegatedAggregateWasChosen implements SerializablePayload
{
    public function toPayload(): array
    {
        return [];
    }

    public static function fromPayload(array $payload): static
    {
        return new DelegatedAggregateWasChosen();
    }
}
