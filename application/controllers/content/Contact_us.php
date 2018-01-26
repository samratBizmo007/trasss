<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');

error_reporting(E_ERROR | E_PARSE);
class Contact_us extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		
	}

	public function index(){
		//$data['jobs']= About_us::getRecentJobs();		
		$this->load->view('includes/header.php');
		$this->load->view('pages/static/contact_us.php');
		$this->load->view('includes/footer.php');
		
	}

	public function sendContactEmail($username,$email,$profile_type)
	{
		extract($_POST);
		//print_r($_POST);die();
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
		$this->email->from($email,$user_name);
		$this->email->to('customercare@jobmandi.in',"Admin Team");  
		$this->email->subject("JOBMANDI-Contact Form");
		$this->email->message("Dear ".$user_name.",\nPlease click on below URL or paste into your browser to verify your Email Address\n\n <a href='".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."'>".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."</a>\n"."\n\nThanks\nAdmin Team");

		if (!$this->email->send()) {
			$response=array(
				'status' => 500,	//---------email sending failed
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

}
?>