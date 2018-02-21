<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR | E_PARSE);
class Post_project_model extends CI_model
{
  public function __construct()
  {
   parent::__construct();

 }
  //----this fun is used to get the count of projects-------------------------------------//
 public function getCountOf_Projects(){
  $sql = "SELECT count(*) as projectCount FROM jm_project_list";
  $result = $this->db->query($sql);
  if ($result->num_rows() <= 0) {
    $response = array(
      'status' => 0,
      'status_message' => 'No Project Found.');
  } else {

    foreach ($result->result_array() as $row) {
      $response = $row['projectCount'];
    }
  }
  return $response;
}
  //----------this fun is used to get the count of projects-------------------------------//      
//--------------------------function to add post project form data-------//
public function get_allproject_details($data)
{
 extract($data);
         //print_r($data);die();
 $query = "INSERT INTO jm_project_list(jm_posted_user_id,jm_posted_profile_id,jm_project_title,jm_project_description,jm_project_file,jm_job_type,jm_project_skill,jm_project_price,jm_time_estimation,jm_projectbudget_type,jm_posted_time,jm_posting_date)
 VALUES('$user_id','$profile_id','$project_title','$project_description','$file','$project_type','$project_skill','$project_price','$time_estimation','$project_budget',NOW(),NOW())";
      //echo $query;die();
 $result = $this->db->query($query);
       // echo $result;die();

 if(!$result) {
  $response = array(
    'status' => 500,
    'status_message' => 'Project posting Failed.');
} else {
  $response = array(
    'status' => 200,
    'status_message' => 'Project posted Successfully.');
}
    // print_r($response);die();
return $response;
}

//--------------------------function to add post project form data-------//

// --------------fuser feedback function------------//
public function get_freelancerComments($freelanceUSer_id)
{
 $query="SELECT * FROM jm_freelancer_rating_table WHERE  jm_freelancer_id='$freelanceUSer_id'";
      //echo $query;die();
 $result=$this->db->query($query);  
 if ($result->num_rows() <= 0) 
 {
  $response = array(                                             
    'status' => 500,
    'status_message' => 'No Comments Found.');                           
} else {
  $response = array(
    'status' => 200,
    'status_message' => $result->result_array());
}
return $response;
}
////////////////////END//////////////////////////////

// --------------empuser feedback function------------//
public function get_fEmployerComments($employerUSer_id)
{
 $query="SELECT * FROM jm_employer_rating_table WHERE  jm_employer_id='$employerUSer_id'";
      //echo $query;die();
 $result=$this->db->query($query);  
 if ($result->num_rows() <= 0) 
 {
  $response = array(                                             
    'status' => 500,
    'status_message' => 'No Comments Found.');                           
} else {
  $response = array(
    'status' => 200,
    'status_message' => $result->result_array());
}
return $response;
}
////////////////////END//////////////////////////////



//---------------function to show project list--------------//

public function get_project_list()
{
 $query="SELECT * FROM jm_project_list";
    	//echo $query;die();
 $result=$this->db->query($query);  
 if ($result->num_rows() <= 0) 
 {
  $response = array(                                             
    'status' => 0,
    'status_message' => 'No Project Found.');                           
} else {
  $response = array(
    'status' => 1,
    'status_message' => $result->result_array());
}
return $response;
}
//---------------function to save feedback for freelancer project list--------------//
public function save_feedback_freelancer($data)
{

 extract($data);
 $query="SELECT * FROM jm_freelancer_rating_table WHERE jm_project_id = '$jm_project_id'";
 $result=$this->db->query($query);  
 if ($result->num_rows() > 0) 
 {
  $query_update="UPDATE jm_freelancer_rating_table SET jm_emp_id = '$jm_emp_id', jm_freelancer_id = '$jm_freelancer_id',jm_communication='$jm_communication', jm_ontimedelivery='$jm_ontimedelivery',jm_valueformoney='$jm_valueformoney',jm_expertise='$jm_expertise',jm_hire_again='$jm_hire_again',jm_feedback_comment='$jm_feedback_comment' WHERE jm_project_id = '$jm_project_id'";
          //echo $query_update;die();

  $result_update = $this->db->query($query_update);
        //echo $result_update;die();
  if(!$result_update) {
    $response = array(
      'status' => 500,
      'status_message' => 'Updation Failed.');
  } else {
    $Update= Post_project_model::update_status($jm_project_id);
    $response = array(
      'status' => 200,
      'status_message' => 'Details successfully updated.');
  }
}
else
{
  $query_insert = "INSERT INTO jm_freelancer_rating_table(jm_project_id,jm_emp_id,jm_freelancer_id,jm_communication,jm_ontimedelivery,jm_valueformoney,jm_expertise,jm_hire_again,jm_feedback_comment)
  VALUES('$jm_project_id','$jm_emp_id','$jm_freelancer_id','$jm_communication','$jm_ontimedelivery','$jm_valueformoney','$jm_expertise','$jm_hire_again','$jm_feedback_comment')";
      //echo $query;die();
  $result_insert = $this->db->query($query_insert);

  if(!$result_insert) {
    $response = array(
      'status' => 500,
      'status_message' => 'feedback is not saved.');
  } else {
    $response = array(
      'status' => 200,
      'status_message' => 'feedback saved.');
  }
}
$demo = Post_project_model::calculate_Avg_freelancing_rating($jm_freelancer_id);
$update_where = array('jm_project_id =' => $jm_project_id);
     $data=array('is_active'=>'0');    //2 value for bid status denotes freelancer is awarded...
     $this->db->where($update_where);
     $this->db->update('jm_project_list',$data);
// ------------------close project-------------------

     return $response;  

   }
  //---------------------function end---------------------------------------//

