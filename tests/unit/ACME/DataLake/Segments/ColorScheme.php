<?php
namespace SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments;

use SnowIO\DataLakeDataModel\Segment;
use SnowIO\DataLakeDataModel\Test\ACME\Product;

class ColorScheme extends Segment
{
    public function getSegmentId(): string
    {
        return "color_scheme_{$this->data['scheme_id']}";
    }

    public function getItemKey(): string
    {
        return Product::SKU;
    }

    public function getItemId(): string
    {
        return $this->data['sku'];
    }

    public function onSave(): array
    {
        return [
            'schemes' => [
                $this->data['scheme_id'] => $this->data
            ],
        ];
    }

    public function onDelete(): array
    {
        return [
            'schemes' => [
                $this->data['scheme_id'] => null
            ]
        ];
    }
}