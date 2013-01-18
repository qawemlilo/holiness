<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );


class DevotionsModelPastor extends JModel
{
	function getDevotions($id)
	{
		$db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__devotions WHERE pastor='$id' ORDER BY ts DESC";
        $db->setQuery($query); 
        
        $results = $db->loadObjectList();

		return $results;
    }

	function getDetails($id)
	{
		$db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__pastors WHERE id='$id'";
        $db->setQuery($query); 
        
        $results = $db->loadObject();

		return $results;
    }
    
	function hasProfile($id)
	{   
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__pastors WHERE userid='$id'";
        $db->setQuery($query); 
        
        $results = $db->loadResult();

		return $results;
    }
}