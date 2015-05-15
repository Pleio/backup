<?php
/**
 * Elgg backup and restore plugin
 *
 * @package Backup
 */

// set default value
if (!isset($vars['entity']->retention)) {
    $vars['entity']->retention = BACKUP_DEFAULT_RETENTION;
}

echo '<div>';
echo elgg_echo('backup:retention') . '&nbsp;';

echo elgg_view('input/dropdown', array(
    'name' => 'params[retention]',
    'options_values' => array(
        7 => '1 ' . elgg_echo('backup:retention:week'),
        14 => '2 ' . elgg_echo('backup:retention:weeks'),
        30 => '1 ' . elgg_echo('backup:retention:month'),
        60 => '2 ' . elgg_echo('backup:retention:months'),
        120 => '4 ' . elgg_echo('backup:retention:months'),
        180 => '6 ' . elgg_echo('backup:retention:months'),
        365 => '1 ' . elgg_echo('backup:retention:year'),
        772 => '2 ' . elgg_echo('backup:retention:years')

    ),
    'value' => $vars['entity']->retention,
));

echo '</div>';