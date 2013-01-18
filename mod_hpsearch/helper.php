<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModHPsearchHelper
{
    /**
     * Returns a list of post items
    */
    private $results = null;
    private $resultsObj = null;

    
    public function getPastorsArray()
    {
        if (!$this->results) {
		    $db =& JFactory::getDBO();       
        
            $query = "SELECT name FROM #__pastors ORDER BY name";   
     
        
            $db->setQuery($query); 
        
            $this->results = $db->loadResultArray();
        }

		return $this->results;
    }
    
    public function getPastorsObj()
    {
        if (!$this->resultsObj) {
		    $db =& JFactory::getDBO();       
        
            $query = "SELECT id, name FROM #__pastors";   
     
        
            $db->setQuery($query); 
        
            $this->resultsObj = $db->loadAssocList('name');
        }
        
        return $this->resultsObj;
    }
}