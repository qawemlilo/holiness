<?php
defined('_JEXEC') or die( 'Restricted access' );

jimport('joomla.application.component.controller');
$document = &JFactory::getDocument();
$document->addScript('modules/mod_hpsearch/files/js/jquery-1.7.1.min.js');

require_once(JPATH_COMPONENT .DS.'models'.DS.'tables'.DS.'devotion.php');
require_once(JPATH_COMPONENT .DS.'models'.DS.'tables'.DS.'pastor.php');
require_once(JPATH_COMPONENT . DS .'files' . DS . 'resize-class.php');


class DevotionsController extends JController {
    
    function display() {
        parent::display();
    }
    
    private function sendMail($from, $to, $subject, $body, $cc = null) {
        $mainframe =& JFactory::getApplication();
        $mail =& JFactory::getMailer();
        
        $mail->setSender($from);
        $mail->addRecipient( $to );
        $mail->setSubject( $subject );
        $mail->setBody( $body );
        
        if ($cc) {
            $mail->addBCC( $cc );
        } 
        
        if ($mail->Send()) {
            return true;
        } else {
            return false;
        } 
    }
    
    function comment() {
        JRequest::checkToken() or jexit( 'Invalid Token' );
        
        JTable::addIncludePath(JPATH_COMPONENT . DS . 'models' . DS . 'tables');
        
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        
        $row =& JTable::getInstance('comments', 'Table');
        $ts = date('Y-m-d H:i:s');
        $full_name = JRequest::getVar('name', '', 'post', 'string');
        $comment_text = JRequest::getVar('comment', '', 'post', 'string');
        $devotionid = JRequest::getVar('devotionid', 0, 'post', 'int');
        $userid = JRequest::getVar('userid', 0, 'post', 'int');
        
        if($full_name && $comment_text && $devotionid) {

            $row->ts = $ts;
            $row->full_name = $full_name;
            $row->comment_text = $comment_text;
            $row->devotionid = $devotionid;
            $row->userid = $userid;

            
            if (!$row->store()) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            $mainframe->redirect($refer, "Comment saved!");
        }
        else {
            $mainframe->redirect($refer, "Error occured! Please name sure that you have filled in all required fields.", "error");
        }
    }
    
    function comment_delete() {
        $user =& JFactory::getUser();
        $db =& JFactory::getDBO();
        $mainframe =& JFactory::getApplication();
        $refer = JRoute::_($_SERVER['HTTP_REFERER']);
        
        $commentID = JRequest::getVar('comId');
        
		if (!$user->get('guest')) {
            $query = "DELETE FROM #__devotion_comments WHERE id='$commentID'";
            $db->setQuery($query);
            
            $result = $db->query();
            
            if($result) {
                $mainframe->redirect($refer, "Comment deleted");
            }
            else {
                $mainframe->redirect($refer, "Deleting comments failed", "error");
            }
        }
        else {
            $mainframe->redirect('index.php');
        }        
    }
    

