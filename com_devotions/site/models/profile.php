<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model');


class DevotionsModelProfile extends JModel
{

 
    function getDevotions(&$pid)
    {
        $db =& JFactory::getDBO();
        $query = $this->_buildQuery($pid);
        
        $db->setQuery($query);
        
        $data = $db->loadObjectList();

        return $data;
    }
    
    
    function _buildQuery($pid) {
        if($pid) {
            $query = "SELECT * FROM #__devotions WHERE pastor='$pid' ORDER BY ts DESC";
        } else {
            $query = "SELECT * FROM #__devotions ORDER BY ts DESC";
        }
        
        return $query;        
    }
    
    
    
    function getDetails($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__users WHERE id=$id ";
        $db->setQuery($query); 

        $data = $db->loadObject();

        return $data;
    }
    
    
    function getPastor($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__pastors WHERE id=$id ";  
        $db->setQuery($query); 

        $data = $db->loadObject();

        return $data;
    }
    
    
    function countParners($pid)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT COUNT(*) FROM #__partners WHERE (firstpartner=$pid OR secondpartner=$pid) AND active=1 ";
        $db->setQuery($query); 
        
        $result = $db->loadResult();
        
        if($result) {
           return $result;
        }
        else {
            return 0;
        }
    }
    
    function getParners($pid)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__partners WHERE (firstpartner=$pid OR secondpartner=$pid) AND active=1";  
        $db->setQuery($query); 

        $data = $db->loadObjectList();

        return $data;
    }
    
    function isMyParner($me, $secondpartner)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT id FROM #__partners WHERE (firstpartner = $me AND secondpartner = $secondpartner) OR (firstpartner = $secondpartner AND secondpartner = $me )";  
        $db->setQuery($query); 

        $data = $db->loadResult();

        return $data;
    }
    
    
    function sendRequest($firstpartner, $secondpartner, $active)
    {
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        $mainframe =& JFactory::getApplication();
        
        $wearepartners = $this->isMyParner($firstpartner, $secondpartner);
        
        if($wearepartners) {
            $mainframe->redirect($refer, 'You are already devotion partners or there is a pending request.', 'error');
            exit();
        }
        
        $db =& JFactory::getDBO();
        
        $query = "INSERT INTO #__partners (`firstpartner`, `secondpartner`, `active`) VALUES ($firstpartner, $secondpartner, $active)";  
        $db->setQuery($query); 

        $data = $db->query();

        return $data;
    }
}
