<?php

namespace Adirso\Telegram\Messages;

readonly class PhotosMessage extends BaseMessage
{
    /**
     * @param array $photos
     * @param string|null $text
     * @param int|null $replyToMessage
     * @param bool $protectContent
     * @param array $keyboard
     */
    public function __construct(
        private array $photos,
        ?string       $text = null,
        ?int          $replyToMessage = null,
        bool          $protectContent = false,
        array         $keyboard = []
    )
    {
        parent::__construct($text, $replyToMessage, $protectContent, $keyboard);
    }

    /**
     * @return array
     */
    public function getPhotos(): array
    {
        return $this->photos;
    }
}