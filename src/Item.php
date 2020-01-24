<?php

namespace SnowIO\DataLakeDataModel;

abstract class Item
{
    private $identifier;
    private $segmentList;

    public function withSegment(Segment $segment)
    {

    }

    public function getSegment(string $identifier)
    {

    }

    public static function create(): self
    {

    }
}