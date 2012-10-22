<?php
defined('_JEXEC') or die( 'Restricted access' );

class TableDevotions extends JTable {
    var $dt = '';
    var $pastor = 0;
    var $theme = '';
    var $scripture = '';
    var $reading = '';
    var $bible = '';
    var $devotion = '';
    var $prayer= '';
    
	function __construct(&$db)
	{
		parent::__construct( '#__devotions', 'id', $db );
    }
}