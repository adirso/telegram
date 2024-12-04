<?php

namespace Adirso\Telegram\Messages;

readonly class StickerMessage extends BaseMessage
{
    /**
     * @param string $sticker
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     */
    public function __construct(
        private string $sticker,
        ?int $replyToMessage = null,
        bool $protectContent = false,
        array $keyboard = []
    ) {
        parent::__construct(null, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return string
     */
    public function getSticker(): string
    {
        return $this->sticker;
    }
}