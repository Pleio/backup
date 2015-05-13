<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

$contents = "";

$contents .= "<div id=\"elgg-plugin-list\">";
$contents .= "<ul class=\"elgg-list elgg-list-entity\">";
foreach (backup_get_transactions() as $transaction) {
    $contents .= "<li class=\"elgg-item\">";
    $contents .= "<div class=\"elgg-plugin\">";
    $contents .= elgg_view("backup/default", array('entity' => $transaction));
    $contents .= "</div>";
    $contents .= "</li>";
}
$contents .= "</ul>";
$contents .= "</div>";

echo $contents;
