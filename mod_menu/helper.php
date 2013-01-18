<?php
defined('_JEXEC') or die('Direct Access to this location is not allowed.');
 
class ModMenuHelper
{
    /**
     * Returns a list of post items
    */
    public function getMenuItems($parameters)
    {
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        
        $pid = getPastorId($user->id);
        $num_requests = getRequests($pid);
        $items = '';
        
        if(!$user->guest) {
            if($parameters->get('showDivineCall') && $num_requests) {
                $items .= '<a class="pathway" href="' . JRoute::_('index.php?option=com_devotions&view=divinecall') . '" style="background-image: none">Divine Call <span style="color: red; background-color: #fff; padding: 1px 9px 2px 9px; border-radius: 9px; -moz-border-radius: 9px; -webkit-border-radius: 9px;">'. $num_requests . '</span> </a>';
            }
            elseif($parameters->get('showDivineCall')) {
                $items .= '<a class="pathway" href="' . JRoute::_('index.php?option=com_devotions&view=divinecall') . '" style="background-image: none">Divine Call</a>';
            }   
        }
        
        return $items;
    }
    
    function getPastorId($userid) 
    {
        $db =& JFactory::getDBO();
        
        $query = "SELECT id FROM #__pastors WHERE userid=$userid ";
        $db->setQuery($query); 

        return $db->loadResult();
    }
}


function getRequests($pid)
{ 
    $db =& JFactory::getDBO();
    
    $query = "SELECT COUNT(*) FROM #__partners WHERE secondpartner=$pid AND active=0 "; 
    $db->setQuery($query);
    $result = $db->loadResult();
    
    if($result) {
        return $result;
    }
    else {
        return 0;
    }
}
    
function getPastorId($userid) 
{
    $db =& JFactory::getDBO();
        
    $query = "SELECT id FROM #__pastors WHERE userid=$userid ";
    $db->setQuery($query); 

    return $db->loadResult();
}