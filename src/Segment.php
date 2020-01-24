<?php
namespace SnowIO\DataLakeDataModel;

use SwoonTest\DatalakeLib\Commands\DeleteSegmentCommand;
use SwoonTest\DatalakeLib\Commands\SaveSegmentCommand;

abstract class Segment
{
    protected $data;

    public abstract function getSegmentName(array $eventJson): string;

    public static function fromJson(): self
    {

    }

    public function toJson(): self
    {
    }

    public function asSaveCommand(int $timestamp): SaveSegmentCommand
    {

    }

    public function asDeleteCommand(int $timestamp): DeleteSegmentCommand
    {

    }
}