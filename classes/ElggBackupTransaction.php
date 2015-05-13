<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

class ElggBackupTransaction {

    function __construct($objects) {
        $this->objects = array();

        foreach ($objects as $object) {
            $this->objects[] = $object;
        }

        // inherit some properties from underlying objects
        $this->transaction_id = $this->objects[0]->transaction_id;
        $this->performed_by = $this->objects[0]->performed_by;
        $this->time_created = $this->objects[0]->time_created;
    }

    /**
     * Get the underlying ElggBackup objects.
     *
     * @return array
     */
    public function getObjects() {
        return $this->objects;
    }

    /**
     * Get the user who performed the delete action.
     *
     * @return ElggUser
     */
    public function getPerformer() {
        return get_entity($this->performed_by);
    }

    /**
     * Get an array of titles for the underlying ElggBackup objects.
     *
     * @return array
     */
    public function getObjectTitles() {
        $return = array();
        foreach ($this->getObjects() as $object) {
            $return[] = $object->getTitle();
        }
        return $return;
    }

    /**
     * Implement this function for ElggView.
     *
     * @return string an empty string
     */
    public function getURL() {
        return "";
    }    
}