  //-----------------------function for save feedback freelancer Employer ---------//
   public function save_feedback_freelancerEmployer($data)
   {
     extract($data);
 //print_r($data);
     $query="SELECT *FROM jm_employer_rating_table WHERE jm_project_id = '$jm_project_id'";
     $result=$this->db->query($query);  
     if ($result->num_rows() > 0) 
     {
      $query="UPDATE jm_employer_rating_table SET jm_employer_id = '$jm_emp_id', jm_freelance_id = '$jm_freelancer_id',jm_communication='$jm_communication', jm_payment_prompt='$jm_promptpay',jm_acc_of_requirement='$jm_reqAccuracy',jm_work_again='$jm_workAgain',jm_feedback_comment='$emp_comment' WHERE jm_project_id = '$jm_project_id'";
        //echo $query;die();
              $result = $this->db->query($query);

      if(!$result) {
        $response = array(
          'status' => 500,
          'status_message' => 'Updation Failed.');
      } else {
       $demo = Post_project_model::calculate_Avg_freelancerEmp_rating($jm_emp_id);
      
       $response = array(
        'status' => 200,
        'status_message' => 'Details successfully updated.');
     }
            // print_r($response);die();
     return $response;

   }
   else
   {

    $query = "INSERT INTO jm_employer_rating_table(jm_project_id,jm_employer_id,jm_freelance_id,jm_communication,jm_payment_prompt,jm_acc_of_requirement,jm_work_again,jm_feedback_comment)
    VALUES('$jm_project_id','$jm_emp_id','$jm_freelancer_id','$jm_communication','$jm_promptpay','$jm_reqAccuracy','$jm_workAgain','$emp_comment')";
      //echo $query;die();
    $result = $this->db->query($query);
    if(!$result) {
      $response = array(
        'status' => 500,
        'status_message' => 'feedback is not saved.');
    } else {
      $response = array(
        'status' => 200,
        'status_message' => 'feedback saved.');
    }
     // print_r($response);die();
    return $response;
  }
}
  //-----------function end-------------------------------------------//
public function update_status($jm_project_id)
{
	$query="UPDATE jm_project_list SET is_active = '0' WHERE jm_project_id='$jm_project_id'";
	 $result=$this->db->query($query); 
  if(!$result) {
    $response = array(
      'status' => 500,
      'status_message' => 'Updation Failed.');
  } else {
   $response = array(
    'status' => 200,
    'status_message' => 'Details successfully updated.');
 } 
}

//-----------------function for calculating avg freelancing rating-------------------//
public function calculate_Avg_freelancing_rating($jm_freelancer_id)
{
  $query= "SELECT AVG((jm_communication+jm_ontimedelivery+jm_valueformoney+jm_expertise+jm_hire_again)/5) FROM jm_freelancer_rating_table WHERE jm_freelancer_id= '$jm_freelancer_id'";

  $result=$this->db->query($query);  
  if ($result->num_rows() <= 0) 
  {
   $response = array(                                             
    'status' => 500,
    'status_message' => 'No data Found.');                           
 } else {
   foreach ($result->result_array() as $key ) {
    $avg=$key['AVG((jm_communication+jm_ontimedelivery+jm_valueformoney+jm_expertise+jm_hire_again)/5)'];
               # code...
  }

  $query="UPDATE jm_user_tab SET jm_avg_rating='$avg' WHERE jm_user_id='$jm_freelancer_id'";
  $result=$this->db->query($query); 
  if(!$result) {
    $response = array(
      'status' => 500,
      'status_message' => 'Updation Failed.');
  } else {
   $response = array(
    'status' => 200,
    'status_message' => 'Details successfully updated.');
 } 

}
return $response;
} 
   //------------------function end-----------------------------//
  //-----------------------------function to calculate avg fpr freelancer employer------------------//
public function  calculate_Avg_freelancerEmp_rating($jm_emp_id)
{

 $query= "SELECT AVG((jm_communication+jm_payment_prompt+jm_acc_of_requirement+jm_work_again)/4) FROM jm_employer_rating_table WHERE jm_employer_id= '$jm_emp_id'";

    //$query="SELECT AVG(freelancer_rating) as AVG_rate FROM jm_project_list WHERE jm_freelancer_user_id=2";
 $result=$this->db->query($query);  
 if ($result->num_rows() <= 0) 
 {
   $response = array(                                             
    'status' => 500,
    'status_message' => 'No data Found.');                           
 } else {
   foreach ($result->result_array() as $key ) {
    $avg=$key['AVG((jm_communication+jm_payment_prompt+jm_acc_of_requirement+jm_work_again)/4)'];
               # code...
  }
  $query="UPDATE jm_user_tab SET jm_avg_rating='$avg' WHERE jm_user_id='$jm_employer_id'";

  $result=$this->db->query($query); 
  if(!$result) {
    $response = array(
      'status' => 500,
      'status_message' => 'Updation Failed.');
  } else {
   $response = array(
    'status' => 200,
    'status_message' => 'Details successfully updated.');
 } 

}
return $response;

}
  //----------------function end----------------------------------------------------------//


}


