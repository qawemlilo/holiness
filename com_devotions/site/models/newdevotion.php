<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model' );

class DevotionsModelNewdevotion extends JModel
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
  
      
    function getComments(&$pid)
    {
        $query = $this->_buildQuery($pid);
        $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

        return $this->_data;
    }
    
    
    function _buildQuery($id) {
        if($id) {
            $query = "SELECT userid, url, full_name, comment_text, ts  FROM #__devotion_comments WHERE devotionid='$id' ORDER BY ts DESC";
        } else {
            $query = "SELECT * FROM #__devotion_comments ORDER BY ts DESC";
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
    
	function getDevotion($id)
	{
	    $db =& JFactory::getDBO();
	    $query = "SELECT * FROM #__devotions WHERE id='$id'";
        $db->setQuery($query); 
        
        $results = $db->loadObject();
        return $results;
    }
    
    
	function getPastor($id)
	{
	     $db =& JFactory::getDBO();
        
            $query = "SELECT * FROM #__pastors WHERE id='$id'";
            $db->setQuery($query); 
        
            $results = $db->loadObject();

            return $results;
    }
    
    
	function getUser($id)
	{
	     $db =& JFactory::getDBO();
        
            $query = "SELECT * FROM #__pastors WHERE userid='$id'";
            $db->setQuery($query); 
        
            $results = $db->loadObject();

            return $results;
    }
    
    
	function getUrls()
	{
	     $db =& JFactory::getDBO();
        
            $query = "SELECT userid, url FROM #__pastors";
            $db->setQuery($query); 
        
            $results = $db->loadAssocList('userid');

            return $results;
    }
    
    
    function getRecentDevotions($pid)
    {
        $db =& JFactory::getDBO();
        $query = "SELECT * FROM #__devotions WHERE pastor='$pid' ORDER BY ts DESC LIMIT 10";
        $db->setQuery($query); 
        
        $results = $db->loadObjectList();

        return $results;
    }
}
