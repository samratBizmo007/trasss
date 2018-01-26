<?php 
if(!defined('BASEPATH')) exit('No direct script access allowed');
error_reporting(E_ERROR | E_PARSE);
//Jobmandi profile Edit profile
class Edit_profile extends CI_Controller
{
	public function __construct(){
		parent::__construct();
	}

  public function index()
  {
   $data['all_userProfile_info']=Edit_profile::get_userProfile_info();
   $this->load->view('includes/header.php');
   $this->load->view('pages/profile/edit_profile',$data);
   $this->load->view('includes/footer.php');	
 }

 //------------Function to get all data of user profile------------//
    public function get_userProfile_info(){
      $user_id=$this->session->userdata('user_id');

    //Connection establishment, processing of data and response from REST API
      $path=base_url();
      $url = $path.'api/Edit_profile_api/get_userProfile_info?user_id='.$user_id; 
      //echo $url;die();
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_HTTPGET, true);
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $response_json = curl_exec($ch);
      curl_close($ch);
      $response=json_decode($response_json, true);
      return $response; 
    }
// ---------------------function ends----------------------------------//


// -------------update profile details -------------------//
 public function get_allEditinfo()
 {
   $user_id=$this->session->userdata('user_id');
   $profile_type=$this->session->userdata('profile_type');

   extract($_POST);

   $data=$_POST;
   if($jm_profile_image_edit==''){
      $image_path='';
   }
   else{
      $image_path=$jm_profile_image_edit;      
   }
   
//print_r($data);die();
   if(!empty($_FILES['jm_profile_image']['name'])){

    $extension = pathinfo($_FILES['jm_profile_image']['name'], PATHINFO_EXTENSION);

    $_FILES['userFile']['name'] = '#User_0'.$user_id.'_#P'.$profile_type.'.'.$extension;
    $_FILES['userFile']['type'] = $_FILES['jm_profile_image']['type'];
    $_FILES['userFile']['tmp_name'] = $_FILES['jm_profile_image']['tmp_name'];
    $_FILES['userFile']['error'] = $_FILES['jm_profile_image']['error'];
    $_FILES['userFile']['size'] = $_FILES['jm_profile_image']['size'];
	  $uploadPath ='images/profile/profile_image';  //upload images in images/desktop/ folder
    $config['upload_path'] = $uploadPath;
    $config['allowed_types'] = 'gif|jpg|png|jpeg'; //allowed types of images           
    $config['overwrite'] = TRUE;            

    $this->load->library('upload', $config);  //load upload file config.
    $this->upload->initialize($config);

    if($this->upload->do_upload('userFile')){
      $fileData = $this->upload->data();
      $imagePath='images/profile/profile_image/'.$fileData['file_name'];
      $image_path= $imagePath;
    }
    else{
     $error = array('error' => '<h3>SERVER ERROR: </h3>'.$this->upload->display_errors());
     echo ($error['error']);
     die();  
   } 
 }

 $education = array();
 for($i=0;$i<count($course);$i++)
 {
  $edu = array(
    'jm_course' =>$course[$i],
    'jm_passing_year'=> $passing_year[$i],
    'jm_university' => $university[$i]
  );
  $education[]=$edu;
}

$experience = array();
for($i=0;$i<count($jm_previous_designation);$i++)
{
  $exp = array(
    'jm_designation'=>$jm_previous_designation[$i],
    'jm_worked_till'=>$jm_worked_till[$i],
    'jm_organisation'=>$jm_organisation[$i]
  );
  $experience[]=$exp;
}
//print_r($experience);die();
$a=array(

 'jm_user_id' =>$user_id,
 'jm_user_name' =>$jm_user_name.' '.$jm_user_last,
 'jm_userDesignation' =>$jm_userDesignation,
 'jm_userDescription' =>$jm_userDescription,
 'jm_userCity' =>$jm_userCity,
 'jm_userState' =>$user_state,
 'jm_userCountry' =>$user_country,
 'jm_education'  =>json_encode($education),
 'jm_experience' =>json_encode($experience),
 'jm_rateHr' =>$jm_rateHr,
 'jm_userAspiration' =>$jm_userAspiration,
 'expected_salary' =>$expected_salary,
 'file'	=> $image_path,
 'jm_linkedIn_url' =>$LinkedIn_url
);
$path=base_url();
$url = $path.'api/Edit_profile_api/get_allEditdetails';		
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, $a);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$response_json = curl_exec($ch);
curl_close($ch);
$response = json_decode($response_json, true); 
//print_r($response_json);die();
if($response['status']!='200'){
  echo '<h3 class="w3-text-red w3-margin"><i class="fa fa-warning"></i> '.$response['status_message'].'</h3><script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                //window.location.href="'.base_url().'jobseeker/jobseeker_lists";
                location.reload();
            }, 900);
            </script>';
}
else{
  echo '<h3 class="bluish-green w3-margin"><i class="fa fa-check"></i> '.$response['status_message'].'</h3><script>
            window.setTimeout(function() {
                $(".alert").fadeTo(500, 0).slideUp(500, function(){
                    $(this).remove(); 
                });
                //window.location.href="'.base_url().'jobseeker/jobseeker_lists";
                location.reload();
            }, 900);
            </script>';

}
}
// -----------------fucntion ends-----------------------//

}