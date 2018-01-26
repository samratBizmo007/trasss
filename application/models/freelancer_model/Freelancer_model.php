<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Freelancer_model extends CI_Model{

	public function __construct() {
		parent::__construct();
    //$this->load->model('search_model');
	}

	public function get_freelancer(){
		$user_id = $this->session->userdata('user_id');
		$profile_type=$this->session->userdata('profile_type');
		//echo '1';exit;
		$query = "SELECT * FROM jm_user_tab INNER JOIN jm_userprofile_tab ON jm_userprofile_tab.jm_user_id=jm_user_tab.jm_user_id INNER JOIN jm_userskills_tab ON jm_userskills_tab.jm_user_id=jm_user_tab.jm_user_id WHERE jm_user_tab.jm_profile_type = '1' ORDER BY jm_user_tab.jm_username ASC";
		
		$result=$this->db->query($query);  
		if ($result->num_rows() <= 0) 
		{
			$response = array(                                             
				'status' => 0,
				'status_message' => 'No Data Found.');                           
		} else {
			$response = array(
				'status' => 1,
				'status_message' => $result->result_array());
		}
		//echo '<pre>';print_r($result->result_array());die();
		return $response;
		 // print_r($response);die();
	}
}
?>