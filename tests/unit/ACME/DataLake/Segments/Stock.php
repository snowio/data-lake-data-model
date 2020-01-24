<?php
namespace SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments;

use SnowIO\DataLakeDataModel\Segment;
use SnowIO\DataLakeDataModel\Test\ACME\Product;

class Stock extends Segment
{
    const NAME = "stock";

    public function getSegmentId(): string
    {
        return self::NAME;
    }

    public function getItemKey(): string
    {
        return Product::SKU;
    }

    public function getItemId(): string
    {
        return $this->data['sku'];
    }

    public function onSave(array $json): array
    {
        return [
            'stock' => $json
        ];
    }

    public function onDelete(array $json): array
    {
        return [
            'stock' => null
        ];
    }
}