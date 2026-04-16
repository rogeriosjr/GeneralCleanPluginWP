<?php declare(strict_types=1);

/**
 * Plugin Name: General Clean
 * Plugin URI: https://wordpress.org/plugins/general-clean/
 * Description: Plugin avançado de limpeza e manutenção segura para WordPress.
 * Version: 1.0.0
 * Requires at least: 6.0
 * Requires PHP: 8.1
 * Author: Rogério Rios Júnior
 * Author URI: https://clickartweb.com.br
 * License: MIT
 * License URI: https://opensource.org/licenses/MIT
 * Text Domain: general-clean
 */

defined('ABSPATH') || exit;

// Autoload Composer
require_once __DIR__ . '/vendor/autoload.php';

// Inicializações
new CleanGeneral\Admin\Page();
new CleanGeneral\Cron\Scheduler();

// WP-CLI
if (defined('WP_CLI') && WP_CLI) {
    WP_CLI::add_command(
        'faxina-geral',
        CleanGeneral\CLI\FaxinaCommand::class
    );
}
