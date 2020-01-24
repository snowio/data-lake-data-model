<?php
namespace SnowIO\DatalakeDataModel\Events;

use SnowIO\DataLakeDataModel\Item;

class ItemSavedEvent
{
    public function fromJson(array $eventJson): self
    {
        return new self(
            Item::fromJson($eventJson['new']),
            isset($eventJson['old']) ? Item::fromJson($eventJson['old']) : null
        );
    }

    public function getCurrent(): Item
    {
        return $this->current;
    }

    public function getPrevious(): Item
    {
        return $this->previous;
    }

    public function getId(): string
    {
        return $this->current->getId();
    }

    /** @var Item */
    private $current;

    /** @var Item */
    private $previous;

    private function __construct(Item $current, ?Item $previous)
    {
        $this->current = $current;
        $this->previous = $previous;
    }
}