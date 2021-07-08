<?php
namespace SnowIO\DataLakeDataModel;

interface ItemSavedEventFactory
{
    public function create(array $input);
}