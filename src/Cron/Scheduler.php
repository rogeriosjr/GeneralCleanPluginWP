<?php

namespace CleanGeneral\Cron;

use CleanGeneral\Core\Cleaner;
use CleanGeneral\Core\Logger;

add_action('faxina_geral_run', function () {
    $result = Cleaner::run();
    Logger::log($result);
});

register_activation_hook(__FILE__, function () {
    if (!wp_next_scheduled('faxina_geral_run')) {
        wp_schedule_event(time(), 'weekly', 'faxina_geral_run');
    }
});

register_deactivation_hook(__FILE__, function () {
    wp_clear_scheduled_hook('faxina_geral_run');
});
