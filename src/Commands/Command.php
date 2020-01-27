<?php
namespace SnowIO\DataLakeDataModel\Commands;

use SnowIO\DataLakeDataModel\Item;
use SnowIO\DataLakeDataModel\Segment;

abstract class Command
{
    public static function of(Segment $segment, ?int $timestamp = null): self
    {
        return new static($segment, $timestamp);
    }

    public  function toJson(): array
    {
        return $this->timestamp ? [ '@timestamp' => $this->timestamp ] : [];
    }

    public function withTimestamp(int $timestamp): self
    {
        $result = clone $this;
        $result->timestamp = $timestamp;
        return $result;
    }

    /** @var Segment */
    protected $segment;
    /** @var Item */
    protected $timestamp;

    private function __construct(Segment $segment, ?int $timestamp = null)
    {
        $this->segment = $segment;
        $this->timestamp = $timestamp;
    }
}