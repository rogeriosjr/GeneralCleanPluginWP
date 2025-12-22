<?php

namespace CleanGeneral\CLI;

use CleanGeneral\Core\Cleaner;
use CleanGeneral\Core\Lock;
use WP_CLI;

if (!defined('WP_CLI') || !WP_CLI) {
    return;
}

class FaxinaCommand
{
    /**
     * Executa o protocolo Faxina Geral.
     *
     * ## OPTIONS
     *
     * [--level=<level>]
     * : Nível da faxina (leve, geral, pos-guerra)
     * ---
     * default: geral
     * options:
     *   - leve
     *   - geral
     *   - pos-guerra
     * ---
     *
     * [--dry-run]
     * : Executa em modo simulação (default)
     *
     * [--no-dry-run]
     * : Executa a faxina real (destrutiva)
     *
     * ## EXAMPLES
     *
     *     wp faxina run
     *     wp faxina run --dry-run
     *     wp faxina run --level=leve
     *     wp faxina run --level=pos-guerra --no-dry-run
     */
    public function run(array $args, array $assocArgs): void
    {
        if (!Lock::acquire()) {
            WP_CLI::error(
                'Faxina Geral já está em execução. Tente novamente mais tarde.'
            );
        }
        $level = $assocArgs['level'] ?? 'geral';

        $dryRun = true;
        if (isset($assocArgs['no-dry-run'])) {
            $dryRun = false;
        }

        WP_CLI::log('🧹 General Clean');
        WP_CLI::log('----------------------------');
        WP_CLI::log('Nível: ' . $level);
        WP_CLI::log('Modo: ' . ($dryRun ? 'Dry-Run (simulação)' : 'Execução REAL'));
        WP_CLI::log('');

        $result = Cleaner::run($dryRun, $level);

        foreach ($result as $key => $value) {
            if (in_array($key, ['mode', 'level'], true)) {
                continue;
            }

            WP_CLI::log(
                sprintf('%s: %d', ucwords(str_replace('_', ' ', $key)), $value)
            );
        }

        WP_CLI::log('');
        WP_CLI::success(
            $dryRun
                ? 'Dry-Run concluído. Nenhum dado foi removido.'
                : 'Faxina Geral executada com sucesso.'
        );

        Lock::release();
    }
}

WP_CLI::add_command('clean', FaxinaCommand::class);
