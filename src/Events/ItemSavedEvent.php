<?php
namespace SnowIO\DataLakeDataModel\Events;

use SnowIO\DataLakeDataModel\Item;

abstract class ItemSavedEvent
{
    public abstract static function fromJson(array $eventJson);

    /**
     * @return Item
     */
    public function getCurrent()
    {
        return $this->current;
    }

    /**
     * @return Item
     */
    public function getPrevious()
    {
        return $this->previous;
    }

    public function hasPrevious(): bool
    {
        return $this->previous !== null;
    }

    /** @var Item */
    private $previous;
    /** @var Item */
    private $current;

    /**
     * ItemSavedEvent constructor.
     * @param Item $current
     * @param Item $previous
     */
    private function __construct($current, $previous)
    {
        $this->current = $current;
        $this->previous = $previous;
    }
}