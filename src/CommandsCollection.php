<?php

namespace Adirsolomon\Telegram;

readonly class CommandsCollection
{

    /**
     * @param Command[] $commands
     */
    public function __construct(private array $commands)
    {
    }

    /**
     * @return Command[]
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return array_map(function (Command $command) {
            return [
                "command" => sprintf("/%s", $command->getCommand()),
                "description" => $command->getDescription(),
            ];
        }, $this->commands);
    }
}
