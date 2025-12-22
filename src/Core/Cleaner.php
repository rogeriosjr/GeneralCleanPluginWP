<?php

namespace CleanGeneral\Core;

class Cleaner
{
    public static function run(
        bool $dryRun = true,
        string $level = 'geral'
    ): array {
        global $wpdb;

        $result = [
            'mode'  => $dryRun ? 'dry-run' : 'real',
            'level' => $level,
        ];

        // ===== LEVE =====
        $result['trash_posts'] = self::exec(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'trash'",
            "DELETE FROM {$wpdb->posts} WHERE post_status = 'trash'",
            $dryRun
        );

        $result['comments'] = self::exec(
            "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved IN ('spam','trash')",
            "DELETE FROM {$wpdb->comments} WHERE comment_approved IN ('spam','trash')",
            $dryRun
        );

        $result['expired_transients'] = self::exec(
            "SELECT COUNT(*) FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_timeout_%'
             AND option_value < UNIX_TIMESTAMP()",
            "DELETE FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_timeout_%'
             AND option_value < UNIX_TIMESTAMP()",
            $dryRun
        );

        // ===== GERAL =====
        if (in_array($level, ['geral', 'pos-guerra'], true)) {

            $result['revisions'] = self::exec(
                "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'",
                "DELETE FROM {$wpdb->posts} WHERE post_type = 'revision'",
                $dryRun
            );

            $result['auto_drafts'] = self::exec(
                "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'auto-draft'",
                "DELETE FROM {$wpdb->posts} WHERE post_status = 'auto-draft'",
                $dryRun
            );
        }

        // ===== PÓS-GUERRA =====
        if ($level === 'pos-guerra') {

            $result['all_transients'] = self::exec(
                "SELECT COUNT(*) FROM {$wpdb->options}
                 WHERE option_name LIKE '_transient_%'",
                "DELETE FROM {$wpdb->options}
                 WHERE option_name LIKE '_transient_%'",
                $dryRun
            );
        }

        return $result;
    }

    private static function exec(string $count, string $delete, bool $dryRun): int
    {
        global $wpdb;
        return $dryRun
            ? (int) $wpdb->get_var($count)
            : (int) $wpdb->query($delete);
    }
}
