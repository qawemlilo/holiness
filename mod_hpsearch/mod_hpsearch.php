<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');

require_once(dirname(__FILE__).DS.'helper.php');

$pastorsArr = ModHPsearchHelper::getPastorsArray();
$pastorsObj = ModHPsearchHelper::getPastorsObj();

$limit = $params->get('limit');

require(JModuleHelper::getLayoutPath('mod_hpsearch'));