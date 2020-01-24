<?php
namespace SnowIO\DataLakeDataModel\Commands;

use SnowIO\DataLakeDataModel\Segment;

class DeleteSegmentCommand extends Command
{
    public function toJson(): array
    {
        return array_merge(parent::toJson(), $this->segment->toJson(Segment::DELETE));
    }
}