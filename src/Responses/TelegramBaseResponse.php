<?php

namespace Adirso\Telegram\Responses;

use Adirso\Telegram\Exceptions\ResponseParsingFailedException;

class TelegramBaseResponse
{
    /**
     * @var array
     */
    protected array $response;

    /**
     * @param string $response
     */
    public function __construct(string $response)
    {
        $tempResponse = json_decode($response, true);
        if (!is_array($tempResponse)) {
            throw new ResponseParsingFailedException();
        }
        $this->response = $tempResponse;
    }

    /**
     * @return int
     */
    public function getMessageId(): int
    {
        return (int)$this->get('result.message_id');
    }

    /**
     * @param string $response
     * @return TelegramBaseResponse
     */
    public static function fromGuzzle(string $response): TelegramBaseResponse
    {
        return new static($response);
    }

    /**
     * @return array
     */
    public function getResponse(): array
    {
        return $this->response;
    }

    /**
     * @param string $key
     * @param $default
     * @return mixed|null
     */
    public function get(string $key, $default = null): mixed
    {
        $indexes = explode('.', $key);
        $searchPosition = $this->response;
        foreach ($indexes as $index) {
            if (isset($searchPosition[$index])) {
                $searchPosition = $searchPosition[$index];
            } else {
                return $default;
            }
        }
        return $searchPosition;
    }
}
