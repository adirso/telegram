<?php

namespace Adirso\Telegram;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Adirso\Telegram\Responses\GetChatResponse;
use Adirso\Telegram\Responses\TelegramBaseResponse;

class TelegramService
{
    /**
     * Telegram base URL
     */
    const BASE_URL = "https://api.telegram.org";

    /**
     * Telegram API client
     *
     * @var ApiClient
     */
    private ApiClient $client;

    /**
     * @param string $token
     * @param string|null $baseUrl
     */
    public function __construct(string $token, ?string $baseUrl = null)
    {
        $this->client = new ApiClient(
            $baseUrl ?? self::BASE_URL,
            $token
        );
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
        return $this->client->sendMessage($chatId, $message, $replyTo);
    }

    /**
     * @param string $chatId
     * @param array $photos
     * @param string|null $text
     * @return void
     * @throws GuzzleException
     */
    public function sendPhotos(string $chatId, array $photos, ?string $text = null): void
    {
        $this->client->sendPhotos($chatId, $photos, $text);
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
    public function sendPhoto(string $chatId, string $photo, string $caption = "", bool $protectContent = false, bool $spoiler = false, array $keyboard = []): TelegramBaseResponse
    {
        return $this->client->sendSinglePhoto($chatId, $photo, $caption, $protectContent, $spoiler, $keyboard);
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
        return $this->client->sendVideo($chatId, $video, $caption, $protectContent, $spoiler, $keyboard);
    }

    /**
     * @param string $chatId
     * @param string $sticker
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendSticker(string $chatId, string $sticker): TelegramBaseResponse
    {
        return $this->client->sendSticker($chatId, $sticker);
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @return TelegramBaseResponse
     * @throws GuzzleException
     */
    public function sendReply(string $chatId, Reply $message): TelegramBaseResponse
    {
        return $this->client->sendReply($chatId, $message);
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @param int $messageId
     * @return void
     * @throws GuzzleException
     */
    public function editMessage(string $chatId, Reply $message, int $messageId): void
    {
        $this->client->editMessage($chatId, $message, $messageId);
    }

    /**
     * @param string $chatId
     * @param Reply $message
     * @param int $messageId
     * @return void
     * @throws GuzzleException
     */
    public function editMessageReplyMarkup(string $chatId, Reply $message, int $messageId): void
    {
        $this->client->editMessageReplyMarkup($chatId, $message, $messageId);
    }

    /**
     * @param CommandsCollection $collection
     * @param Scope $scope
     * @return void
     * @throws GuzzleException
     */
    public function setCommands(CommandsCollection $collection, Scope $scope): void
    {
        $this->client->setCommands($collection, $scope);
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
        return $this->client->sendVoice($chatId, $voice, $protectContent);
    }

    /**
     * @param string $chatId
     * @param int $messageId
     * @return void
     * @throws GuzzleException
     */
    public function deleteMessage(string $chatId, int $messageId): void
    {
        $this->client->deleteMessage($chatId, $messageId);
    }

    /**
     * @param string $chatId
     * @return GetChatResponse
     * @throws GuzzleException
     */
    public function getChat(string $chatId): GetChatResponse
    {
        return $this->client->getChat($chatId);
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
        return $this->client->sendDocument($chatId, $document, $caption, $protectContent, $keyboard);
    }

    /**
     * @param int $offset
     * @return array
     * @throws GuzzleException
     */
    public function getUpdates(int $offset = 0): array
    {
        return $this->client->getUpdates($offset)->getUpdates();
    }
}
