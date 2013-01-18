<?php
defined('_JEXEC') or die( 'Restricted access' );

class TablePartners extends JTable {
    var $id = null;
    var $firstpartner = null;
    var $secondpartner = null;
    var $active = 0;
    var $ts = null;
    
	function __construct(&$db)
	{
		parent::__construct( '#__partners', 'id', $db );
    }
}