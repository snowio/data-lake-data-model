<?php
namespace SnowIO\DataLakeDataModel;

use Traversable;

class SegmentSet implements \IteratorAggregate
{
    /**
     * @param Segment[] $segments
     * @return SegmentSet
     */
    public static function of(array $segments)
    {
        $result = new self;
        foreach ($segments as $segment) {
            $result = $result->withSegment($segment);
        }

        return $result;
    }

    public static function create()
    {
        return new self;
    }

    public function withSegment(Segment $segment): self
    {
        $result = clone $this;
        $this->assertSegmentHasTheSameId($segment);
        $result->segments[$segment->getSegmentId()] = $segment;
        return $result;
    }

    private function assertSegmentHasTheSameId(Segment $otherSegment)
    {
        /** @var Segment $segment */
        foreach ($this->segments as $segment)  {
            if ($segment->getItemId() !== $otherSegment->getItemId()) {
                throw new \InvalidArgumentException("Segments should all have valid ids");
            }
        }
    }

    /**
     * Since we assert that all the segments have the same itemId to get the
     * itemId we return the itemId of any segment
     * @return null|string
     */
    public function getItemId(): ?string
    {
        $segment = reset($this->segments) ?? null;
        return $segment ? $segment->getItemId() : null;
    }

    public function get(string $segmentId): ?Segment
    {
        return $this->segments[$segmentId] ?? null;
    }

    public function isEmpty(): bool
    {
        return count($this->segments) === 0;
    }

    public function size(): int
    {
        return count($this->segments);
    }

    public function has(string $segmentId): bool
    {
        return $this->get($segmentId) !== null;
    }

    /** @var Segment[] */
    private $segments = [];

    private function __construct()
    {
    }

    public function getIterator()
    {
        foreach ($this->segments as $segment) {
            yield $segment;
        }
    }

    public function toJson(?string $action): array
    {
        $itemData = [];
        foreach ($this->segments as $segment) {
            $itemData = $itemData + $segment->toJson($action);
        }

        return $itemData;
    }

    public function equals($other)
    {
        if (!($other instanceof self)) {
            return false;
        }


        return $this->compareSegments($this, $other) && $this->compareSegments($other, $this);
    }


    private function compareSegments(self $segments, self $otherSegments)
    {
        /** @var Segment $segment */
        foreach ($segments as $segment) {
            if (!$otherSegments->has($segment->getSegmentId())) {
                return false;
            }

            if (!$otherSegments->get($segment->getSegmentId())->equals($segment)) {
                return false;
            }
        }

        return true;
    }

}