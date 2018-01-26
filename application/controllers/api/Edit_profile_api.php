<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH . '/libraries/REST_Controller.php');

class Edit_profile_api extends REST_Controller {

    public function __construct() 
    {
        parent::__construct();
        $this->load->model('profile_model/edit_profile_model');
    }
//---------------Api for get all project details from form---------//
     public function get_allEditdetails_post()
     {
        $data = $_POST;
        $result = $this->edit_profile_model->get_allEditdetails($data);
        return $this->response($result);            
     }
     // ------------------------END------------------------------------//


     // -----------------------USER PROFILE INFORMATION API----------------------//
    //-------------------------------------------------------------//
    public function get_userProfile_info_get(){
        extract($_GET);
        $result = $this->edit_profile_model->get_userProfile_info($user_id);
        return $this->response($result);            
    }
    //---------------------USER PROFILE INFORMATION END------------------------------//
    }