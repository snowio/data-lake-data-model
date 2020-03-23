<?php
namespace SnowIO\DataLakeDataModel;

interface ItemSavedEventFactory
{
    public function createItemSavedEvent(array $input);
}