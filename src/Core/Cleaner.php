<?php

namespace CleanGeneral\Core;

class Cleaner
{
    public static function run(bool $dryRun = false): array
    {
        global $wpdb;

        $result = [
            'mode' => $dryRun ? 'dry-run' : 'real',
        ];

        // 🗑️ Lixeira
        $result['trash_posts'] = self::execute(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'trash'",
            "DELETE FROM {$wpdb->posts} WHERE post_status = 'trash'",
            $dryRun
        );

        // 🧠 Revisões
        $result['revisions'] = self::execute(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_type = 'revision'",
            "DELETE FROM {$wpdb->posts} WHERE post_type = 'revision'",
            $dryRun
        );

        // ✍️ Auto-drafts
        $result['auto_drafts'] = self::execute(
            "SELECT COUNT(*) FROM {$wpdb->posts} WHERE post_status = 'auto-draft'",
            "DELETE FROM {$wpdb->posts} WHERE post_status = 'auto-draft'",
            $dryRun
        );

        // 💬 Comentários lixo
        $result['comments'] = self::execute(
            "SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_approved IN ('spam','trash')",
            "DELETE FROM {$wpdb->comments} WHERE comment_approved IN ('spam','trash')",
            $dryRun
        );

        // ⏱️ Transients expirados
        $result['transients'] = self::execute(
            "SELECT COUNT(*) FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_timeout_%'
             AND option_value < UNIX_TIMESTAMP()",
            "DELETE FROM {$wpdb->options}
             WHERE option_name LIKE '_transient_timeout_%'
             AND option_value < UNIX_TIMESTAMP()",
            $dryRun
        );

        return $result;
    }

    private static function execute(string $countSql, string $deleteSql, bool $dryRun): int
    {
        global $wpdb;

        if ($dryRun) {
            return (int) $wpdb->get_var($countSql);
        }

        return (int) $wpdb->query($deleteSql);
    }
}
