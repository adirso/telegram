<?php

namespace Adirso\Telegram;

readonly class Command
{

    /**
     * @param string $command
     * @param string $description
     */
    public function __construct(private string $command, private string $description)
    {
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return string
     */
    public function getCommand(): string
    {
        return $this->command;
    }
}
