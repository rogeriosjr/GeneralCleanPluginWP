<?php

namespace CleanGeneral\Admin;

use CleanGeneral\Core\Cleaner;
use CleanGeneral\Core\Logger;
use CleanGeneral\Core\Lock;
use CleanGeneral\Core\View;

defined('ABSPATH') || exit;

class Page
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_post_general_clean_run', [$this, 'handle']);
    }

    public function menu(): void
    {
        add_submenu_page(
            'tools.php',
            'Faxina Geral',
            'Faxina Geral',
            'manage_options',
            'general_clean',
            [$this, 'render']
        );
    }

    public function render(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        if (Lock::isLocked()) {
            wp_die(
                '⚠ A Faxina Geral já está em execução. Aguarde finalizar.'
            );
        }

        $lastLog = get_option('faxina_geral_last_log');
        $locked = false;

        if (Lock::isLocked()): 
            $data['locked'] = true;
        endif;

        View::render('page', [
            'locked' => $data,
            'lastLog' => $lastLog,
        ]);
    }

    public function handle(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die('Acesso negado');
        }

        check_admin_referer('general_clean_run');

        $level = $_POST['faxina_level'] ?? 'geral';
        $dryRun = isset($_POST['dry_run']) && $_POST['dry_run'] === '1';

        $result = Cleaner::run($dryRun, $level);
        Logger::log($result);

        wp_redirect(admin_url('tools.php?page=general_clean'));
        exit;
    }
}
