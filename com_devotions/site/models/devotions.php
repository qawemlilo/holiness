<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model');


class DevotionsModelDevotions extends JModel
{
    var $_total = null;
    
    var $_pagination = null;
    

    function __construct()
    {
        parent::__construct();
 
        $mainframe = JFactory::getApplication();
 
        // Get pagination request variables
        $limit = $mainframe->getUserStateFromRequest('global.list.limit', 'limit', 5, 'int');
        $limitstart = JRequest::getVar('limitstart', 0, '', 'int');
        
        // In case limit has been changed, adjust it
        $limitstart = ($limit != 0 ? (floor($limitstart / $limit) * $limit) : 0);
        $this->setState('limit', $limit);
        $this->setState('limitstart', $limitstart);
    }
  
      
    function getDevotions(&$pid)
    {
        $query = $this->_buildQuery($pid);
        $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

        return $this->_data;
    }
    
    
    function _buildQuery($pid) {
        if($pid) {
            $query = "SELECT * FROM #__devotions WHERE pastor='$pid' ORDER BY ts DESC";
        } else {
            $query = "SELECT * FROM #__devotions ORDER BY ts DESC";
        }
        
        return $query;        
    }
    

    
    
    function getTotal($pid)
    {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery($pid);
 	        $this->_total = $this->_getListCount($query);	
 	    }
        return $this->_total;
    }
    
 
    function getPagination(&$pid)
    {
 	    $total = $this->getTotal($pid);
 	    
        // Load the content if it doesn't already exist
 	    if (empty($this->_pagination)) {
 	        jimport('joomla.html.pagination');
 	        $this->_pagination = new JPagination($total, $this->getState('limitstart'), $this->getState('limit') );
        }
 	
        return $this->_pagination;
    }
    
    
    function getDetails($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__users WHERE id='$id'";
        $db->setQuery($query); 

        return $db->loadObject();
    }
    
    
    function getPastor($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__pastors WHERE id='$id'";  
        $db->setQuery($query); 

        return $db->loadObject();
    }
}
