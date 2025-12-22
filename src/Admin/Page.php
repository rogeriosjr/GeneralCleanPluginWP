<?php

namespace CleanGeneral\Admin;

use CleanGeneral\Core\Cleaner;
use CleanGeneral\Core\Logger;

defined('ABSPATH') || exit;

class Page
{
    public function __construct()
    {
        add_action('admin_menu', [$this, 'menu']);
        add_action('admin_post_faxina_geral_run', [$this, 'handle']);
    }

    public function menu(): void
    {
        add_submenu_page(
            'tools.php',
            'Faxina Geral',
            'Faxina Geral',
            'manage_options',
            'faxina-geral',
            [$this, 'render']
        );
    }

    public function render(): void
    {
        if (!current_user_can('manage_options')) {
            return;
        }

        $lastLog = get_option('faxina_geral_last_log');
        ?>

        <div class="wrap">
            <h1>🧹 Faxina Geral</h1>

            <p>
                Este protocolo remove apenas dados que o WordPress consegue recriar sozinho.
            </p>

            <ul>
                <li>✔ Lixeira (posts, páginas e CPTs)</li>
                <li>✔ Revisões</li>
                <li>✔ Auto-drafts</li>
                <li>✔ Comentários spam e lixeira</li>
                <li>✔ Transients expirados</li>
            </ul>

            <form method="post" action="<?php echo admin_url('admin-post.php'); ?>">
                <p>
                    <label>
                        <input type="checkbox" name="dry_run" value="1" checked>
                        Executar em modo <strong>Dry-Run</strong> (simulação)
                    </label>
                </p>

                <h3>🎚️ Nível de Faxina</h3>

                <select name="faxina_level">
                    <option value="leve">Leve (manutenção segura)</option>
                    <option value="geral" selected>Geral (recomendado)</option>
                    <option value="pos-guerra">
                        Pós-Guerra (uso manual e consciente)
                    </option>
                </select>

                <input type="hidden" name="action" value="faxina_geral_run">
                <?php wp_nonce_field('faxina_geral_run'); ?>

                <p>
                    <input
                        type="submit"
                        class="button button-primary"
                        value="Executar Faxina Agora"
                        onclick="return confirm('Tem certeza que deseja executar a Faxina Geral?');"
                    >
                </p>
            </form>

            <?php if ($lastLog): ?>
                <hr>
                <h2>📋 Última Execução</h2>

                <table class="widefat striped">
                    <tbody>
                        <tr>
                            <th>Nível</th>
                            <td><?php echo esc_html($lastLog['level'] ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <th>Modo</th>
                            <td>
                                <?php echo esc_html(
                                    ($lastLog['mode'] ?? '') === 'dry-run'
                                        ? '🧪 Dry-Run (Simulação)'
                                        : '🧹 Execução Real'
                                ); ?>
                            </td>
                        </tr>
                        <tr>
                            <th>Data</th>
                            <td><?php echo esc_html($lastLog['date'] ?? '-'); ?></td>
                        </tr>
                        <?php foreach ($lastLog as $key => $value): ?>
                            <?php if ($key === 'date') continue; ?>
                            <tr>
                                <th><?php echo esc_html(ucwords(str_replace('_', ' ', $key))); ?></th>
                                <td><?php echo esc_html($value ?? 0); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>

        </div>
        <?php
    }

    public function handle(): void
    {
        if (!current_user_can('manage_options')) {
            wp_die('Acesso negado');
        }

        check_admin_referer('faxina_geral_run');

        $level = $_POST['faxina_level'] ?? 'geral';
        $dryRun = isset($_POST['dry_run']) && $_POST['dry_run'] === '1';

        $result = Cleaner::run($dryRun, $level);
        Logger::log($result);

        wp_redirect(admin_url('tools.php?page=faxina-geral'));
        exit;
    }
}

new Page();
