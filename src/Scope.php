<?php

namespace Adirsolomon\Telegram;

readonly class Scope
{

    /**
     * @param string $type
     * @param int $chatId
     */
    public function __construct(private int $chatId, private string $type = "chat")
    {
    }

    public function getChatId(): int
    {
        return $this->chatId;
    }

    public function getType(): string
    {
        return $this->type;
    }
}
