<?php
namespace SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments;

use SnowIO\DataLakeDataModel\Segment;
use SnowIO\DataLakeDataModel\Test\ACME\Product;

class Price extends Segment
{
    const NAME = "price";

    public function getItemKey(): string
    {
        return Product::SKU;
    }

    public function getSegmentId(): string
    {
        return self::NAME;
    }

    public function getItemId(): string
    {
        return $this->data['id'];
    }

    public function onSave(): array
    {
        return [ 'price' => $this->data['price'] ];
    }

    public function onDelete(): array
    {
        return [ 'price' => null ];
    }
}