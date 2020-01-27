<?php

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Commands\SaveSegmentCommand;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\SegmentTest;

class SaveSegmentCommandTest extends TestCase
{

    /**
     * @testdex should return the valid command (price isset)
     */
    public function testAction()
    {
        $command = SaveSegmentCommand::of(Price::fromJson(SegmentTest::getPriceJson()))->toJson();
        self::assertNotNull($command['price']);
    }

}