<?php

namespace SnowIO\DataLakeDataModel\Test;

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Segment;
use SnowIO\DataLakeDataModel\SegmentSet;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Stock;

class SegmentSetTest extends TestCase
{

    public function testComposition()
    {
        $segments = SegmentSet::of([
            Price::fromJson(SegmentTest::getPriceJson())
        ]);

        self::assertNotNull($segments->get(Price::NAME));


        $segments = SegmentSet::of([
            Stock::fromJson(SegmentTest::getStockJson())
        ]);

        self::assertNotNull($segments->get(Stock::NAME));
    }

    public function testWith()
    {
        $segments = SegmentSet::create();

        self::assertTrue($segments->isEmpty());
        $segments = $segments->withSegment(Stock::fromJson(SegmentTest::getStockJson()));

        self::assertFalse($segments->isEmpty());
        $segments = $segments->withSegment(Price::fromJson(SegmentTest::getPriceJson()));

        self::assertEquals(2, $segments->size());
    }

    public function testWithIncompatibleSegments()
    {
        $this->expectException(\InvalidArgumentException::class);
        $stock = SegmentTest::getStockJson();
        $price = SegmentTest::getPriceJson();

        $price['id'] = 'test2';
        SegmentSet::of([
            Price::fromJson($price),
            Stock::fromJson($stock)
        ]);
    }

    public function testEquals()
    {
        $segments = SegmentSet::of([
            Price::fromJson(SegmentTest::getPriceJson()),
            Stock::fromJson(SegmentTest::getStockJson())
        ]);

        self::assertTrue($segments->equals($segments));

        $priceJson = SegmentTest::getPriceJson();
        $priceJson['price']['gbp'] = '9';
        $otherSegments = $segments->withSegment(Price::fromJson($priceJson));

        self::assertFalse($otherSegments->equals($segments));
    }

    public function testFiltration()
    {
        $segments = SegmentSet::of([
            Price::fromJson(SegmentTest::getPriceJson()),
            Stock::fromJson(SegmentTest::getStockJson())
        ]);

        $filteredSegments = $segments->filter(function (Segment $segment) {
           return $segment->getSegmentId()  === Price::NAME;
        });

        self::assertEquals(1, $filteredSegments->size());
    }

    public function testFirst()
    {
        $segments = SegmentSet::of([
            $price = Price::fromJson(SegmentTest::getPriceJson()),
            Stock::fromJson(SegmentTest::getStockJson())
        ]);

        $actual = $segments->first();
        self::assertTrue($actual->equals($price));
    }

    public function testFirstWithEmptySegmentSet()
    {
        $segments = SegmentSet::of([]);

        $actual = $segments->first();
        self::assertNull($actual);
    }
}