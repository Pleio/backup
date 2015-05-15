<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

$english = array(
    'admin:administer_utilities:backup' => 'Restore backup',
    'backup:restore' => 'Restore',
    'backup:restore:confirm' => 'Are you sure you want to restore this backup?',
    'backup:restore:error:no_transaction' => 'No transaction id is given.',
    'backup:restore:succesful' => 'The backup is restored succesfully.',
    'backup:restore:error:failed' => 'The backup could not be restored.',
    'backup:retention' => 'Keep backups for',
    'backup:retention:week' => 'week',
    'backup:retention:weeks' => 'weeks',
    'backup:retention:month' => 'month',
    'backup:retention:months' => 'months',
    'backup:retention:year' => 'year',
    'backup:retention:years' => 'years'

);

add_translation("en", $english);