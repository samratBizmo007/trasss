<?php
//User Dashboard controller
class Dashboard extends CI_Controller {

	public function __construct() {
		parent::__construct();

        //start session   
		$user_id=$this->session->userdata('user_id');
		$user_name=$this->session->userdata('user_name');
		
    //check session variable set or not, otherwise logout
		if(($user_id=='') || ($user_name=='')){
			redirect('login');
		}  
	}

	public function index() {
		$this->load->library('user_agent');
		$data['orderCount'] = Dashboard::getMyOrderCount();     //-------show all order count
		$data['dashImage']=Dashboard::getDashImage();

		if ($this->agent->is_mobile())
		{
			$this->load->view('includes/mobile/header');
			$this->load->view('pages/user/usermobile_dashboard',$data);
			$this->load->view('includes/mobile/footer');
		}
		else{
			$this->load->view('includes/header');
			$this->load->view('pages/user/user_dashboard',$data);
		}
		
	}
	
	//----------this function to get admin details-----------------------------
 public function getDashImage() {

  $path = base_url();
  $url = $path . 'api/Admin_api/getDashImage?setting_name=dash_image';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  return $response;
}
//----------------this fun get admin details end---------------//
	
//----------this function to get all my orders count-----------------------------
	public function getMyOrderCount() {
		$user_id=$this->session->userdata('user_id');
  //$user_id=1;

		$path = base_url();
		$url = $path . 'api/ManageOrder_api/getOrderCount?user_id='.$user_id;
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPGET, true);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response_json = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response_json, true);
		return $response;
	}
//----------------this fun get all my orders count end---------------//


}
?>