<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model');


class DevotionsModelTimeline extends JModel
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
  
      
    function getDevotions()
    {
        $query = $this->_buildQuery();
        $this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));

        return $this->_data;
    }
    
    
    function _buildQuery() {
        $partners = $this->getParners();
        
        if(is_array($partners) && count($partners) > 0) {
          $partners = implode(',', $partners);
        }
        else {
            return false;
        }
        
        $query = "SELECT * FROM (SELECT * FROM #__devotions ORDER BY `ts` DESC) t WHERE pastor IN ( $partners ) GROUP BY pastor ORDER BY `ts` DESC";
        
        return $query;        
    }
    

    
    
    private function getTotal()
    {
        // Load the content if it doesn't already exist
        if (empty($this->_total)) {
            $query = $this->_buildQuery();
 	        $this->_total = @$this->_getListCount($query);	
 	    }
        return $this->_total;
    }
    
 
    function getPagination()
    {
 	    $total = $this->getTotal();
 	    
        // Load the content if it doesn't already exist
 	    if (empty($this->_pagination)) {
 	        jimport('joomla.html.pagination');
 	        $this->_pagination = new JPagination($total, $this->getState('limitstart'), $this->getState('limit') );
        }
 	
        return $this->_pagination;
    }
    
    
    function getPastor($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__pastors WHERE id='$id'";  
        $db->setQuery($query); 

        return $db->loadObject();
    }
    
    
    private function getParners()
    {
        $db =& JFactory::getDBO();
        $pid = $this->getPastorId();
        $result = array();
        
        $query = "SELECT firstpartner, secondpartner FROM #__partners WHERE (firstpartner=$pid OR secondpartner=$pid) AND active=1";  
        $db->setQuery($query); 

        $data = $db->loadObjectList();
        
        if ($data) {
            foreach($data as $row) {
                if ($row->firstpartner == $pid) {
                    $result[] = $row->secondpartner;
                }
                elseif ($row->secondpartner == $pid) {
                    $result[] = $row->firstpartner;
                }
            }
        }
        else {
            return false;
        }

        return $result;
    }
    
    private function getPastorId() {
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id FROM #__pastors WHERE userid=$user->id ";
        $db->setQuery($query); 

        return $db->loadResult();
    }
}
