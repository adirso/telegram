<?php

namespace Adirso\Telegram\Messages;

readonly class PhotoMessage extends BaseMessage
{
    /**
     * @param string $photo
     * @param string|null $caption
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     * @param bool $spoiler
     */
    public function __construct(
        private string $photo,
        ?string        $caption = null,
        ?int           $replyToMessage = null,
        bool           $protectContent = false,
        array          $keyboard = [],
        private bool   $spoiler = false,
    )
    {
        parent::__construct($caption, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return string
     */
    public function getPhoto(): string
    {
        return $this->photo;
    }

    /**
     * @return bool
     */
    public function isSpoiler(): bool
    {
        return $this->spoiler;
    }
}