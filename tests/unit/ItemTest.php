<?php

namespace SnowIO\DataLakeDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Commands\Command;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\ColorScheme;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Stock;
use SnowIO\DataLakeDataModel\Test\ACME\Product;

class ItemTest extends TestCase
{
    /**
     * @test
     */
    public function shouldBeComposedOfSegments()
    {
        $product = Product::create()
            ->withSegment($stock = Stock::fromJson(SegmentTest::getStockJson()))
            ->withSegment($price = Price::fromJson(SegmentTest::getPriceJson()));

        self::assertTrue($price->equals($product->getSegment(Price::NAME)));
        self::assertTrue($stock->equals($product->getSegment(Stock::NAME)));
    }

    /**
     * @test
     */
    public function shouldConstructItemSaveCommands()
    {
        $commandJson = $this->toJsonWrap(Product::create()
            ->withSegment(Price::fromJson(SegmentTest::getPriceJson()))
            ->getSaveCommands());

        self::assertEquals([[
            '@segment' => "price",
            'sku' => 'test1',
            'price' => [
                'gbp' => "30",
                'usd' => "40"
            ]
        ]], $commandJson);

        $commandJson = $this->toJsonWrap(Product::create()
            ->withSegment(Stock::fromJson(SegmentTest::getStockJson()))
            ->getSaveCommands(1));

        self::assertEquals([[
            '@segment' => "stock",
            'sku' => 'test1',
            'stock' => [
                'sku' => 'test1',
                'qty' => "30",
                'recQty' => "50"
            ],
            '@timestamp' => 1
        ]], $commandJson);

        $commandJson = $this->toJsonWrap(Product::create()
            ->withSegment(ColorScheme::fromJson(SegmentTest::getColorSchemeJson()))
            ->getSaveCommands());

        self::assertEquals([[
            '@segment' => "color_scheme_test_scheme1",
            'sku' => 'test1',
            'schemes' => [ 'test_scheme1' => SegmentTest::getColorSchemeJson() ]
        ]], $commandJson);
    }

    private function toJsonWrap(\Iterator $iterator)
    {
        return array_map(function (Command $command) {
            return $command->toJson();
        }, iterator_to_array($iterator));
    }
}