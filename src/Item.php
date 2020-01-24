<?php

namespace SnowIO\DataLakeDataModel;

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

    public function getSaveCommands(int $timestamp = null): \Iterator
    {
        foreach ($this->segments as $segment) {
            yield SaveSegmentCommand::of($segment, $timestamp);
        }
    }

    public function getDeleteCommands(int $timestamp = 0): \Iterator
    {
        foreach ($this->segments as $segment) {
            yield DeleteSegmentCommand::of($segment, $timestamp);
        }
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