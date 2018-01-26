<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model{

	public function __construct() {
		parent::__construct();
        //$this->load->model('search_model');
	}
	// -----------------------USER REGISTERATION MODEL----------------------//
	//-------------------------------------------------------------//
	public function register_user($user_name,$email_id,$password,$profile_type){

		$checkEmail=Login_model::checkEmail_exist($email_id,$profile_type);
		if($checkEmail)
		{
			
			$data = array(
				'jm_username' => $user_name,
				'jm_password' => base64_encode($password.USER_KEY),
				'jm_profile_type' => $profile_type,
				'joining_date' => date('Y-m-d'),
				'avail_bids' => '20',
				'total_bids' => '20',
				'verification_code' => base64_encode($email_id),
				'jm_email_id' => $email_id
			);
		//sql query to insert new user
			if($this->db->insert('jm_user_tab', $data))
			{  
				$mail_verified=Login_model::sendVerificatinEmail($user_name,$email_id,$profile_type);

				if($mail_verified['status']==200){
					$response=array(
				'status' => 200,	//---------insert db success code
				'status_message' =>'Registration Successfull. Please Login With Your Registered Email-ID.'
			);
				}
				else{
					$response=array(
				'status' => 200,	//---------insert db success code but email not send
				'status_message' =>'Registration Successfull but Email-ID was not verified.'
			);
				}

			}
			else
			{
				$response=array(
				'status' => 500,	//---------db error code 
				'status_message' =>'Something went wrong... Registration Failed!!!'
			);
			}	
		}
		else {
	 	//if email-Id already regiterd then show error
			$response=array(
				'status' => 500,
				'status_message' =>'Email ID Already Registered for this profile. Login by same or use another Email-ID!!!'					
			);	
		}	
		return $response;
	}
	// -----------------------USER REGISTERATION MODEL----------------------//
	//-------------------------------------------------------------//

	//-----------------------function to check whether email-ID already exists------------------//
	function checkEmail_exist($email_id,$profile_id)
	{
		$query = null;
		$query = $this->db->get_where('jm_user_tab', array(//making selection
			'jm_email_id' => $email_id,
			'jm_profile_type' => $profile_id
		));		
		
		if ($query->num_rows() > 0) {
			return 0;			
		} else {
			return 1;			
		}
	}

//-----------------------function to check whether email-ID already exists------------------//
	
	//-------------------------------------------------------------------------//
	//----------------------email verification code----------------------------//
	public function sendVerificatinEmail($username,$email,$profile_type){

		$config = Array(
			'protocol' => 'smtp',
			'smtp_host' => 'mx1.hostinger.in',
			'smtp_port' => '587',
     		'smtp_user' => 'customercare@jobmandi.in', // change it to yours
     		'smtp_pass' => 'Descartes@1990', // change it to yours
     		'mailtype' => 'html',
     		'charset' => 'utf-8',
     		'wordwrap' => TRUE
     	);
		$config['smtp_crypto'] = 'tls';
		//return ($config);die();

		$this->load->library('email', $config);
		$this->email->set_newline("\r\n");
		$this->email->from('customercare@jobmandi.in', "Admin Team");
		$this->email->to($email,$username);  
		$this->email->subject("JOBMANDI-Email Verification");
		$this->email->message("Dear ".$username.",\nPlease click on below URL or paste into your browser to verify your Email Address\n\n <a href='".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."'>".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."</a>\n"."\n\nThanks\nAdmin Team");

		if (!$this->email->send()) {
			$response=array(
				'status' => 0,	//---------email sending failed
				'status_message' =>'Email Sending Failed.'
			);
		} else {
			$response=array(
				'status' => 200,	//---------email send succesfully
				'status_message' =>'Email Sent Succesfully.'
			);
		}
		return $response;

	}
	//----------------------email verification code ends------------------------//
	//--------------------------------------------------------------------------//

	// -----------------------USER LOGIN API----------------------//
	//-------------------------------------------------------------//
	public function login($user_name,$password,$profile_type)
	{
	//sql query to check login credentials
		$pass=base64_encode($password.USER_KEY);
		$query="SELECT * FROM jm_user_tab WHERE (jm_email_id='$user_name' || jm_username='$user_name') AND jm_password='$pass' AND jm_profile_type='$profile_type'";
		//echo $query;die();
		$result = $this->db->query($query);
		$user_id='0';
		$privilege='';
	//if credentials are true, their is obviously only one record
		if($result->num_rows() == 1){
			
			foreach ($result->result_array() as $row) {
				$user_name=$row['jm_username'];
				$user_id=$row['jm_user_id'];
			}

			if ($result) {
				$sql = "UPDATE jm_user_tab SET jm_loginTime=NOW(), jm_current_status='1' WHERE jm_user_id='$user_id'";
				//echo $sql;die();
				$result = $this->db->query($sql);

				//response with values to be stored in sessions if update session_bool true
				$response=array(
					'status' => 200,
					'user_id' =>$user_id,
					'user_name' => $user_name,				
					'profile_type' => $profile_type,
					'status_message' =>'Login Successfull'
				);
			}
			else{
				$response=array(
					'status' => 500,
					'user_id' =>$user_id,
					'user_name' => $user_name,				
					'profile_type' => $profile_type,				
					'status_message' =>'Error to start session for '.$user_name.' !!!',
				);
			}
		}
		else
		{
		//login failed response
			$response=array(
				'status' => 500,
				'status_message' =>'Sorry..Login credentials are incorrect!!!',
				'user_id' =>$user_id,
				'user_name' => $user_name,				
				'profile_type' => $profile_type		
			);
		}
		return $response;
	}
	//----------------------------LOGIN END------------------------------//


	//-----------------------function to check whether privilege level already exists------------------//
	function checkPrivilege_exist($privilege_level)
	{
		$query = null;
		$query = $this->db->get_where('roles', array(
			'privilege_level' => $privilege_level
		));		
		
		if ($query->num_rows() > 0) {
			return 0;			
		} else {
			return 1;			
		}
	}
//-----------------------------------function end---------------------------------------//

//-----------------------function to check whether privilege level already exists------------------//
	function logout_user($user_id)
	{
		$sql = "UPDATE jm_user_tab SET jm_logoutTime=NOW() WHERE jm_user_id='$user_id'";
		//echo $sql;die();
		$this->db->query($sql);
		return $this->db->affected_rows(); 
	}
//-----------------------------------function end---------------------------------------//

	//-----------------------function to check whether privilege level already exists------------------//
	function verify_email($code,$profile_type)
	{
		$sql = "UPDATE jm_user_tab SET email_verified=email_verified+1 WHERE verification_code='$code'";
		//echo $sql;die();
		$this->db->query($sql);
		return $this->db->affected_rows(); 
	}
//-----------------------------------function end---------------------------------------//

// ------------------forgot password-------------------------------//
	public function forget_password($forget_email)
	{
		$query = "SELECT * FROM jm_user_tab WHERE jm_email_id='$forget_email'";
		echo $query;die();
		$result=$this->db->query($query);  
		if ($result->num_rows() <= 0) 
		   {
		    $response = array(                                             
		      'status' => 500,
		      'status_message' => 'Email ID is not registered.');                           
		  } else {
		    $response = array(
		      'status' => 200,
		      'status_message' => $result->result_array());
		  }
		  return $response;
	 }
	//----------------------------------------------------------------

	//-----------------------function to add categories json------------------//
	function addCategory($json)
	{
		$jsonArr=json_decode($json,TRUE);
		$final=array();

			$arr=array();
			foreach ($jsonArr as $val) {
				
				$data = array(
				'jm_category_name' => $val['category'],
				'jm_skill_name' => $val['skill']
			);
				$this->db->insert('jm_skills_tab', $data);
			}

			//print_r($data);

		// //sql query to insert category and resp skill json
		// 	
		

	}
//-----------------------------------function end---------------------------------------//


}
?>