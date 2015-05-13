<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

/**
 * @param string $event       The name of the event
 * @param string $object_type The type of $object ("group")
 * @param mixed  $object      The object of the event
 *
 * @return bool if false, the handler is requesting to cancel the event
 */
function backup_event_group_delete($event, $object_type, $object) {
    global $CONFIG;

    $data = array(
        'entities' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}entities WHERE guid='$object->guid'"),
        'groups_entity' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}objects_entity WHERE guid='$object->guid'"),
        'metadata' => get_data("SELECT * FROM {$CONFIG->dbprefix}metadata WHERE entity_guid='$object->guid'"),
        'private_settings' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}objects_entity WHERE guid='$object->guid'"),
    );   

    return backup_insert($object_type, $data);
}

/**
 * @param string $event       The name of the event
 * @param string $object_type The type of $object ("object")
 * @param mixed  $object      The object of the event
 *
 * @return bool if false, the handler is requesting to cancel the event
 */
function backup_event_object_delete($event, $object_type, $object) {
    global $CONFIG;

    $data = array(
        'entities' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}entities WHERE guid='$object->guid'"),
        'objects_entity' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}objects_entity WHERE guid='$object->guid'"),
        'metadata' => get_data("SELECT * FROM {$CONFIG->dbprefix}metadata WHERE entity_guid='$object->guid'"),
        'private_settings' => get_data("SELECT * FROM {$CONFIG->dbprefix}private_settings WHERE entity_guid='$object->guid'")
    );

    return backup_insert($object_type, $data);
}

/**
 * @param string $event       The name of the event
 * @param string $object_type The type of $object ("annotations")
 * @param mixed  $object      The object of the event
 *
 * @return bool if false, the handler is requesting to cancel the event
 */
function backup_event_annotation_delete($event, $object_type, $object) {
    global $CONFIG;

    $data = array(
        'annotations' => get_data_row("SELECT * FROM {$CONFIG->dbprefix}annotations WHERE id='$object->id'")
    );

    return backup_insert('annotation', $data);    
}