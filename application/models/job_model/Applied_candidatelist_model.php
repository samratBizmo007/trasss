<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Applied_candidatelist_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->model('dashboard_model/Dashboard_model');
    }
    //--------------------------------------------------------------
    public function showApplied_candidate_list($job_id){
        $SqlSelect = "SELECT * FROM jm_applied_candidates WHERE jm_job_id ='$job_id'";
        $result = $this->db->query($SqlSelect);
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
    //---------------------------------------------------------------------
    //-------------------------------------------------------------------------
    public function DownloadCsv($job_id){
        $querynew = "SELECT * FROM jm_applied_candidates WHERE jm_job_id='$job_id'";
        $query = $this->db->query($querynew);
        $delimiter = "|";
        $newline = "\r\n";
        
        $response = array(
            'status' => 200,
            'status_message' => 'Candidates Found.',
            'query' => $query,
            'delimeter' => $delimiter,
            'newline' => $newline);
        
        return $response; 
    }
    public function SaveStatus($Candidate_Status,$candidate_id){
        foreach(json_decode($candidate_id) as $id){
            $sqlUpdate = "UPDATE jm_applied_candidates SET status='$Candidate_Status' WHERE jm_applieduser_id='$id'";
            $result = $this->db->query($sqlUpdate);
        }
        if ($result) {
            $response = array(
                'status' => 200,
                'status_message' => 'Status Updated Successfully..!');
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'Status Update Failed..!');
        }
        return $response;

    }
    public function hireSelectedStudents($candidate_id,$job_id){
      // echo $job_id;die();
      $sqlUpdate = "UPDATE jm_post_job SET selected_candidates = '$candidate_id', is_active='0' WHERE jm_jobpost_id='$job_id'";
      if($this->db->query($sqlUpdate)){      
          $sqlselect = "SELECT * FROM jm_post_job WHERE jm_jobpost_id ='$job_id'";
          $result = $this->db->query($sqlselect);
          
          $job_name = '';
          $company_name = '';
          
          if($result-> num_rows() >= 1){
            foreach ($result->result_array() as $key) {
                $job_name = $key['jm_job_post_name'];
                $company_name = $key['jm_company_name'];
            }
        }
        foreach(json_decode($candidate_id) as $id){
            
            $sqlSelect = "SELECT * FROM jm_applied_candidates WHERE jm_applieduser_id='$id'";
            $result = $this->db->query($sqlSelect);
            $email_id = '';
            $username = '';
            foreach ($result->result_array() as $row) {
               $email_id = $row['jm_email_id'];
               $username = $row['jm_candidate_name'];
           }
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

           if ($result->num_rows() >= 1) {
             
            $current_date = date('Y-m-d');                
            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('customercare@jobmandi.in', "Admin Team");
            $this->email->to($email_id);
            $this->email->subject("JOBMANDI-Job Selection");
            $this->email->message('<html>'
                . '<head>'
                . '<title>Congratulations...!</title>'
                . '</head>'
                . '<body>'                        
                . '<form action="/action_page.php">'
                . '<fieldset>'
                . '<legend>Congratulations...!</legend>'
                . '<p><label>You Have Been Selected For Your Applied Job Position- '.$job_name.'</label></p>'
                . '<p><label>Company Name- '.$company_name.'</label></p>'
                . '<a class="btn" href="'. base_url().'auth/login?profile=3">login</a>'
                . '</fieldset>'
                . '</form>'
                . '</body>'
                . '</html>');

                $this->email->send(); //----send email function
                
                $response = array(
                    'status' => 200,
                    'status_message' => 'Email Sent Successfully...!');
                
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Mail Sending Failed!');
            } 
        }
    }else{
       $response = array(
        'status' => 500,
        'status_message' => 'Hire Job Seekers Failed!');
   }

   return $response;
}
    // ------------------fucntion ends here-0-----//

public function download($user_id){
    $SqlSelect = "SELECT * FROM jm_applied_candidates WHERE jm_applieduser_id ='$user_id'";
    $result = $this->db->query($SqlSelect);
    $path = '';
    if ($result->num_rows() <= 0) {
        $path = array(
            'status' => 500,
            'status_message' => 'No Skills Found.');
    } else {
     foreach ($result->result_array() as $row) {
        $path = $row['jm_file_resume'];
    }
}
return $path;
}
}
