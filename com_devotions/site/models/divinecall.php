<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.model');


class DevotionsModelDivinecall extends JModel
{
    function getRequests()
    {
        $db =& JFactory::getDBO();
        
        $pid = $this->getPastorId();
        $query = "SELECT id, firstpartner FROM #__partners WHERE secondpartner=$pid AND active=0 "; 
        $db->setQuery($query); 

        $result = $db->loadObjectList();
        
        return $result;
    }
    
    
    function getPastor($id)
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT * FROM #__pastors WHERE id='$id'";  
        $db->setQuery($query); 

        return $db->loadObject();
    }
    
    
    private function getPastorId() {
        $db =& JFactory::getDBO();
        $user =& JFactory::getUser();
        
        $query = "SELECT id FROM #__pastors WHERE userid=$user->id ";
        $db->setQuery($query); 

        return $db->loadResult();
    }

    function handleRequest($res, $id)
    {
        $db =& JFactory::getDBO();
        $query = "";
        $msg = "";
        
        if ($res == 'agree') {
            $query = "UPDATE #__partners SET active=1 WHERE id=$id ";
            $msg = "New devotion partner added!";
        }
        elseif ($res == 'ignore') {
            $query = "DELETE FROM #__partners WHERE id=$id "; 
            $msg = "Request successfully removed";
        }
        else {
            return false;
        }
 
        $db->setQuery($query); 

        $result = $db->query();
        
        if ($result) {
            return $msg;
        }
        else {
            return false;
        }
    }    
}
