<?php

namespace Adirso\Telegram\Exceptions;

class TooManyRequestsException extends TelegramException
{
    public static function getTelegramErrorCode(): int
    {
        return 429;
    }
}
