<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ERROR | E_PARSE);
class Post_jobs extends CI_Controller {

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
        $data['all_skills'] = Post_jobs::get_allSkills();
        $data['all_categories'] = Post_jobs::get_allCategory();
        $this->load->view('includes/header.php');
        $this->load->view('pages/job/post_job.php', $data);
        $this->load->view('includes/footer.php');
    }

//----------function to get skill list from database--------------------------//	
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

    //----------function to get skill list from database--------------------------//    
    public function getSkill_byCategory() {
        extract($_POST);
        //Connection establishment, processing of data and response from REST API
        $path = base_url();
        $url = $path.'api/Dashboard_api/getSkill_byCategory?jm_category_name='.$jm_category_name;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
//print_r($response_json);die();
        if($response['status']==200){
        foreach($response['status_message'] as $key) {
            echo '<option value="'.$key['jm_category_name'].'"><b>'.$key['jm_category_name'].'</b></option>';
}
        }
    }
    

    //----------function to get Category list from database--------------------------//    
    public function get_allCategory() {

        //Connection establishment, processing of data and response from REST API
        $path = base_url();
        $url = $path . 'api/Dashboard_api/get_allCategory';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        return $response;
    }

//----------function to get skill list from database--------------------------//
    public function SaveJOB() {
        extract($_POST);
            //print_r($_POST);die();
            //echo json_encode($skill);
        $salary='';
        if($Salary_range == 0){
            $Salary_range = 'As Per Company Norms';
        }
        $data = $_POST;
        
        $data['skill'] = json_encode($_POST['skill']);                    
        $data['Salary_range'] = $Salary_range;
        
        $user_id = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('user_name');
        $profile_type = $this->session->userdata('profile_type');
        
        $data['user_id'] = $user_id;
        $data['user_name'] = $user_name;
        $data['profile_type'] = $profile_type;
        //print_r($data);die();
        $path = base_url();
        $url = $path.'api/PostJob_api/SaveJOB';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        //print_r($response_json);die();
        if ($response['status'] == 200) {
            echo '<h3 class="bluish-green w3-margin"><i class="fa fa-check"></i> '.$response['status_message'].'</h3>   
            <script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                window.location.href="'.base_url().'profile/dashboard";
            }, 800);
            </script>';
        } else {
            echo '<h3 class="w3-text-red w3-margin"><i class="fa fa-warning"></i>Something went wrong. Job Posting Failed !!!</h3> 
            <script>
            /*window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                location.reload();
                //window.location.href="'.base_url().'profile/dashboard";
            }, 800);*/
            </script>   
            ';
        }
        
    }

}
