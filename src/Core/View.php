<?php

namespace CleanGeneral\Core;

class View
{
    public static function render(string $view, array $data = []): void
    {
        $file = plugin_dir_path(__DIR__) . 'View/' . $view . '.php';
        error_log(print_r($file, true));

        if (!file_exists($file)) {
            throw new \RuntimeException("View não encontrada: {$view}");
        }

        extract($data, EXTR_SKIP);
        require $file;
    }
}
