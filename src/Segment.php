<?php

namespace SnowIO\DataLakeDataModel;


abstract class Segment
{
    const SAVE = 'save';
    const DELETE = 'delete';

    protected $data;

    public abstract function getSegmentId(): string;

    public abstract function getItemId(): string;

    public abstract function getItemKey(): string;

    public abstract function onSave(): array;

    public abstract function onDelete(): array;

    public static function fromJson(array $json): self
    {
        $result = new static;
        $result->data = $json;
        $result->saveData = $result->onSave();
        $result->deleteData = $result->onDelete();
        return $result;
    }

    public function toJson(?string $action = null): array
    {
        if ($action !== null) {
            $data = $action === self::SAVE ? $this->saveData : $this->deleteData;
        } else {
            $data = $this->data;
        }

        return array_merge($data, ["@segment" => $this->getSegmentId()], [$this->getItemKey() => $this->getItemId()]);
    }

    public function getRawData(): array
    {
        return $this->data;
    }

    private $saveData = [];
    private $deleteData = [];

    public function equals($other): bool
    {
        return $other instanceof self &&
            $other->getSegmentId() === $this->getSegmentId() &&
            $other->data == $this->data;
    }
}