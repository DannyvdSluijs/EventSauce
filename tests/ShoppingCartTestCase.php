<?php
declare(strict_types=1);

namespace PeventSauce;

use Closure;
use EventSauce\EventSourcing\LibraryConsumptionTests\ShoppingCartExample\ShoppingCart;
use EventSauce\EventSourcing\LibraryConsumptionTests\ShoppingCartExample\ShoppingCartId;
use EventSauce\EventSourcing\TestUtilities\AggregateRootTestCase;

class ShoppingCartTestCase extends AggregateRootTestCase
{
    protected function newAggregateRootId(): ShoppingCartId
    {
        return ShoppingCartId::create();
    }

    protected function aggregateRootClassName(): string
    {
        return ShoppingCart::class;
    }

    public function handle(Closure $closure): void
    {
        /** @var ShoppingCart $aggregate */
        $aggregate = $this->repository->retrieve($this->aggregateRootId);
        $closure($aggregate);
        $this->repository->persist($aggregate);
    }
}
