<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

$dutch = array(
    'admin:administer_utilities:backup' => 'Backup terugzetten',
    'backup:restore' => 'Terugzetten',
    'backup:restore:confirm' => 'Weet je zeker dat je deze backup wil terugzetten?',    
    'backup:restore:error:no_transaction' => 'Geen transactie id gegeven.',
    'backup:restore:succesful' => 'De backup is succesvol teruggezet.',
    'backup:restore:error:failed' => 'Er is een fout opgetreden tijdens het terugzetten van de backup.',
    'backup:retention' => 'Sla backups op voor',
    'backup:retention:week' => 'week',
    'backup:retention:weeks' => 'weken',    
    'backup:retention:month' => 'maand',
    'backup:retention:months' => 'maanden',
    'backup:retention:year' => 'jaar',
    'backup:retention:years' => 'jaar'
);

add_translation("nl", $dutch);