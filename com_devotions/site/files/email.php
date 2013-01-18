<?php
/*
$output .= "<h2>Dear friend, hear the voice of the Lord today.</h2>";
			$mailtext .= "QuantumFP Client Account";
			$output .= "-----------------------------------------";	
            $mailtext .= "\n---------------------------------------------------";		
			$output .= "<p><strong>Name:</strong> \t ".$user['fullname']."</p>";
			$mailtext .= "\n Name: \t ".$user['fullname'];
			$mailtext .= "\n Username: \t ".$user['username'];
			$output .= "<p><strong>Username:</strong> \t ".$user['username']."</p>";
			$mailtext .= "\n Password: \t ".$this->myarr['password'];
			$output .= "<p><strong>Password:</strong> \t ".$this->myarr['password']."</p>";
			$output .= "<br /> -----------------------------------------";
			$mailtext .= "\n---------------------------------------------------";
			$mailtext .= "\n\nPlease login to www.quantumfp.co.za/home/ to edit your details.";
			
			$this->send_mail('no-reply@quantumfp.co.za', $user['email'], 'New Quantum FP client account', $mailtext);
			$output .= "<p><a href=\"#back\" onclick=\"history.go(-1); return false;\">Go Back</a></p>";		
			
			return $output;
            
    private function send_mail($from,$to,$subject,$body) {
	    $headers = '';
	    $headers .= "From: $from\n";
	    $headers .= "Reply-to: $from\n";
	    $headers .= "Return-Path: $from\n";
	    $headers .= "Message-ID: <" . md5(uniqid(time())) . "@" . $_SERVER['SERVER_NAME'] . ">\n";
	    $headers .= "MIME-Version: 1.0\n";
	    $headers .= "Date: " . date('r', time()) . "\n";

	    mail('qawemlilo@gmail.com',$subject,$body,$headers);
    }
*/

echo true;