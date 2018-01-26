<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobapplication_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model/Dashboard_model');
    }
    public function checkAlreadyApplied($job_id,$user_id){
       $sqlSelect = "SELECT * FROM jm_applied_candidates WHERE jm_job_id='$job_id' AND jm_applieduser_id='$user_id'";
        $result = $this->db->query($sqlSelect);
       if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response; 
    }

    public function getJob_Details($job_id){
       $sqlSelect = "SELECT * FROM jm_post_job WHERE jm_jobpost_id='$job_id'";
        $result = $this->db->query($sqlSelect);
       if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }
    
    public function saveApplication($data){
        extract($data);
        //print_r($data);die();
        $sqlSelect = "SELECT * FROM jm_applied_candidates WHERE jm_job_id='$job_id' AND jm_applieduser_id='$user_id'";
        $result = $this->db->query($sqlSelect);
        if($result->num_rows() <= 0){
           $insert = "INSERT INTO jm_applied_candidates(jm_candidate_name,jm_email_id,"
                   . "jm_contact_no,jm_message,jm_applied_date,jm_applied_time,"
                   . "jm_file_resume,jm_job_id,jm_applieduser_id,status) "
                   . "values('$candidate_name','$Email_id','$contact_no',"
                   . "'$message',now(),now(),'$File_path','$job_id','$user_id','')";
           
           $resultInsert = $this->db->query($insert);
            
            if ($resultInsert) {
                $response = array(
                    'status' => 200,
                    'status_message' => 'Applied Successfully..!');
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Application Failed...!');
            }
           
        }else{
                $response = array(
                    'status' => 500,
                    'status_message' => 'Already Applied...!');
        }
        return $response;
    }
}