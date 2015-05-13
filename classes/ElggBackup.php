<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

class ElggBackup {
    function __construct($object) {
        foreach (get_object_vars($object) as $key => $value) {
            $this->$key = $value;
        }            
    }

    /**
     * Extract a title for the object from the serialized data.
     *
     * @return string
     */
    public function getTitle() {
        $data = unserialize($this->data);
        foreach ($data as $object) {
            if (isset($object->title)) {
                $title = $object->title;
            }
            if (isset($object->subtype)) {
                $subtype = $object->subtype;
            }
        }

        if ($title && $subtype) {
            return '[' . get_subtype_from_id($subtype) . ': ' . $title . ']';
        } else {
            return '[' . $this->type . ']';
        }
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