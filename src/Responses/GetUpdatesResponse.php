<?php

namespace Adirso\Telegram\Responses;

class GetUpdatesResponse extends TelegramBaseResponse
{
    /**
     * @return array|null
     */
    public function getUpdates(): ?array
    {
        return $this->get('result');
    }

    /**
     * @param string $response
     * @return GetUpdatesResponse
     */
    public static function fromGuzzle(string $response): GetUpdatesResponse
    {
        return new static($response);
    }
}
