<?php

defined('BASEPATH') OR exit('No direct script access allowed');

require(APPPATH.'/libraries/REST_Controller.php');

class View_Project_api extends REST_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('project_model/View_project_model');
        date_default_timezone_set('Asia/Kolkata'); //set Kuwait's timezone
    }
    public function getProjectDetails_get(){
        extract($_GET);
        $result = $this->View_project_model->getProjectDetails($project_id);
        return $this->response($result); 
    }
    public function getProjectSkills_get(){
        extract($_GET);
        $result = $this->View_project_model->getProjectSkills($project_id);
        return $this->response($result);
    }
    public function saveProjectBidding_POST(){
        $data = $_POST;
        $response = $this->View_project_model->saveProjectBidding($data);
        return $this->response($response);
    }
    public function Fetch_Bidding_Info_get(){
        $user_id = $_GET['user_id'];
        $project_id = $_GET['project_id'];
        $response = $this->View_project_model->Fetch_Bidding_Info($user_id,$project_id);
        return $this->response($response);
    }

    public function download_get(){
        extract($_GET);
        $result = $this->View_project_model->download($bid_id);
        return $this->response($result);
    }

    // ------------------AWARD PROJECT-------------------//
     public function awardProject_get(){
        extract($_GET);
        $result = $this->View_project_model->awardProject($freelancer_id,$project_id);
        return $this->response($result);
    }
    //-----------------------END-------------------------//


    // ------------------CLOSE PROJECT-------------------//
     public function closeProject_get(){
        extract($_GET);
        $result = $this->View_project_model->closeProject($project_id);
        return $this->response($result);
    }
    //-----------------------END-------------------------//

      //----------------function for show bidded list for projrct------------------------//
    public function get_biddedList_get()
    {
        extract($_GET);
        $result = $this->View_project_model->get_biddedList($project_id);
        return $this->response($result);
    }
    //---------------------end function--------------------------------//  
}
