<?php

namespace Adirso\Telegram\Messages;

readonly class VideoMessage extends BaseMessage
{
    /**
     * @param string $video
     * @param string|null $caption
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param bool $spoiler
     * @param array $keyboard
     */
    public function __construct(
        private string $video,
        ?string        $caption = null,
        ?int           $replyToMessage = null,
        bool           $protectContent = false,
        private bool   $spoiler = false,
        array          $keyboard = []
    )
    {
        parent::__construct($caption, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return string
     */
    public function getVideo(): string
    {
        return $this->video;
    }

    /**
     * @return bool
     */
    public function isSpoiler(): bool
    {
        return $this->spoiler;
    }
}