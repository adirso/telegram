<?php

namespace Adirsolomon\Telegram\Exceptions;

class BotBlockedByUserException extends TelegramException
{
    public static function getTelegramErrorCode(): int
    {
        return 403;
    }
}