    function download() {
        header("Content-type: application/vnd.ms-word");
        header("Content-Disposition: attachment;Filename=devotion.doc");

        $dId = JRequest::getVar('dId', '', 'get', 'int');
        $model =& $this->getModel('devotion');
        $devotion = $model->getDevotion($dId);
        $pastor = $model->getPastor($devotion->pastor);
        $output = "";
        
        if($devotion) {
            $date = $devotion->dt;
            $day = explode(',', $date);
            
            $output .= "Dear friend, hear the voice of the Lord today: $devotion->scripture \n \n \n";
            $output .= "Pastor's name: \n$pastor->name \n \n";
            $output .= "Senior Pastor @ (Church/Ministry): \n$pastor->church \n \n";
            $output .= "Day: \n$day[0] \n \n";
            $output .= "Date: \n$day[1] $day[2] \n \n";
            $output .= "Today's theme: \n$devotion->theme \n \n";
            $output .= "Today's scripture: \n$devotion->scripture \n \n";
            $output .= "The scripture reads as follows: \n$devotion->reading \n \n";
            $output .= "Bible translation used: \n$devotion->bible \n \n";
            $output .= "Today's devotion: \n$devotion->devotion \n \n";
            $output .= "Today's confession / prayer: \n$devotion->prayer \n \n \n \n";
            
            $output .= "HOLINESS PAGE: http://www.holinesspage.com \n";
        }
        echo $output;
        exit();
    }

    
    function emaildevotion() {
        header("Content-type: application/json");
        
        $body = "";
        $from_name = JRequest::getVar('from_name', '', 'post', 'string');
        $from_email = JRequest::getVar('from_email', '', 'post', 'string');
        $to_name = JRequest::getVar('to_name', '', 'post', 'string');
        $to_email = JRequest::getVar('to_email', '', 'post', 'string');
        $msg = JRequest::getVar('msg', '', 'post', 'string');
        $theme = JRequest::getVar('theme', '', 'post', 'string');
        $url = JRequest::getVar('url', '', 'post', 'string');
        
        if(empty($from_name) || empty($from_email) || empty($to_name) || empty($to_email) || empty($msg)) {
             echo false;
        }
        else {
            $from = array($from_email, $from_name);
            $subject = "Dear {$to_name}, hear the voice of the Lord today.";
            
            $body .= "This devotion was shared with you by: $from_name from the HOLINESS PAGE website." . "\n \n";
            $body .= $theme . "\n \n";
            $body .= $msg . "\n \n";
            $body .= "Please visit this page to read your message: $url";
            
            $mailsent = $this->sendMail($from, $to_email, $subject, $body);
           
            if ($mailsent) {
                echo true;
            } else {
               echo false;
            }
        }
        exit();
    }
    
    
    function testimonial() {
        $mainframe =& JFactory::getApplication();
        
        $body = "";
        $name = JRequest::getVar('name', '', 'post', 'string');
        $email = JRequest::getVar('email', '', 'post', 'string');
        $country = JRequest::getVar('country', '', 'post', 'string');
        $city = JRequest::getVar('city', '', 'post', 'string');
        $church = JRequest::getVar('church', '', 'post', 'string');
        $pastor = JRequest::getVar('pastor', '', 'post', 'string');
        $msg = JRequest::getVar('msg', '', 'post', 'string');       
        
        if(empty($name) || empty($email) || empty($country) || empty($city) || empty($church) || empty($msg) || empty($pastor)) {
            $mainframe->redirect("index.php?option=com_devotions&view=testimonials&Itemid=4", "Error! Please fill in all the fields", "error");
        }
        else {
            $from = array($email, $name);
            $subject = "Automated email: New Testimonial from website";
            
            $body .= "New Testimonial:" . "\n";
            $body .= "-----------------------------------" . "\n \n";
            $body .= "Name: " . $name . "\n";
            $body .= "Country: " . $country . "\n";
            $body .= "City: " . $city . "\n";
            $body .= "Church: " . $church . "\n";
            $body .= "Pastor: " . $pastor . "\n \n";
            $body .= $msg;
        
            $mailsent = $this->sendMail($from, "info@holinesspage.com", $subject, $body);
            
            if ($mailsent) {
                $mainframe->redirect("index.php?option=com_devotions&view=testimonials&Itemid=4", "Thank you for sharing your testimonial. Message sent!");
            }
            else {
                $mainframe->redirect("index.php?option=com_devotions&view=testimonials&Itemid=4", "An error occured when sending your message, please try again.", "error");
            }
        }
    }
    
    
    function _updateImg($id, $img) {
        $db =& JFactory::getDBO();
        
        $query = "UPDATE #__pastors SET url='$img' WHERE id='$id'";
        $db->setQuery($query);
        
        $result = $db->query();
        
        return $result;        
    }
    
    
    function search() {
        $mainframe =& JFactory::getApplication();
        $url = 'index.php?option=com_devotions&view=devotions&Itemid=6&sword=';
        $db =& JFactory::getDBO();
        $searchword = JRequest::getVar('searchword', '', 'post', 'string');

        $query = "SELECT id FROM #__pastors WHERE name='$searchword'";
        $db->setQuery($query);
        $pid = $db->loadResult();        
        
        $url .= $searchword;
        $url .= '&pid=' . $pid;
        
        $mainframe->redirect($url);
    }
    
    
    function register() {
        $user =& JFactory::getUser();
        
		if (!$user->get('guest')) {
			JRequest::setVar('view', 'admin');
            JRequest::setVar('layout', 'register');
            parent::display();
		}
        else {
            header("Location: index.php");
        }        
    }
    
