<div class="wrap">
    <h1>🧹 Faxina Geral</h1>

    <?php if($data['locked']): ?>
    <div class="notice notice-warning">
        <p><strong>⚠ Faxina Geral em execução.</strong></p>
    </div>
    <?php endif; ?>

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

        <input type="hidden" name="action" value="general_clean_run">
        <?php wp_nonce_field('general_clean_run'); ?>

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
