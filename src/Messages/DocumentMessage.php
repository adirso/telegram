<?php

namespace Adirso\Telegram\Messages;

readonly class DocumentMessage extends BaseMessage
{
    /**
     * @param string $document
     * @param string|null $caption
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     */
    public function __construct(
        private string $document,
        ?string        $caption = null,
        ?int           $replyToMessage = null,
        bool           $protectContent = false,
        array          $keyboard = []
    )
    {
        parent::__construct($caption, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return string
     */
    public function getDocument(): string
    {
        return $this->document;
    }
}