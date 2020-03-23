<?php
namespace SnowIO\DataLakeDataModel\Events;

use SnowIO\DataLakeDataModel\Item;

abstract class ItemSavedEvent
{
    public abstract static function fromJson(array $eventJson);
    public abstract function getCurrent(): ?Item;
    public abstract function getPrevious(): ?Item;
    public abstract function hasPrevious(): bool;
    public abstract function getTimestamp(): bool;

    /** @var Item */
    private $previous;
    /** @var Item */
    private $current;

    public function __construct(Item $current, Item $previous)
    {
        $this->current = $current;
        $this->previous = $previous;
    }
}