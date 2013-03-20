<?php
/**
 * Adds modActions and modMenus into package
 *
 * @package events
 * @subpackage build
 */
$action = $modx->newObject('modAction');
$action->fromArray(array(
    'id'            => 1,
    'namespace'     => 'events',
    'parent'        => 0,
    'controller'    => 'index',
    'haslayout'     => true,
    'lang_topics'   => 'events:default',
    'assets'        => '',
        ), '', true, true);

$menu = $modx->newObject('modMenu');
$menu->fromArray(array(
    'text'          => 'events',
    'parent'        => 'components',
    'description'   => 'events.desc',
    'icon'          => 'images/icons/plugin.gif',
    'menuindex'     => 0,
    'params'        => '',
    'handler'       => '',
        ), '', true, true);
$menu->addOne($action);
unset($menus);

return $menu;
