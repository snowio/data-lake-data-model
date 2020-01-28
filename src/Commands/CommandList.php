<?php
namespace SnowIO\DataLakeDataModel\Commands;

class CommandList implements \IteratorAggregate
{
    public static function of(array $commands): self
    {
        $result = new self;
        foreach ($commands as $command) {
            $result = $result->withCommand($command);
        }
        return $result;
    }

    public function withCommand(Command $command): self
    {
        $result = clone $this;
        $result->commands[] = $command;
        return $result;
    }


    public function size(): int
    {
        return count($this->commands);
    }

    public function isEmpty(): bool
    {
        return empty($this->commands);
    }

    public function toJson(): \Iterator
    {
        $commands = array_map(function (Command $command) {
            return $command->toJson();
        }, $this->commands);
        foreach ($commands as $command) {
            yield $command;
        }
    }

    private $commands;


    public function getIterator()
    {
        foreach ($this->commands as $command) {
            yield $command;
        }
    }

    private function __construct()
    {
    }

}