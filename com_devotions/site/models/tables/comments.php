<?php
defined('_JEXEC') or die( 'Restricted access' );

class TableComments extends JTable {
    var $id = null;
    var $devotionid = null;
    var $userid = null;
    var $full_name = null;  
    var $url = null;
    var $ts = null;
    var $comment_text = null;
    
	function __construct(&$db)
	{
		parent::__construct('#__devotion_comments', 'id', $db);
    }
}
