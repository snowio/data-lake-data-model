<?php

namespace SnowIO\DataLakeDataModel\Test\Commands;

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Commands\CommandList;
use SnowIO\DataLakeDataModel\Commands\SaveSegmentCommand;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Stock;
use SnowIO\DataLakeDataModel\Test\SegmentTest;

class CommandListTest extends TestCase
{

    public function testInitialization()
    {
        $commandList = CommandList::of([SaveSegmentCommand::of(Price::fromJson(SegmentTest::getPriceJson()))]);

        self::assertEquals(1, $commandList->size());
        self::assertFalse($commandList->isEmpty());
    }

    public function testWither()
    {
        $commandList = CommandList::of([SaveSegmentCommand::of(Price::fromJson(SegmentTest::getPriceJson()))]);
        $commandList = $commandList->withCommand(SaveSegmentCommand::of(Stock::fromJson(SegmentTest::getStockJson())));

        self::assertEquals(2, $commandList->size());
    }

    public function testToJson()
    {
        $commandList = CommandList::of([
            SaveSegmentCommand::of(Price::fromJson(SegmentTest::getPriceJson()))->withTimestamp(300)
        ]);

        self::assertEquals([
            [
                '@segment' => 'price',
                'sku' => 'test1',
                'price' => SegmentTest::getPriceJson()['price'],
                '@timestamp' => 300
            ]
        ], iterator_to_array($commandList->toJson()));
    }
}