<?php
namespace SnowIO\DataLakeDataModel\Test\ACME\DataLake;

use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\ACME\Product;

function getSavePriceSegmentToProduct(array $eventJson): \Iterator
{
    return Product::create()
        ->withSegment(Price::fromJson($eventJson))
        ->getSaveCommands();
}

function getRemovePriceSegmentToProduct(array $eventJson): \Iterator
{
    return Product::create()
        ->withSegment(Price::fromJson($eventJson))
        ->getDeleteCommands();
}