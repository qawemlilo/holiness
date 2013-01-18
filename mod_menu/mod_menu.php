<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(dirname(__FILE__).DS.'helper.php');

$user =& JFactory::getUser();

$items = ModMenuHelper::getMenuItems($params);
$pid = ModMenuHelper::getPastorId($user->id);

require(JModuleHelper::getLayoutPath('mod_menu'));