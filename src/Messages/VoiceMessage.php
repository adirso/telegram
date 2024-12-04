<?php

namespace Adirso\Telegram\Messages;

readonly class VoiceMessage extends BaseMessage
{
    /**
     * @param string $voice
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     */
    public function __construct(
        private string $voice,
        ?int           $replyToMessage = null,
        bool           $protectContent = false,
        array          $keyboard = []
    )
    {
        parent::__construct(null, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return string
     */
    public function getVoice(): string
    {
        return $this->voice;
    }
}