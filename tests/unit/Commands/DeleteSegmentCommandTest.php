<?php

use PHPUnit\Framework\TestCase;
use SnowIO\DataLakeDataModel\Commands\DeleteSegmentCommand;
use SnowIO\DataLakeDataModel\Test\ACME\DataLake\Segments\Price;
use SnowIO\DataLakeDataModel\Test\SegmentTest;

class DeleteSegmentCommandTest extends TestCase
{
    /**
     * @testdox Should return the valid command (price segment not set)
     */
    public function testAction()
    {
        $command = DeleteSegmentCommand::of(Price::fromJson(SegmentTest::getPriceJson()))->toJson();
        self::assertNull($command['price']);
    }
}