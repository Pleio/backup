<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

require_once(dirname(__FILE__) . '/lib/functions.php');
require_once(dirname(__FILE__) . '/lib/events.php');

global $BACKUP_TRANSACTION_ID;

/**
 * Initialize the backup plugin and hook on deletion events.
 * 
 * @return bool
 */
function backup_init() {
    elgg_register_event_handler('delete', 'group', 'backup_event_group_delete', 0);
    elgg_register_event_handler('delete', 'object', 'backup_event_object_delete', 0);
    elgg_register_event_handler('delete', 'annotations', 'backup_event_annotation_delete', 0);
    elgg_register_event_handler('delete' ,'relationship', 'backup_event_relationship_delete', 0);

    elgg_register_admin_menu_item('administer', 'backup', 'administer_utilities');

    elgg_register_entity_type('backup', 'object');

    elgg_register_action('backup/restore', dirname(__FILE__) . '/actions/backup/restore.php', 'admin');
}

elgg_register_event_handler('init', 'system', 'backup_init');