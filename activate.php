<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

// Create entity backup table
$prefix = elgg_get_config('dbprefix');
$tables = get_db_tables();
if (!in_array("{$prefix}backup", $tables)) {
    run_sql_script(__DIR__ . '/sql/create_tables.sql');
}