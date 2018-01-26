<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Jobseeker_list_model extends CI_Model {

    public function __construct() {
        parent::__construct();
    }
    
//    get all job seeker list for explore jobseeker
    
    public function all_jobSeeker(){
       $sqlSelect = "SELECT * FROM jm_user_tab INNER JOIN jm_userprofile_tab ON jm_userprofile_tab.jm_user_id=jm_user_tab.jm_user_id INNER JOIN jm_userskills_tab ON jm_userskills_tab.jm_user_id=jm_user_tab.jm_user_id WHERE jm_user_tab.jm_profile_type = '3' ORDER BY jm_user_tab.jm_username ASC";
        $result = $this->db->query($sqlSelect);
       if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'Job Seeker list is empty.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }


// -----------------------------------------------------------------------------
    public function filterSeeker($data){

        if($data['mode']['mode'] == 'jobseeker_list'){ 
            //echo 'sujeet';exit;
            $cond = "";
            if($data['fileds']){
                //print_r($data);
                foreach ($data['fileds'] as $k => $val) {
                    $valArr = explode('/', $val);
                    if($valArr[0] != ''){
                        if($valArr[1] == 'LIKE'){
                            $cond .= "$k ".$valArr[1]." '".$valArr[0]."%' AND ";
                        }else{
                            $cond .= "$k ".$valArr[1]." '".$valArr[0]."' AND ";
                        }
                        
                    }
                }
                $cond .= " jm_user_tab.jm_profile_type = '3'";
                //$cond .= " 1=1";

                //echo $cond;exit;
                //$query = "SELECT * FROM jm_user_tab INNER JOIN jm_userprofile_tab ON jm_userprofile_tab.jm_user_id=jm_user_tab.jm_user_id INNER JOIN jm_userskills_tab ON jm_userskills_tab.jm_user_id=jm_user_tab.jm_user_id WHERE $cond ORDER BY jm_user_tab.jm_username ASC";
               $query = "SELECT * FROM jm_user_tab, jm_userprofile_tab WHERE jm_user_tab.jm_user_id=jm_userprofile_tab.jm_user_id AND $cond";
                //echo $query;die();
            //exit;
                $q=$this->db->query($query);  
                // $this->db->order_by('jm_project_id', 'DESC');
                // $q = $this->db->get($data['table']['table']);
            }else{
                $err='N/A';
                return $err;
            }
        }

        //echo $this->db->last_query();
        //print_r($q->num_rows());exit;
        
        if($q->num_rows() <=0)
        {   
            $err='N/A';
            return $err;
        }   
        else{
            return $q->result_array();
        }   
    }
    // ---------------------------------------------------------

    // ------------------------------------------------filter job list-----------------------//

// -----------------------------------------------------------------------------
    public function filterJob($data){

        if($data['mode']['mode'] == 'job_list'){ 
            //echo 'sujeet';exit;
            $cond = "";
            if($data['fileds']){
                //print_r($data);
                foreach ($data['fileds'] as $k => $val) {
                    $valArr = explode('/', $val);
                    if($valArr[0] != ''){
                        if($valArr[1] == 'LIKE'){
                            $cond .= "$k ".$valArr[1]." '".$valArr[0]."%' AND ";
                        }else{
                            $cond .= "$k ".$valArr[1]." '".$valArr[0]."' AND ";
                        }
                        
                    }
                }
                //$cond .= " 1=1";

                //echo $cond;exit;
                //$query = "SELECT * FROM jm_user_tab INNER JOIN jm_userprofile_tab ON jm_userprofile_tab.jm_user_id=jm_user_tab.jm_user_id INNER JOIN jm_userskills_tab ON jm_userskills_tab.jm_user_id=jm_user_tab.jm_user_id WHERE $cond ORDER BY jm_user_tab.jm_username ASC";
               $query = "SELECT * FROM jm_post_job WHERE $cond";
                echo $query;die();
            //exit;
                $q=$this->db->query($query);  
                // $this->db->order_by('jm_project_id', 'DESC');
                // $q = $this->db->get($data['table']['table']);
            }else{
                $err='N/A';
                return $err;
            }
        }

        //echo $this->db->last_query();
        //print_r($q->num_rows());exit;
        
        if($q->num_rows() <=0)
        {   
            $err='N/A';
            return $err;
        }   
        else{
            return $q->result_array();
        }   
    }
    // ---------------------------------------------------------
    //-------------------------------------end------------------------------------------//
}