    function upload_file($file, $id) { 
        $filename = JFile::makeSafe($file['name']);
        $ext = JFile::getExt($filename);
        $src = $file['tmp_name'];
        
        $dest = JPATH_SITE . DS . 'components' . DS . 'com_devotions' . DS . 'files' . DS . 'users' . DS . 'user_' . $id . '.' . strtolower($ext);
        $f = JPATH_COMPONENT . DS . 'files' .  DS . 'users' .  DS . 'user_' . $id . '.' . strtolower($ext);
        
        if (JFile::exists($f)) {
            JFile::delete($f);
        }
       
        $result = JFile::upload($src, $dest);
        
        if($result) {
            return $dest;
        }
        else {
            return false;
        }
    }
    
    function save_profile() {
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );
        
        $user =& JFactory::getUser();
        $mainframe =& JFactory::getApplication();
        
		if (!$user->get('guest')) {
	        $row =& JTable::getInstance('pastors', 'Table');

            if (!$row->bind(JRequest::get('post'))) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            $file = JRequest::getVar('photo', null, 'files', 'array');
            $filename = JFile::makeSafe($file['name']);
            $ext = JFile::getExt($filename);
            $ext = strtolower($ext);
            
            $row->userid = JRequest::getVar('userid', 0, 'post', 'int');
            $row->name = JRequest::getVar('name', '', 'post', 'string');
            $row->church = JRequest::getVar('church', '', 'post', 'string');
            $row->email = JRequest::getVar('email', '', 'post', 'string');
            $row->url = "user_{$user->id}.{$ext}";
            
            if (empty($row->userid) || empty($row->name) || empty($row->church) || empty($row->email)) {
                echo "<script> 
                        alert('Please fill in all the fields!'); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            
            if (!$row->store()) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            if(isset($file['name']) && !empty($file['name'])){
                $loaded = $this->upload_file($file, $user->id);
                
                if ($loaded) {
                    // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                    $resizeObj = new resize($loaded);
                    $resizeObj->resizeImage(150, 150, 'crop');
                    $resizeObj->saveImage($loaded);
                    $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Profile created and saved!');
                }
            }

            $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Profile Created!');
        }
        
        parent::display();
    }
    
    
    function edit_profile() {
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );
        
        $user =& JFactory::getUser();
        
        $mainframe =& JFactory::getApplication();
        
        if (!$user->get('guest')) {
	    $row =& JTable::getInstance('pastors', 'Table');
            $pastorid = JRequest::getVar('pastorid', 0, 'post', 'int');
            
            $row->load($pastorid);

            if (!$row->bind(JRequest::get('post'))) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            $file = JRequest::getVar('profilephoto', null, 'files', 'array');
            $filename = JFile::makeSafe($file['name']);
            $ext = JFile::getExt($filename);
            $ext = strtolower($ext);
            $row->userid = JRequest::getVar('userid', 0, 'post', 'int');
            $row->name = JRequest::getVar('name', '', 'post', 'string');
            $row->church = JRequest::getVar('church', '', 'post', 'string');
            $row->email = JRequest::getVar('email', '', 'post', 'string');
            
            if (!isset($file['errors']) && $file['size'] > 100) {
              $row->url = "user_{$user->id}.{$ext}";
            }
            
            if (empty($row->userid) || empty($row->name) || empty($row->church) || empty($row->email)) {
                echo "<script> 
                        alert('Please fill in all the fields!'); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            if (!$row->store()) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            if (!isset($file['errors']) && $file['size'] > 100) {
                $loaded = $this->upload_file($file, $user->id);
                
                if ($loaded) {
                    // *** 2) Resize image (options: exact, portrait, landscape, auto, crop)
                    $resizeObj = new resize($loaded);
                    $resizeObj->resizeImage(150, 150, 'crop');
                    $resizeObj->saveImage($loaded);
                    $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Profile created and photo save!');
                }
            }

            $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Profile Updated!');
        }
        
        parent::display();
    }
    

    function save_devotion() {
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );
        
        $user =& JFactory::getUser();
        
        $mainframe =& JFactory::getApplication();
        
