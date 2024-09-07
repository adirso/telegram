<?php

namespace Adirso\Telegram\Messages;

readonly class TextMessage extends BaseMessage
{
    /**
     * @param string|null $text
     * @param int|null $replyToMessage
     */
    public function __construct(?string $text = null, ?int $replyToMessage = null)
    {
        parent::__construct($text, $replyToMessage);
    }
}