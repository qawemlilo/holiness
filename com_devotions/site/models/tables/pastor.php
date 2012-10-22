<?php
defined('_JEXEC') or die( 'Restricted access' );

class TablePastors extends JTable {
    var $userid = 0;
    var $name = '';
    var $church = '';
    var $email = '';
    var $image = '';
    var $url = '';
    
	function __construct(&$db)
	{
		parent::__construct( '#__pastors', 'id', $db );
    }
}