		if (!$user->get('guest')) {
	        $row =& JTable::getInstance('devotions', 'Table');

            if (!$row->bind(JRequest::get('post'))) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            $scripture = JRequest::getVar('book', '', 'post', 'string');
            $scripture .= ' ' . JRequest::getVar('chapter', 0, 'post', 'int');
            $scripture .= ':' . JRequest::getVar('verse', 0, 'post', 'int');
            
            $row->dt = JRequest::getVar('dt', '', 'post', 'string');
            $row->pastor = JRequest::getVar('pastor_id', 0, 'post', 'int');
            $row->theme = JRequest::getVar('theme', '', 'post', 'string');
            $row->scripture = $scripture;
            $row->reading = JRequest::getVar('reading', '', 'post', 'string', JREQUEST_ALLOWRAW);
            $row->bible = JRequest::getVar('bible', '', 'post', 'string');
            $row->devotion = JRequest::getVar('devotion', '', 'post', 'string', JREQUEST_ALLOWRAW);
            $row->prayer = JRequest::getVar('prayer', '', 'post', 'string', JREQUEST_ALLOWRAW);           


            if (empty($row->dt) || empty($row->pastor) || empty($row->theme) || empty($row->scripture) || empty($row->reading) || empty($row->bible) || empty($row->devotion) || empty($row->prayer)) {
                echo "<script> 
                        alert('Plase fill in all the fields!'); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            if (!$row->store()) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }

            $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Devotion Saved!');
		}
        
        parent::display();
    }
    
    
    function cancel() {
		global $mainframe; 
        $mainframe->redirect('index.php?option=com_devotions&view=admin');        
    }    
    
    
    function edit() {
		$user =& JFactory::getUser();
		$mainframe =& JFactory::getApplication();

		if (!$user->get('guest')) {
			JRequest::setVar('view', 'admin');     
            JRequest::setVar('layout', 'edit');
            
            parent::display();
		}
        else {
            $mainframe->redirect("index.php");
        }   
    }
    
    function comments_admin() {
		$user =& JFactory::getUser();
		$mainframe =& JFactory::getApplication();

		if (!$user->get('guest')) {
            $did = JRequest::getVar('dId');
			JRequest::setVar('view', 'admin');     
            JRequest::setVar('layout', 'comments');
            JRequest::setVar('dId', $did);
            
            parent::display();
		}
        else {
            $mainframe->redirect("index.php");
        }   
    }
    
    
    function save_edit() {
		// Check for request forgeries
		JRequest::checkToken('request') or jexit( 'Invalid Token' );
        
        $user =& JFactory::getUser();
        $mainframe =& JFactory::getApplication();
        
        if (!$user->get('guest')) {
	    $row =& JTable::getInstance('devotions', 'Table');
	    $d_id = JRequest::getVar('devotion_id', 0, 'post', 'int');
	    $row->load($d_id);

            if (!$row->bind(JRequest::get('post'))) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            $scripture = JRequest::getVar('book', '', 'post', 'string');
            $scripture .= ' ' . JRequest::getVar('chapter', 0, 'post', 'int');
            $scripture .= ':' . JRequest::getVar('verse', 0, 'post', 'int');
            
            $row->dt = JRequest::getVar('dt', '', 'post', 'string');
            $row->pastor = JRequest::getVar('pastor_id', 0, 'post', 'int');
            $row->theme = JRequest::getVar('theme', '', 'post', 'string');
            $row->scripture = $scripture;
            $row->reading = JRequest::getVar('reading', '', 'post', 'string', JREQUEST_ALLOWRAW );
            $row->bible = JRequest::getVar('bible', '', 'post', 'string');
            $row->devotion = JRequest::getVar('devotion', '', 'post', 'string', JREQUEST_ALLOWRAW );
            $row->prayer = JRequest::getVar('prayer', '', 'post', 'string', JREQUEST_ALLOWRAW ); 

            
            if (empty($row->dt) || empty($row->pastor) || empty($row->theme) || empty($row->scripture) || empty($row->reading) || empty($row->bible) || empty($row->devotion) || empty($row->prayer)) {
                echo "<script> 
                        alert('Plase fill in all the fields!'); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
            if (!$row->store()) {
                echo "<script> 
                        alert('".$row->getError()."'); 
                        return JError::raiseWarning(500, $row->getError()); 
                        window.history.go(-1); 
                      </script>\n";
                exit();
            }
            
             $mainframe->redirect('index.php?option=com_devotions&view=admin', 'Devotion update saved!');
        }
        
        parent::display();
    }
    
    function blessMe() {
        $model =& $this->getModel('devotion');
        
        $did = JRequest::getInt('did', 0);
        $pid = JRequest::getInt('pid', 0);
        
        if(!empty($did) && !empty($pid)) {
            $success = $model->giveBlessings($did, $pid);
            
            if($success) {
                echo 'success';
            }
            else {
                echo 'failed';
            }
        }
        else {
            echo 'failed';
        }
        
        exit();
    }
}
