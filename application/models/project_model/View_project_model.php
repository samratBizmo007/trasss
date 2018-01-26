<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class View_project_model extends CI_Model {

    public function getProjectDetails($project_id) {

        $sqlSelect = "SELECT * FROM jm_project_list WHERE jm_project_id='$project_id'";
        $result = $this->db->query($sqlSelect);

        if ($result->num_rows() >= 0) {
            $response = array(
                'status' => 500,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 200,
                'status_message' => 'No data found !!!');
        }
        return $response;
    }

    public function get_skillName($skill_id) {

        $query = "SELECT * FROM jm_skills_tab WHERE jm_skill_id='$skill_id'";
        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Record Found.');
        } else {

            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }

    public function getProjectSkills($project_id) {

        $query = "SELECT * FROM jm_project_list WHERE jm_project_id='$project_id'";
        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No Skills Found.');
        } else {
            $project_skills = array();
            $skill_details = array();
            foreach ($result->result_array() as $row) {
                $project_skills = json_decode($row['jm_project_skill'], TRUE);
            }
            foreach ($project_skills as $key) {
                //print_r($key);
                $demo = View_project_model::get_skillName($key);
                foreach ($demo['status_message'] as $skill) {
                    $extra = array(
                        'skill_id' => $skill['jm_skill_id'],
                        'jm_skill_name' => $skill['jm_skill_name'],
                    );
                    $skill_details[] = $extra;
                }
            }
            $response = array(
                'status' => 200,
                'status_message' => $skill_details);
        }
        return $response;
    }

    public function saveProjectBidding($data) {
        extract($data);      
        if(!isset($jm_project_bidding_coverletter)){
            $jm_project_bidding_coverletter='';
        }
        if(!isset($jm_project_bidding_coverletter_file)){
            $jm_project_bidding_coverletter_file='';
        } 

        $sqlSelect = "SELECT * FROM jm_project_bidding WHERE jm_user_id = '$user_id' AND jm_project_id = '$project_id'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() == 0) {
            $sqlInsert = "INSERT INTO jm_project_bidding(jm_user_id,jm_project_id,jm_user_name,jm_bidding_amount,"
            . "jm_project_bidding_coverletter,jm_project_bidding_coverletter_file,"
            . "jm_bidding_date,jm_bidding_time,active) values('$user_id','$project_id','$user_name',"
            . "'$Project_Bid','$Cover_Letter','$File_path',now(),now(),'1')";
//echo $this->db->query($sqlInsert);die();
            if($this->db->query($sqlInsert)){


             $sqlSelectUser = "SELECT * FROM jm_user_tab WHERE jm_user_id = '$user_id'";
             $resultSelect = $this->db->query($sqlSelectUser);
             $avail_bids='';
             foreach ($resultSelect->result_array() as $row) {
                $avail_bids = $row['avail_bids'];
            }
            //------------update user bid counts------------------
            $sqlUpdate="UPDATE jm_user_tab SET avail_bids = ($avail_bids-1) WHERE jm_user_id='$user_id'";
            if($avail_bids==0){
                $sqlUpdate="UPDATE jm_user_tab SET avail_bids = '$avail_bids' WHERE jm_user_id='$user_id'";
            }
            
            
            if ($this->db->query($sqlUpdate)) {
                //---update project list bids----------------------------
                $updateProjectList="UPDATE jm_project_list SET jm_project_bid = (jm_project_bid+1) WHERE jm_project_id='$project_id'";
                $this->db->query($updateProjectList);
                $response = array(
                    'status' => 200,
                    'status_message' => 'Bidding Successfull..!');
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Bidding Failed...!');
            }

        }
        else{
            $response = array(
                'status' => 500,
                'status_message' => 'Bidding Failed...!');
        }
    }else{
        $response = array(
            'status' => 500,
            'status_message' => 'You Have Already Bidden On This Project...!');
    }
    return $response;
}

//----------------function to get bidded list for project
public function get_biddedList($jm_project_id)
{
    $query = "SELECT * FROM jm_user_tab, jm_project_bidding WHERE jm_user_tab.jm_user_id=jm_project_bidding.jm_user_id AND jm_project_bidding.jm_project_id='$jm_project_id' ORDER BY jm_user_tab.jm_rank DESC";
        //echo $query;die();
    $result = $this->db->query($query);
    if($result->num_rows() <=0)
    {
        $response = array(
            'status' => 500,
            'status_message' =>'No Bids found for this project.');
    }else{
        $response = array(
            'status' => 200,
            'status_message' => $result->result_array());

    }

    return $response;

    }//end of function

 //-----------------------download coverletter for bid-------------------------
    public function download($bid_id){
        $SqlSelect = "SELECT * FROM jm_project_bidding WHERE project_bid_id ='$bid_id'";
        $result = $this->db->query($SqlSelect);
        $path = '';
        if ($result->num_rows() <= 0) {
            $path = array(
                'status' => 500,
                'status_message' => 'No Record Found.');
        } else {
         foreach ($result->result_array() as $row) {
            $path = $row['jm_project_bidding_coverletter_file'];
        }
    }
    return $path;
}
    //---------------------download coverletter for bid-----------------------

     //-----------------------award project to freelancer-------------------------
public function awardProject($freelancer_id,$project_id){
    //echo $freelancer_id;echo $project_id;die();
    $update_where = array('jm_project_id =' => $project_id);
    $data=array('jm_freelancer_user_id'=>$freelancer_id);
    $this->db->where($update_where);            

    if($this->db->update('jm_project_list',$data)){

    //-------make all bids inactive for this project
     $update_whereBids = array('jm_user_id =' => $freelancer_id);
     $dataBids=array('active'=>'2');    //2 value for bid status denotes freelancer is awarded...
     $this->db->where($update_whereBids);

     if($this->db->update('jm_project_bidding',$dataBids)){
         $response = array(
            'status' => 200,
            'status_message' => 'Project awarded successfully.');
     }
     else{
        $response = array(
            'status' => 500,
            'status_message' => 'Project awarded but the Bids remained constant. Try Closing all Bids by clicking "<span class="w3-text-red">Close Bids</span>" button.');
    }
}
else{
    $response = array(
        'status' => 500,
        'status_message' => 'Award Project Failed.');
}
return $response;
}
    //---------------------award project to freelancer-----------------------

public function Fetch_Bidding_Info($user_id,$project_id){
    $selectSql = "SELECT * FROM jm_project_bidding WHERE jm_user_id='$user_id' AND jm_project_id='$project_id'";
    $result = $this->db->query($selectSql);
    if ($result->num_rows() > 0) {
        $response = array(
            'status' => 200,
            'status_message' => $result->result_array());
    } else {
        $response = array(
            'status' => 500,
            'status_message' => 'Bidding Failed...!');
    }
    return $response;
}

// ---------------close project fucntion--------------//
public function closeProject($project_id){
    $update_where = array('jm_project_id =' => $project_id);
     $data=array('is_active'=>'0');    //2 value for bid status denotes freelancer is awarded...
     $this->db->where($update_where);

     if($this->db->update('jm_project_list',$data)) {
        $response = array(
            'status' => 200,
            'status_message' => 'Project is closed permanantly');
    } else {
        $response = array(
            'status' => 500,
            'status_message' => 'Project Closing failed..!');
    }
    return $response;
}
//----------------------------
}
