<?php

namespace App\Library\Classes;
use App\Models\Admin;
use App\Models\Comm;

class SMS {
	// Properties
	private $sms;
    /**
     * Constructor for this class
     *
     */	
    public function __construct()
    {
		$this->comm = new Comm;
	}	
	/**
	 * Method to send out an SMS 
 	 * @param string job id
     * @return object
	 */
	public function smsAdmin(Admin $admin) {

		$user 		= urlencode(env('CLICKATELL_USER'));
		$password 	= urlencode(env('CLICKATELL_PASSWORD'));
		$api_id		= urlencode(env('CLICKATELL_API_ID'));
		$baseurl 	= env('CLICKATELL_BASEURL'); 
		// The message.
		$text = 'Good day '.$admin->name.', you have been successfully registered. Your username is '.$admin->email.' and password is '.$admin->password_clear.'. Regards, Administrator';
		/* Check number of characters. */
		$number		= strlen($text)/160;							// 160 is the maximum characters allowed for one sms.
		$whole		= floor($number);							// Get the current number. 
		$fraction	= (($number - $whole) > 0 ? 1 : 0);	// Check if there are any more out there
		$unites		= $whole + $fraction;						// Add if there are extra characters left over
		// Insert record.
		$this->comm->admin_id	= $admin->id;
		$this->comm->type			= 'SMS';
		$this->comm->name			= $admin->name;
		$this->comm->cellphone	= $admin->cellphone;
		$this->comm->units			= $unites;		
		$this->comm->message	= $text;
		// Preare the text for sending out.
		$text	= urlencode($text); 
		$to	= $admin->cellphone; 		
		// Make sure the cellphone number is 10 digits long and starts with a 0.
		if( preg_match( "/^0[0-9]{9}$/", $to)) {
			// The URL
			$url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id"; 
			// do auth call 
			$ret = file($url); 

			// split our response. return string is on first line of the data returned 

			$sess = explode(":",$ret[0]); 
			
			if ($sess[0] == "OK") {
			
				$sess_id = trim($sess[1]); // remove any whitespace 
				
				$url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text"; 
				
				// do sendmsg call 
				$ret = file($url); 
				
				$send = explode(":",$ret[0]); 
				
				if ($send[0] == "ID") { 																						
					$this->comm->output	=  'Success! : '.$send[0].' : '.$send[1];
					$this->comm->sent	= 1;					
				} else  {
					$this->comm->output	= 'Send message failed : '.$send[0].' : '.$send[1];
					$this->comm->sent	= 0;	  
				}
			} else {
				$this->comm->output	= "Authentication failure: ". $ret[0]; 
				$this->comm->sent	= 0;	  
			} 
		} else {
			$this->comm->output=  "Invalid number ".$member['member_number'];	
			$this->comm->sent	= 0;		  
		}
		// Insert data.	
		$this->comm->save();
		
		return $this->comm->sent;
	}
}

?>