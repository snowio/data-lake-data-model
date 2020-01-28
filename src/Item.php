<?php

namespace SnowIO\DataLakeDataModel;

use SnowIO\DataLakeDataModel\Commands\Command;
use SnowIO\DataLakeDataModel\Commands\CommandList;
use SnowIO\DataLakeDataModel\Commands\DeleteSegmentCommand;
use SnowIO\DataLakeDataModel\Commands\SaveSegmentCommand;

abstract class Item
{
    public abstract function getPrimaryKey(): string;
    public static abstract function fromJson(array $json);

    public function getId()
    {
       return $this->segments->getItemId();
    }

    public function withSegment(Segment $segment): self
    {
        $result = clone $this;
        $result->segments = $result->segments->withSegment($segment);
        return $result;
    }

    public function getSegment(string $identifier): ?Segment
    {
        return $this->segments->get($identifier);
    }

    public function getSaveCommands(int $timestamp = null): CommandList
    {
        return CommandList::of(array_map(function (Segment $segment) use ($timestamp) {
            return SaveSegmentCommand::of($segment, $timestamp);
        }, iterator_to_array($this->segments)));
    }

    public function getDeleteCommands(int $timestamp = 0): CommandList
    {
        return CommandList::of(array_map(function (Segment $segment) use ($timestamp) {
            return DeleteSegmentCommand::of($segment, $timestamp);
        }, iterator_to_array($this->segments)));
    }

    public static function create(): self
    {
        return new static;
    }

    /**
     * @var SegmentSet
     */
    protected $segments;

    protected function __construct()
    {
        $this->segments = SegmentSet::create();
    }
}