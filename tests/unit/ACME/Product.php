<?php

namespace SnowIO\DataLakeDataModel\Test\ACME;

use SnowIO\DataLakeDataModel\Item;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\ColorScheme;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Stock;

class Product extends Item
{
    const SKU = 'sku';

    public function getPrimaryKey(): string
    {
        return self::SKU;
    }

    public static function fromJson(array $json): self
    {
        $result = new self;
        $result = isset($json['stock']) ? $result->withSegment(Stock::fromJson($json['stock'])) : $result;
        $result = isset($json['price']) ? $result->withSegment(Price::fromJson($json['price'])) : $result;
        $result = isset($json['color_scheme']) ? $result->withSegment(ColorScheme::fromJson($json[])) : $result;

        return $result;
    }
}