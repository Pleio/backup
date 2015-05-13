<?php
/**
 * ElggObject default view.
 *
 * @warning This view may be used for other ElggEntity objects
 *
 * @package Elgg
 * @subpackage Core
 */

$icon = elgg_view_entity_icon($vars['entity'], 'small');

$performer_link = '';
$performer = $vars['entity']->getPerformer();
if ($performer) {
    $performer_link = elgg_view('output/url', array(
        'href' => $performer->getURL(),
        'text' => $performer->name,
        'is_trusted' => true,
    ));
}

$date = elgg_view_friendly_time($vars['entity']->time_created);

$restore = elgg_view('output/confirmlink', array(
    'href' => 'action/backup/restore?transaction=' . $vars['entity']->transaction_id,
    'text' => elgg_echo('backup:restore'),
    'confirm' => elgg_echo('backup:restore:confirm'),
    'class' => 'elgg-button elgg-button-submit',
    'style' => 'float:right',
    'is_action' => true
));

$subtitle = "$performer_link $date $restore";

$params = array(
    'entity' => $vars['entity'],
    'title' => $vars['entity']->type,
    'subtitle' => $subtitle,
    'content' => implode(', ', $vars['entity']->getObjectTitles())
);

$params = $params + $vars;
echo elgg_view('object/elements/summary', $params);