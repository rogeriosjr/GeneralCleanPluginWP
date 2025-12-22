<?php

namespace CleanGeneral\Core;

defined('ABSPATH') || exit;

class Lock
{
    private const OPTION = 'general_clean_lock';
    private const TTL = 300; // 5 minutos

    public static function acquire(): bool
    {
        $lock = get_option(self::OPTION);

        // Lock inexistente
        if (!$lock) {
            return self::setLock();
        }

        // Lock expirado
        if (time() - (int) $lock > self::TTL) {
            return self::setLock();
        }

        // Lock ativo
        return false;
    }

    public static function release(): void
    {
        delete_option(self::OPTION);
    }

    public static function isLocked(): bool
    {
        $lock = get_option(self::OPTION);

        if (!$lock) {
            return false;
        }

        return (time() - (int) $lock) <= self::TTL;
    }

    private static function setLock(): bool
    {
        return add_option(
            self::OPTION,
            time(),
            '',
            false // autoload = no
        );
    }
}
