<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
class Freelancer_list extends CI_Controller
{
	public function __construct(){
		parent::__construct();
		// //start session		
		// $user_id=$this->session->userdata('user_id');
		// $user_name=$this->session->userdata('user_name');
		// $privilege=$this->session->userdata('privilege');

		// //check session variable set or not, otherwise logout
		// if(($user_id=='') || ($user_name=='') || ($privilege=='')){
		// 	redirect('role_login');
		// }

	}

	public function index(){

		$user_id = $this->session->userdata('user_id');
		$this->load->database();
		$this->load->model('freelancer_model/freelancer_model');
		$data['info']=$this->freelancer_model->get_freelancer();

		$path=base_url();
		$url = $path.'api/Dashboard_api/get_allSkills';   
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$data['all_skills'] = json_decode($response_json, true);

		//print_r($response);die();
		//$data['all_skills']=Project_listing::get_allSkills();
		//$data['user_details']=Project_listing::get_userDetails();

		$this->load->view('includes/header.php');
		$this->load->view('pages/freelancer/freelancer_list.php',$data);
		$this->load->view('includes/footer.php');
	}

	
}

?>