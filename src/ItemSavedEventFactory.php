<?php
namespace SnowIO\DataLakeDataModel;

use SnowIO\DataLakeDataModel\Events\ItemSavedEvent;

interface ItemSavedEventFactory
{
    public function createItemSavedEvent(array $input): ItemSavedEvent;
}