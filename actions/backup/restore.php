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

if (backup_restore_transaction($transaction)) {
    system_message(elgg_echo('backup:restore:succesful'));
} else {
    register_error(elgg_echo('backup:restore:failed'));
}

forward(REFERER);