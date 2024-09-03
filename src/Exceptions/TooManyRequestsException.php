<?php

namespace Adirsolomon\Telegram\Exceptions;

class TooManyRequestsException extends TelegramException
{
    public static function getTelegramErrorCode(): int
    {
        return 429;
    }
}
