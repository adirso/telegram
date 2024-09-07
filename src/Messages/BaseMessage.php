<?php

namespace Adirso\Telegram\Messages;

readonly abstract class BaseMessage
{
    /**
     * @param string|null $text
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     */
    public function __construct(
        private ?string $text = null,
        private ?int    $replyToMessage = null,
        private bool    $protectContent = false,
        private array   $keyboard = [],
    )
    {
    }

    /**
     * Get text on the message
     *
     * @return string|null
     */
    public function getText(): ?string
    {
        return $this->text;
    }

    /**
     * Get message id to reply on
     *
     * @return int|null
     */
    public function getReplyToMessage(): ?int
    {
        return $this->replyToMessage;
    }

    /**
     * Get is this message is protected
     *
     * @return bool
     */
    public function isProtectContent(): bool
    {
        return $this->protectContent;
    }

    /**
     * Get message keyboard
     *
     * @return array
     */
    public function getKeyboard(): array
    {
        return $this->keyboard;
    }
}