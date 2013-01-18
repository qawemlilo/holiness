<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class DevotionsModelComments extends JModel
{
	function getComments($id)
	{
	    $db =& JFactory::getDBO();
	    $query = "SELECT userid, url, full_name, comment_text, ts  FROM #__devotion_comments WHERE devotionid='$id'";
        $db->setQuery($query);
        
        $results = $db->loadObjectList();
        return $results;
    }
}