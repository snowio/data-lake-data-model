<?php

namespace SnowIO\DataLakeDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Stock;

class SegmentTest extends TestCase
{
    public function testEquality()
    {
        self::assertTrue(
            Stock::fromJson(self::getStockJson())
                ->equals(Stock::fromJson(self::getStockJson()))
        );

        $otherSegment = self::getStockJson();
        $otherSegment['stock']['qty'] = "83";

        self::assertFalse(Stock::fromJson(self::getStockJson())->equals(Stock::fromJson($otherSegment)));
    }

    public function testToJson()
    {
        self::assertEquals(
            array_merge(self::getStockJson(), ['@segment' => 'stock']),
            Stock::fromJson(self::getStockJson())->toJson()
        );
    }

    public static function getStockJson()
    {
        return [
            'sku' => 'test1',
            'qty' => "30",
            'recQty' => "50"
        ];
    }

    public static function getPriceJson()
    {
        return [
            'id' => 'test1',
            'price' => [
                'gbp' => "30",
                'usd' => "40"
            ],
        ];
    }

    public static function getColorSchemeJson()
    {
        return [
            'sku' => 'test1',
            'scheme_id' => 'test_scheme1',
            'popularity' => 'Very',
            'hex' => '#00FFA10',
            'name' => 'Odd Color',
            'rgb_code' => '0, 256, 104',
            'description' => 'Awesomely made color'
        ];
    }
}