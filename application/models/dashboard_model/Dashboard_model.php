<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard_model extends CI_Model{

	public function __construct() {
		parent::__construct();
    //$this->load->model('search_model');
	}
        //------------this fun is used to get the the applied jobs------------------------//
        
	public function getAppliedJobs_ByUser($user_id) {
		$sqlSelect = "SELECT * FROM jm_applied_candidates as can JOIN jm_post_job as job ON (can.jm_job_id = job.jm_jobpost_id) WHERE can.jm_applieduser_id ='$user_id' AND job.is_active = '1'";
		$result = $this->db->query($sqlSelect);
		if ($result->num_rows() > 0) {
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		} else {
			$response = array(
				'status' => 500,
				'status_message' => 'No Skills Found.');
		}
		return $response;
	}
        //------------this fun is used to get the the applied jobs------------------------//
    //------------this fun is used to get the the previous jobs------------------------//
    public function getPostedJobs_ByUser($user_id) {
        $sqlSelect = "SELECT * FROM jm_applied_candidates as can JOIN jm_post_job as job ON (can.jm_job_id = job.jm_jobpost_id) WHERE can.jm_applieduser_id ='$user_id' AND job.is_active = '0'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;
    }

    //------------this fun is used to get the the previous jobs------------------------//
    //------------this fun is used to get the the posted jobs by job employer------------------------//
    public function getPosted_JobsByJobEmployer($user_id){
       $sqlSelect = "SELECT * FROM jm_post_job WHERE jm_user_id='$user_id' AND is_active='1' ORDER BY jm_jobpost_id DESC";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response; 
    }
    //------------this fun is used to get the the posted jobs by job employer------------------------//
    
    public function getPrevious_JobsByJobEmployer($user_id){
      $sqlSelect = "SELECT * FROM jm_post_job WHERE jm_user_id='$user_id' AND is_active='0'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;  
    }

    public function Show_Live_Projects($user_id){
        $sqlSelect = "SELECT * FROM jm_project_list WHERE jm_posted_user_id='$user_id' AND is_active='1'";
        //echo $sqlSelect;die();
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;  
    }

    // ----------freelancer live projects-------------------//
    public function freelanceLive_Projects($user_id){
        $sqlSelect = "SELECT * FROM jm_project_list WHERE jm_freelancer_user_id='$user_id' AND is_active='1'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;  
    }
    // -------------fucntion ends here----------------------//

    // ----------freelancer previous projects-------------------//
    public function freelancePrevious_Projects($user_id){
        $sqlSelect = "SELECT * FROM jm_project_list WHERE jm_freelancer_user_id='$user_id' AND is_active='0'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;  
    }
    // -------------fucntion ends here----------------------//

    public function get_userDetails($user_id){
        $sqlSelect = "SELECT * FROM jm_user_tab WHERE jm_user_id = '$user_id'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response; 
    }

    public function Show_Previous_Projects($user_id){
        $sqlSelect = "SELECT * FROM jm_project_list WHERE jm_posted_user_id='$user_id' AND is_active='0'";
        $result = $this->db->query($sqlSelect);
        if ($result->num_rows() > 0) {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'No Records Found.');
        }
        return $response;  
    }

    public function addRow($user_id){
		$query = "SELECT * FROM jm_userprofile_tab WHERE jm_user_id='$user_id'";

		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$insert_query = "INSERT INTO jm_userprofile_tab(jm_user_id,last_updated) values('$user_id',NOW())";
        //echo $query; die();
			$this->db->query($insert_query);
		}
	}

    // -----------------------GET ALL SKILLS MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_allSkills(){

		$query = "SELECT * FROM jm_skills_tab ORDER BY jm_skill_name";

		$result = $this->db->query($query);

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
	// -----------------------GET ALL SKILLS MODEL----------------------//
	//-------------------------------------------------------------//

	// -----------------------GET ALL SKILLS  BY CATEGORY MODEL----------------------//
	//-------------------------------------------------------------//
	public function getSkill_byCategory($jm_category_name){
		$query = "SELECT * FROM jm_skills_tab ";
		$result = $this->db->query($query);

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
	// -----------------------GET ALL SKILLS  BY CATEGORY MODEL----------------------//
	//-------------------------------------------------------------//

// -----------------------GET ALL CATEGORY MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_allCategory(){

		$query = "SELECT DISTINCT jm_category_name FROM jm_skills_tab ORDER BY jm_category_name ASC";

		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'No Category Found.');
		} else {
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		}
		return $response;
	}
	// -----------------------GET ALL CATEGORY MODEL----------------------//
	//-------------------------------------------------------------//

	// -----------------------GET ALL USER INFO MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_userInfo($user_id,$profile_type){

		$query = "SELECT * FROM jm_user_tab WHERE jm_user_id='$user_id' AND jm_profile_type='$profile_type'";

		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'User Info Not Found.');
		} else {
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		}
		return $response;
	}
	// -----------------------GET ALL USER INFO MODEL----------------------//
	//-------------------------------------------------------------//

	// -----------------------GET ALL USER TRANSACTION MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_userTransaction($user_id){

		$query = "SELECT * FROM jm_usertransaction_tab WHERE jm_user_id='$user_id'";

		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'No Financial Record found for this user.');
		} else {
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		}
		return $response;
	}
	// -----------------------GET ALL USER TRANSACTION MODEL----------------------//
	//-------------------------------------------------------------//

	// -----------------------GET ALL USER SKILLS MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_userSkills($user_id,$profile_type){

		$query = "SELECT * FROM jm_userSkills_tab WHERE jm_user_id='$user_id' AND jm_profile_type='$profile_type'";
		//echo $query;die();
		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'No Skills Added yet.');
		} else {
			$user_skills=array();
			$skill_details=array();
			foreach ($result->result_array() as $row) {
				$user_skills=json_decode($row['jm_skills'],TRUE);
			}
				//print_r($user_skills);die();
			foreach ($user_skills as $key) {
				//print_r($key);
				$demo=Dashboard_model::get_skillName($key);	
				foreach ($demo['status_message'] as $skill) {

					$extra=array(
						'skill_id'	=>	$skill['jm_skill_id'],
						'jm_skill_name'	=>	$skill['jm_skill_name'],
					);
					$skill_details[]=$extra;
				}
			}
			//print_r($skill_details);die();
			$response = array(
				'status' => 200,
				'status_message' => $skill_details);
		}
		return $response;
	}
	// -----------------------GET ALL USER SKILLS MODEL----------------------//
	//-----------------------------------------------------------------------//

	// -----------------------GET ALL USER FEEDBACK MODEL----------------------//
	//-------------------------------------------------------------//
	public function get_userFeedback($user_id,$profile_type){

		if($profile_type=='1'){
			$query="SELECT * FROM jm_project_list WHERE jm_freelancer_user_id='$user_id'  AND freelancer_comment !=''";
		}
		else{
			$query = "SELECT * FROM jm_project_list WHERE jm_posted_user_id='$user_id' AND jm_posted_profile_id='$profile_type'  AND employer_comment !=''";
		}
		//echo $query;die();
		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'No Feedback found for this profile.');
		} else {			
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		}
		return $response;
	}
	// -----------------------GET ALL USER FEEDBACK MODEL----------------------//
	//-----------------------------------------------------------------------//

	// -----------------------GET ALL USER SKILLS NAME----------------------//
	//-------------------------------------------------------------//
	public function get_skillName($skill_id){

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
	// -----------------------GET ALL USER SKILLS NAME----------------------//
	//-------------------------------------------------------------//

	// -----------------------DELETE USER SKILLS NAME----------------------//
	//-------------------------------------------------------------//
	public function del_userSkill($user_id,$skill_id,$profile_type){

		$query = "SELECT * FROM jm_userSkills_tab WHERE jm_user_id='$user_id' AND jm_profile_type='$profile_type'";
		$result = $this->db->query($query);

		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'No Skills Record Found.');
		} else {
			$extra=array();
			foreach ($result->result_array() as $row) {
				$user_skills=json_decode($row['jm_skills'],TRUE);

				foreach ($user_skills as $key) {
					//print_r($key);
					if ($key != $skill_id) {						
						$extra[]=$key;
					}
				}
			}
			$update_where = array('jm_user_id =' => $user_id, 'jm_profile_type =' => $profile_type);
			$data=array('jm_skills'=>json_encode($extra));
			$this->db->where($update_where);			

			if($this->db->update('jm_userSkills_tab',$data)){
				$response = array(
					'status' => 200,
					'status_message' => 'Skill Deleted.');
			}						
		}
		return $response;
	}
	// -----------------------DELETE USER SKILLS NAME----------------------//
	//-------------------------------------------------------------//


	// -----------------------USER SKILL MODEL----------------------//
	//-------------------------------------------------------------//
	public function add_userSkills($user_id,$skill_id,$profile_type)
	{

	//sql query to get all user skills
		$query="SELECT * FROM jm_userSkills_tab WHERE jm_user_id='$user_id' AND jm_profile_type='$profile_type'";
		$result = $this->db->query($query);

		$user_skills=array();

	//if no record found for user
		if($result->num_rows() == 0){			
			
			$user_skills[]=$skill_id;
			$data = array(
				'jm_user_id' => $user_id,
				'jm_profile_type' => $profile_type,
				'jm_skills' => json_encode($user_skills)
			);
		//sql query to insert new user skill record if not available
			if($this->db->insert('jm_userSkills_tab', $data)){
				$response = array(
					'status' => 200,
					'status_message' => 'Skill added.');
			}
			else{
				$response = array(
					'status' => 500,
					'status_message' => 'Skill Addition failed.');
			}
			
		}
		else
		{
			//$user_skill='';
			foreach ($result->result_array() as $row) {
				$user_skills=json_decode($row['jm_skills'],TRUE);
			}
			$user_skills[]=$skill_id;
			//print_r(json_encode($user_skills));die();
			$update_where = array('jm_user_id =' => $user_id, 'jm_profile_type =' => $profile_type);
			$data=array('jm_skills'=>json_encode($user_skills));
			$this->db->where($update_where);			

			if($this->db->update('jm_userSkills_tab',$data)){
				$response = array(
					'status' => 200,
					'status_message' => 'Skills list updated.');
			}
			else{
				$response = array(
					'status' => 500,
					'status_message' => 'Skills Updation failed.');
			}
		}
		return $response;
	}

	//----------------------------USER SKILLS END------------------------------//


	//-----------------------function to check whether privilege level already exists------------------//
	function checkPrivilege_exist($privilege_level)
	{
		$query = null;
		$query = $this->db->get_where('roles', array(
			'privilege_level' => $privilege_level
		));		

		if ($query->num_rows() > 0) {
			return 0;			
		} else {
			return 1;			
		}
	}
//-----------------------------------function end---------------------------------------//

}
?>