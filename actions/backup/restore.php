<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

$transaction = get_input('transaction', false);

if (!$transaction) {
    register_error(elgg_echo('backup:restore:error:no_transaction'));
    forward(REFERER);
}

backup_restore_transaction($transaction);

forward(REFERER);