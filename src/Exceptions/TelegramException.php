<?php

namespace Adirsolomon\Telegram\Exceptions;

class TelegramException extends \RuntimeException
{
    public static function getTelegramErrorCode(): int
    {
        return 0;
    }
}
