<?php

namespace CleanGeneral\Core;

class Logger
{
    public static function log(array $data): void
    {
        $data['date'] = current_time('mysql');
        update_option('faxina_geral_last_log', $data);
    }
}
