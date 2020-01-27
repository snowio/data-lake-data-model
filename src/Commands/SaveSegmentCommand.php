<?php

namespace SnowIO\DataLakeDataModel\Commands;

use SnowIO\DataLakeDataModel\Segment;

class SaveSegmentCommand extends Command
{
    public function toJson(): array
    {
        return array_merge(parent::toJson(), $this->segment->toJson(Segment::SAVE));
    }
}