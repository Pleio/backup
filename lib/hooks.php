<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

/**
 * A plugin hook for the cron to delete old backups
 *
 * @param string $hook the 'cron' hook
 * @param string $type the 'daily' interval
 * @param unknown_type $returnvalue default return value
 * @param array $params supplied params
 *
 * @return void
 */
function backup_daily_cron_handler($hook, $type, $returnvalue, $params) {
    global $CONFIG;

    $site = $CONFIG->site_guid;
    $retention = elgg_get_plugin_setting('retention', 'backup');
    if (!$retention) {
        $retention = BACKUP_DEFAULT_RETENTION;
    }

    $date = mktime(date('i'), date('i'), date('s'), date('n'), date('j')-$retention, date('Y'));
    $query = "DELETE FROM {$CONFIG->dbprefix}backup WHERE site_guid=$site AND time_created < " . $date;

    if (delete_data($query) >= 0) {
        return true;
    } else {
        return false;
    }
}