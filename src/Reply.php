<?php

namespace Adirso\Telegram;

abstract class Reply
{
    /**
     * @var array
     */
    protected array $keyboard = [];

    /**
     * @var string
     */
    protected string $text;

    /**
     * @var string|null
     */
    protected ?string $backButton = null;

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @param bool $withBackButton
     * @return array
     */
    public function getKeyBoard(bool $withBackButton = false): array
    {
        if ($withBackButton) {
            $this->addBackButton();
        }
        return $this->keyboard;
    }

    /**
     * @return void
     */
    protected function addBackButton(): void
    {
        $this->keyboard[][] = [
            "text" => "חזור",
            "callback_data" => $this->backButton,
        ];
    }

    /**
     * @param string $backButton
     * @return void
     */
    protected function setBackButton(string $backButton): void
    {
        $this->backButton = $backButton;
    }
}

