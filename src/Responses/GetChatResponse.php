<?php

namespace Adirso\Telegram\Responses;

class GetChatResponse extends TelegramBaseResponse
{
    /**
     * @return int
     */
    public function getId(): int
    {
        return (int) $this->get('result.id');
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return (string) $this->get('result.first_name');
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return (string) $this->get('result.last_name');
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return (string) $this->get('result.username');
    }

    /**
     * @param string $response
     * @return GetChatResponse
     */
    public static function fromGuzzle(string $response): GetChatResponse
    {
        return new static($response);
    }
}
