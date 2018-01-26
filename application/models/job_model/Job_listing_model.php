<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Job_listing_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model/Dashboard_model');
    }
    public function getRecentJobs(){
       $SqlSelect = "SELECT * FROM jm_post_job WHERE is_active ='1' ORDER BY jm_posted_date DESC LIMIT 20";
       $result = $this->db->query($SqlSelect);
       if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
       }else{
           $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
       }  
       return $response;
    }

    public function getAllJob_Details($user_id) {
        $SqlSelect = "SELECT * FROM jm_post_job WHERE is_active ='1' AND jm_user_id = '$user_id' ORDER BY jm_posted_date DESC";
        $result = $this->db->query($SqlSelect);
        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $skill_details = array();
            $jobs = '';
            $jobDetails = array();
            $skills = '';
            foreach ($result->result_array() as $row) {
                $skills = $row['jm_skills'];
               
                $jobs = array(
                    'job_id' => $row['jm_jobpost_id'],
                    'job_name' => $row['jm_job_post_name'],
                    'job_type' => $row['jm_job_type'],
                    'company_name' => $row['jm_company_name'],
                    'qualification' => $row['jm_qualification'],
                    'responsibility' => $row['jm_responsibility'],
                    'Address' => $row['jm_venue_address'],
                    'Salary_range' => $row['jm_salary_range'],
                    'positions' => $row['jm_positions'],
                    'Active' => $row['is_active'],
                    'city' => $row['jm_job_city'],
                    'skills' => $skills
                );
                 $jobDetails[] = $jobs;

            }             
            $response = array(
                'status' => 200,
                'status_message' => $jobDetails);
        }
        //print_r($jobs);die();
        return $response;
    }

    public function getAllJobs() {
        $SqlSelect = "SELECT * FROM jm_post_job WHERE is_active ='1' ORDER BY jm_posted_date DESC";
        $result = $this->db->query($SqlSelect);
        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Jobs Found.');
        } else {
            $skill_details = array();
            $jobs = '';
            $jobDetails = array();
            $skills = '';
            foreach ($result->result_array() as $row) {
                $skills = $row['jm_skills'];
               
                $jobs = array(
                    'job_id' => $row['jm_jobpost_id'],
                    'job_name' => $row['jm_job_post_name'],
                    'job_type' => $row['jm_job_type'],
                    'company_name' => $row['jm_company_name'],
                    'qualification' => $row['jm_qualification'],
                    'responsibility' => $row['jm_responsibility'],
                    'Address' => $row['jm_venue_address'],
                    'Salary_range' => $row['jm_salary_range'],
                    'positions' => $row['jm_positions'],
                    'Active' => $row['is_active'],
                    'city' => $row['jm_job_city'],
                    'skills' => $skills
                );
                 $jobDetails[] = $jobs;

            }             
            $response = array(
                'status' => 200,
                'status_message' => $jobDetails);
        }
        //print_r($jobs);die();
        return $response;
    }

    // -----------job details for deep linked params-----------//
    public function getAllJob_Details_param($search_cat) {
        $SqlSelect = "SELECT * FROM jm_post_job WHERE jm_job_type='$search_cat' AND is_active ='1' ORDER BY jm_posted_date DESC";
        $result = $this->db->query($SqlSelect);
        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $skill_details = array();
            $jobs = '';
            $jobDetails = array();
            $skills = '';
            foreach ($result->result_array() as $row) {
                $skills = $row['jm_skills'];
               
                $jobs = array(
                    'job_id' => $row['jm_jobpost_id'],
                    'job_name' => $row['jm_job_post_name'],
                    'job_type' => $row['jm_job_type'],
                    'company_name' => $row['jm_company_name'],
                    'qualification' => $row['jm_qualification'],
                    'responsibility' => $row['jm_responsibility'],
                    'Address' => $row['jm_venue_address'],
                    'Salary_range' => $row['jm_salary_range'],
                    'positions' => $row['jm_positions'],
                    'Active' => $row['is_active'],
                    'city' => $row['jm_job_city'],
                    'skills' => $skills
                );
                 $jobDetails[] = $jobs;

            }             
            $response = array(
                'status' => 200,
                'status_message' => $jobDetails);
        }
        //print_r($jobs);die();
        return $response;
    }
//------------------------------------------------------------//

    public function FetchSkills($Skills) {
        //print_r($Skills);die();
        foreach (json_decode($Skills, TRUE) as $key) {
            $demo = $this->Dashboard_model->get_skillName($key);
            foreach ($demo['status_message'] as $skill) {
                $extra = array(
                    'jm_skill_name' => $skill['jm_skill_name'],
                );
                $skill_details[] = $extra;
            }
        }
        return $skill_details;
    }
    public function CloseJob($job_id){
        $sqlDelete = "UPDATE jm_post_job SET is_active='0' WHERE jm_jobpost_id='$job_id'";
        $result = $this->db->query($sqlDelete);

       if ($result) {
            $response = array(
                'status' => 200,
                'status_message' => 'Job Closed..!');
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'Records Not Closed...!');
        }
        return $response;
    }
    public function getClosed_Jobs(){
        $SqlSelect = "SELECT * FROM jm_post_job WHERE is_active ='0'";
        $result = $this->db->query($SqlSelect);
        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $skill_details = array();
            $jobs = '';
            $jobDetails = array();
            $skills = '';
            foreach ($result->result_array() as $row) {
                $skills = $row['jm_skills'];
               
                $jobs = array(
                    'job_id' => $row['jm_jobpost_id'],
                    'job_name' => $row['jm_job_post_name'],
                    'job_type' => $row['jm_job_type'],
                    'company_name' => $row['jm_company_name'],
                    'qualification' => $row['jm_qualification'],
                    'responsibility' => $row['jm_responsibility'],
                    'Address' => $row['jm_venue_address'],
                    'Salary_range' => $row['jm_salary_range'],
                    'positions' => $row['jm_positions'],
                    'Active' => $row['is_active'],
                    'skills' => $skills
                );
                 $jobDetails[] = $jobs;

            }             
            $response = array(
                'status' => 200,
                'status_message' => $jobDetails);
        }
        //print_r($jobs);die();
        return $response;
    }
}
