<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

/**
 * Insert data into the backup table
 * 
 * @param string $type        Type of the object the data is related to
 * @param array  $data        An array of elgg_get_row() stdclasses.
 *
 * @return bool true of the insert succeeded
 */
function backup_insert($type, $data) {
    global $CONFIG;

    $transaction_id = backup_get_guid();
    $site = $CONFIG->site_id;
    $time = time();
    $performed_by = elgg_get_logged_in_user_guid();
    $data = mysql_real_escape_string(serialize($data));

    $query = "INSERT into {$CONFIG->dbprefix}backup (transaction_id,site_guid,time_created,performed_by,type,data) " . 
             "VALUES ('$transaction_id', $site, $time, $performed_by, '$type', '$data')";

    return insert_data($query);
}

/**
 * Generate a unique GUID
 * 
 * @return string unique GUID
 */
function backup_generate_guid() {
    if (function_exists('com_create_guid')){
        return trim(com_create_guid(), '{}');
    } else {
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = substr($charid, 0, 8).$hyphen
            .substr($charid, 8, 4).$hyphen
            .substr($charid,12, 4).$hyphen
            .substr($charid,16, 4).$hyphen
            .substr($charid,20,12);
        return $uuid;
    }
}

/**
 * Retrieve the GUID of the current session
 * 
 * @return string GUID of the current session
 */
function backup_get_guid() {
    global $BACKUP_TRANSACTION_ID;

    if (!isset($BACKUP_TRANSACTION_ID)) {
        $BACKUP_TRANSACTION_ID = backup_generate_guid();
    }

    return $BACKUP_TRANSACTION_ID;
}

/**
 * Get an array of all recent transactions.
 * 
 * @param int    $limit     limit the number of results
 * @param int    $offset    offset the results
 *
 * @return array an array of ElggBackupTransaction objects
 */
function backup_get_transactions($limit = 50, $offset = 0) {
    global $CONFIG;
    $site = $CONFIG->site_guid;
    
    $query = "SELECT * FROM {$CONFIG->dbprefix}backup WHERE site_guid=$site GROUP BY transaction_id ORDER BY time_created DESC";
    $query .= " LIMIT " . (int) $offset . ", " . (int) $limit;
    
    $transactions = get_data($query);

    $return = array();
    foreach ($transactions as $transaction) {
        // fetch an array of all underlying deleted objects
        $return[] = new ElggBackupTransaction(backup_get_objects($transaction->transaction_id));
    }
    return $return;
}

/**
 * Get an array ElggBackup objects related to a transaction.
 * 
 * @param string   $transaction   the transaction id.
 *
 * @return array of ElggBackup objects
 */
function backup_get_objects($transaction) {
    global $CONFIG;
    $site = $CONFIG->site_guid;

    $query = "SELECT * FROM {$CONFIG->dbprefix}backup WHERE site_guid=$site";    
    $query .= " AND transaction_id='" . $transaction . "' ORDER BY id";
    
    $objects = get_data($query);

    $return = array();
    foreach ($objects as $object) {
        $return[] = new ElggBackup($object);
    }

    return $return;
}

/**
 * Restore the backup of a transaction.
 * 
 * @param string   $transaction   the transaction id.
 *
 * @return bool if backup was restored successfully
 */
function backup_restore_transaction($transaction) {
    
    $objects = backup_get_objects($transaction);

    foreach ($objects as $object) {
        $data = unserialize($object->data);

        $queries = array();
        foreach (array_keys($data) as $table) {
            // convert single element to an array containing the single element
            if (!is_array($data[$table])) {
                $data[$table] = array($data[$table]);
            }

            foreach ($data[$table] as $row) {
                if (in_array($table, array('metastrings', 'entity_relationships')) {
                    // insert with ignore if row already exists
                    $ignore = true;
                } else {
                    $ignore = false;
                }
                
                $queries[] = backup_parsesql($table, $row, $ignore);
            }
        }

        foreach ($queries as $query) {
            insert_data($query);
        }
    }

    backup_delete_transaction($transaction);
    return true;
}

/**
 * Delete a backup for a transaction
 * 
 * @param string   $transaction   the transaction id.
 *
 * @return bool if backup was removed successfully
 */
function backup_delete_transaction($transaction) {
    global $CONFIG;
    $site = $CONFIG->site_guid;
    $query = "DELETE FROM {$CONFIG->dbprefix}backup WHERE site_guid=$site";    
    $query .= " AND transaction_id='" . $transaction . "'";
    
    return delete_data($query);
}

/**
 * Generate an SQL INSERT query for an elgg_get_row() stdclass.
 * 
 * @param string   $table   name of the destination table
 * @param class    $entity  elgg_get_row() stdclass
 * @param bool     $ignore  append IGNORE to the insert statement
 *
 * @return string generated query
 */
function backup_parsesql($table, $entity, $ignore = false) {
    global $CONFIG;
    
    $vars = get_object_vars($entity);

    if ($ignore == true) {
        $query = "INSERT IGNORE INTO {$CONFIG->dbprefix}" . $table . " (";
    } else {
        $query = "INSERT INTO {$CONFIG->dbprefix}" . $table . " (";
    }

    $last_value = end(array_keys($vars));
    foreach ($vars as $key => $value) {
        $query .= $key;

        if ($key != $last_value) {
            $query .= ",";
        }
    }
    
    $query .= ") VALUES (";
    
    $last_value = end(array_keys($vars));
    foreach ($vars as $key => $value) {
        $query .= "\"" . mysql_real_escape_string($value) . "\"";

        if ($key != $last_value) {
            $query .= ",";
        }
    }

    $query .= ");";
    return $query;
}
