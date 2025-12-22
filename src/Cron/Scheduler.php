<?php

namespace CleanGeneral\Cron;

use CleanGeneral\Core\Cleaner;
use CleanGeneral\Core\Logger;
use CleanGeneral\Core\Lock;

class Scheduler
{
    public function __construct()
    {
        add_action('general_clean_run', [$this, 'run']);

        register_activation_hook(
            dirname(__DIR__, 2) . '/general-clean.php',
            [$this, 'activate']
        );

        register_deactivation_hook(
            dirname(__DIR__, 2) . '/general-clean.php',
            [$this, 'deactivate']
        );
    }

    public function run(): void
    {
        if (!Lock::acquire()) {
            return;
        }

        $result = Cleaner::run(false, 'geral');
        Logger::log($result);

        Lock::release();
    }

    public function activate(): void
    {
        if (!wp_next_scheduled('general_clean_run')) {
            wp_schedule_event(time(), 'weekly', 'general_clean_run');
        }
    }

    public function deactivate(): void
    {
        wp_clear_scheduled_hook('general_clean_run');
    }
}
