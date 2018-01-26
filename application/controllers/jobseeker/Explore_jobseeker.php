<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//error_reporting(E_ERROR | E_PARSE);

class Explore_jobseeker extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // //start session		
        // $user_id = $this->session->userdata('user_id');
        // $user_name = $this->session->userdata('user_name');
        // $profile_type = $this->session->userdata('profile_type');
        // //check session variable set or not, otherwise logout
        // if (($user_id == '') || ($user_name == '') || ($profile_type == '')) {
        //     redirect('auth/login');
        // }
    }

    public function index() {
        $data['job_seeker'] = Explore_jobseeker::all_jobSeeker();
//        $search_cat=$this->input->get('search_param', TRUE);
//        if($search_cat!=''){
//            $data['jobs'] = Explore_jobseeker::getAllJob_Details_param($search_cat);
//        }    
        //print_r($data);    
        $this->load->view('includes/header.php');
        $this->load->view('pages/jobseeker/explore_jobseeker.php', $data);
        $this->load->view('includes/footer.php');
    }

   public function get_allSkills() {

        //Connection establishment, processing of data and response from REST API
        $path = base_url();
        $url = $path . 'api/Dashboard_api/get_allSkills';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        return $response;
    }
    public function all_jobSeeker() {
        $path = base_url();
        $url = $path . 'api/Jobseeker_list_api/all_jobSeeker';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        return $response;
    }

    public function getAllJob_Details_param($search_cat) {
        
        $path = base_url();
        $url = $path . 'api/JobListing_api/getAllJob_Details_param?param='.$search_cat;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        return $response;
    }

    public function getJob_Details($job_id) {
        $path = base_url();
        $url = $path . 'api/JobApplications_api/getJob_Details?job_id='.$job_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        return $response;
    }

    // ---------------explore job seeker filter--------------//
    public function filterSeeker(){ 
    $this->load->model('jobseeker_model/Jobseeker_list_model','jobSeeker');
    $data = $this->input->post();
    
    $result['result'] = $this->jobSeeker->filterSeeker($data);
    //echo '<pre>';print_r($result);exit;
    if($result['result'] == 'N/A'){
      echo '
      <div class="w3-col 12 w3-padding w3-margin">              
      <div class="w3-col l12">
      <div class="w3-center">
      <img src="'.base_url().'css/logos/no_data.png" width="auto" class="img"/>
      </div>
      </div>             
      </div>';
    }else{
      
      if($data['mode']['mode'] == 'jobseeker_list'){
        $this->load->view('pages/jobseeker/_jobseeker.php',$result);
      }
    }

  }
  //---------------------fucntion ends--------------------//

}
