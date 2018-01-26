<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Edit_profile_model extends CI_model
{
  public function __construct()
  {
     parent::__construct();

 }
//--------------------------function to get edit info about user-------//
 public function get_allEditdetails($data)
 {
   extract($data);
   $query = "UPDATE jm_userprofile_tab SET jm_user_name='$jm_user_name',jm_userDesignation='$jm_userDesignation',jm_userDescription='$jm_userDescription',jm_userCity='$jm_userCity',jm_userState='$jm_userState',jm_userCountry='$jm_userCountry',jm_education='$jm_education',jm_experience='$jm_experience',jm_linkedIn_url='$jm_linkedIn_url',jm_profile_image='$file',jm_ratePerHr='$jm_rateHr',jm_userAspiration='$jm_userAspiration',expected_salary='$expected_salary',last_updated=NOW() WHERE jm_user_id='$jm_user_id'";
      //echo $query;die();
   $result = $this->db->query($query);
       // echo $result;die();

   if(!$result) {
    $response = array(
        'status' => 500,
        'status_message' => 'Updation Failed.');
} else {
    $response = array(
        'status' => 200,
        'status_message' => 'Details successfully updated.');
}
    // print_r($response);die();
return $response;
}
    // -----------------------fucntion ends here--------------------------//

    // -----------------------GET ALL USER PROFILE INFO MODEL----------------------//
    //-------------------------------------------------------------//
public function get_userProfile_info($user_id){

    $query = "SELECT * FROM jm_userprofile_tab WHERE jm_user_id='$user_id'";

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
    // -----------------------GET ALL USER PROFILE INFO MODEL----------------------//
    //-------------------------------------------------------------//
}