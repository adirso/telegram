<?php

namespace Adirso\Telegram;

use Adirso\Telegram\Responses\GetUpdatesResponse;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\GuzzleException;
use Adirso\Telegram\Responses\GetChatResponse;
use Adirso\Telegram\Responses\TelegramBaseResponse;
use Adirso\Telegram\Exceptions\TooManyRequestsException;
use Adirso\Telegram\Exceptions\BotBlockedByUserException;

readonly class ApiClient
{
    /**
     * @var Client
     */
    private Client $client;

    /**
     * @param string $baseUrl
     * @param Client $client
     * @param string $botToken
     */
    public function __construct(private string $baseUrl, private string $botToken)
    {
        $this->client = new Client();
    }

    /**
     * @param string $chatId
     * @param string $message
     * @param int|null $replyTo
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendMessage(string $chatId, string $message, ?int $replyTo = null): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendMessage", $this->botToken);

        $options = [
            "query" => [
                "chat_id" => $chatId,
                "text" => $message,
                "parse_mode" => "HTML"
            ]
        ];

        if ($replyTo) {
            $options['query']['reply_to_message_id'] = $replyTo;
        }

        return TelegramBaseResponse::fromGuzzle($this->request("GET", $endpoint, $options)->getBody());
    }

    /**
     * @param string $chatId
     * @param string $photo
     * @param string $caption
     * @param bool $protectContent
     * @param bool $spoiler
     * @param array $keyboard
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendSinglePhoto(string $chatId, string $photo, string $caption = "", bool $protectContent = false, bool $spoiler = false, array $keyboard = []): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendPhoto", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "photo" => $photo,
                    "caption" => $caption,
                    "protect_content" => $protectContent,
                    "has_spoiler" => $spoiler,
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $keyboard,
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param string $video
     * @param string $caption
     * @param bool $protectContent
     * @param bool $spoiler
     * @param array $keyboard
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendVideo(string $chatId, string $video, string $caption = "", bool $protectContent = false, bool $spoiler = false, array $keyboard = []): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendVideo", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "video" => $video,
                    "caption" => $caption,
                    "protect_content" => $protectContent,
                    "has_spoiler" => $spoiler,
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $keyboard,
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param string $sticker
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendSticker(string $chatId, string $sticker): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendSticker", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "sticker" => $sticker,
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param array $photos
     * @param string|null $text
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendPhotos(string $chatId, array $photos, ?string $text = null): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendMediaGroup", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "media" => json_encode($this->getMedia($photos, $text)),
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendReply(string $chatId, Reply $message): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendMessage", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "text" => $message->getText(),
                    "parse_mode" => "html",
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $message->getKeyBoard(),
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @param int $messageId
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function editMessageReplyMarkup(string $chatId, Reply $message, int $messageId): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/editMessageReplyMarkup", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "message_id" => $messageId,
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $message->getKeyBoard(),
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @param int $messageId
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function editMessage(string $chatId, Reply $message, int $messageId): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/editMessageText", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "message_id" => $messageId,
                    "text" => $message->getText(),
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $message->getKeyBoard(true),
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param CommandsCollection $commands
     * @param Scope $scope
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function setCommands(CommandsCollection $commands, Scope $scope): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/setMyCommands", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "json" => [
                    "commands" => $commands->toArray(),
                    "scope" => [
                        "type" => $scope->getType(),
                        "chat_id" => $scope->getChatId(),
                    ],
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param string $voice
     * @param bool $protectContent
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendVoice(string $chatId, string $voice, bool $protectContent = false): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendVoice", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "voice" => $voice,
                    "protect_content" => $protectContent,
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param int $messageId
     * @return void
     * @throws GuzzleException
     */
    public function deleteMessage(string $chatId, int $messageId): void
    {
        $endpoint = sprintf("/bot%s/deleteMessage", $this->botToken);
        $this->request("GET", $endpoint, [
            "query" => [
                "chat_id" => $chatId,
                "message_id" => $messageId,
            ]
        ]);
    }

    /**
     * @param string $chatId
     * @return GetChatResponse
     * @throws GuzzleException
     */
    public function getChat(string $chatId): GetChatResponse
    {
        $endpoint = sprintf("/bot%s/getChat", $this->botToken);
        return GetChatResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                ]
            ])->getBody());
    }

    /**
     * @param string $chatId
     * @param string $document
     * @param string $caption
     * @param bool $protectContent
     * @param array $keyboard
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendDocument(string $chatId, string $document, string $caption = "", bool $protectContent = false, array $keyboard = []): TelegramBaseResponse
    {
        $endpoint = sprintf("/bot%s/sendDocument", $this->botToken);
        return TelegramBaseResponse::fromGuzzle(
            $this->request("GET", $endpoint, [
                "query" => [
                    "chat_id" => $chatId,
                    "document" => $document,
                    "caption" => $caption,
                    "protect_content" => $protectContent,
                    "reply_markup" => json_encode([
                        'inline_keyboard' => $keyboard,
                    ]),
                ]
            ])->getBody());
    }

    /**
     * @param int $offset
     * @return GetUpdatesResponse
     * @throws GuzzleException
     */
    public function getUpdates(int $offset = 0): GetUpdatesResponse
    {
        $endpoint = sprintf("/bot%s/getUpdates", $this->botToken);
        return GetUpdatesResponse::fromGuzzle($this->request("GET", $endpoint, [
            "query" => [
                "offset" => $offset,
            ]
        ])->getBody());
    }

    /**
     * @param array $photos
     * @param string|null $caption
     * @return array
     */
    private function getMedia(array $photos, ?string $caption = null): array
    {
        $media = [];
        foreach ($photos as $key => $photo) {
            $media[] = [
                "type" => 'photo',
                "media" => $photo,
                "parse_mode" => "html",
            ];
            if ($key == 0) {
                $media[0]["caption"] = $caption;
            }
        }

        return $media;
    }

    /**
     * @param string $method
     * @param string $endpoint
     * @param array $options
     * @return ResponseInterface
     * @throws GuzzleException
     * @throws \Exception
     * @throws BotBlockedByUserException
     * @throws TooManyRequestsException
     */
    private function request(string $method, string $endpoint, array $options = []): ResponseInterface
    {
        try {
            return $this->client->request($method, $this->baseUrl . $endpoint, $options);
        } catch (\Exception $e) {
            if ($e->getCode() == BotBlockedByUserException::getTelegramErrorCode()) {
                throw new BotBlockedByUserException();
            }

            if ($e->getCode() == TooManyRequestsException::getTelegramErrorCode()) {
                throw new TooManyRequestsException();
            }

            throw $e;
        }
    }
}