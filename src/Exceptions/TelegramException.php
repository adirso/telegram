<?php

namespace Adirso\Telegram\Exceptions;

class TelegramException extends \RuntimeException
{
    public static function getTelegramErrorCode(): int
    {
        return 0;
    }
}
