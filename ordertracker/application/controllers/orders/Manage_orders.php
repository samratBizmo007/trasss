<?php
//error_reporting(E_ERROR | E_PARSE);

class Manage_orders extends CI_controller{

  public function __construct(){
    parent::__construct();
    

    //start session   
    $user_id=$this->session->userdata('user_id');
    $user_name=$this->session->userdata('user_name');
    
    //check session variable set or not, otherwise logout
    if(($user_id=='') || ($user_name=='')){
      redirect('login');
    }   
  }

  public function index(){
    $this->load->library('user_agent');
        //$data['orders'] = Manage_orders::getMyOrders();
        //print_r($data);//-------show all Raw prods
        $user_id = $this->session->userdata('user_id');

        $path = base_url();
        $url = $path . 'api/ManageOrder_api/numRows?user_id='.$user_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_data = curl_exec($ch);
        curl_close($ch);
        //----------pagination code starts here-------------------------------------
        //------loading the library pagination----------------------//
        $this->load->library('pagination');
        //--------------creating the config array for pagination basic requirements----------------//
        $config = [
            'base_url' => base_url('orders/Manage_orders/index'),
            'per_page' => 10,
            'total_rows' => json_decode($response_data, true),
        ];
        $config['full_tag_open'] = "<ul class='pagination' style='color:black'>";
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li style="color:black">';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active" style="background-color: #4CAF50;"><a href="#" style="color:white">';
        $config['cur_tag_close'] = '</a></li>';
        $config['prev_tag_open'] = '<li style="color:black">';
        $config['prev_tag_close'] = '</li>';
        $config['first_tag_open'] = '<li style="color:black">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open'] = '<li style="color:black">';
        $config['last_tag_close'] = '</li>';

        $config['prev_link'] = '<i class="fa fa-long-arrow-left" ></i> Previous';
        $config['prev_tag_open'] = '<li style="color:black">';
        $config['prev_tag_close'] = '</li>';

        $config['next_link'] = 'Next <i class="fa fa-long-arrow-right" ></i>';
        $config['next_tag_open'] = '<li style="color:black">';
        $config['next_tag_close'] = '</li>';
        //-----initialise pagination library with passing parameter config-----------//
        $this->pagination->initialize($config);
        //-----initialise pagination library with passing parameter config-----------//
        $data["links"] = $this->pagination->create_links();
        $path = base_url();
        $url = $path . 'api/ManageOrder_api/getMyOrders?user_id='.$user_id.'&per_page='.$config['per_page'].'&offset='.$this->uri->segment(4);
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $data['orders'] = json_decode($response_json, true);

        if ($this->agent->is_mobile()) {
            $this->load->view('includes/mobile/header');
            $this->load->view('pages/orders/mobile/manage_orders', $data);
            $this->load->view('includes/mobile/footer');
        } else {
            $this->load->view('includes/header');
            $this->load->view('pages/orders/manage_orders', $data);
        }
    }

 //----------this function to get all my orders details-----------------------------
 public function getMyOrders() {
  $user_id=$this->session->userdata('user_id');
  //$user_id=1;

  $path = base_url();
  $url = $path.'api/ManageOrder_api/getMyOrders?user_id='.$user_id;
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  return $response;
}
//----------------this fun get all my orders details end---------------//


 //----------this function to add order profile-----------------------------//
public function addOrder() { 
  extract($_POST);
  //print_r($_POST);die();
  //print_r($_FILES);die();

  if(!isset($prod_Name)){
   echo '<h4 class="w3-text-red w3-medium"><i class="fa fa-warning"></i> Add at least one product.</h4>';
   die();
 }
  if($business_field == 0){
   echo '<h4 class="w3-text-red w3-medium"><i class="fa fa-warning"></i> Select Business field first.</h4>';
   die();
 }
 $user_id=$this->session->userdata('user_id');
 $user_name=$this->session->userdata('user_name');
//print_r($_FILES['prod_image']['name'][1]);die();
  $prod_Arr=array();  //prod_image array
  $allowed_types=['gif','jpg','png','jpeg','JPG','GIF','JPEG','PNG'];
  
  for($i = 0; $i < count($_FILES['prod_image']['name']); $i++){
    if(!empty(($_FILES['prod_image']['name'][$i]))){
    $extension_prod = pathinfo($_FILES['prod_image']['name'][$i], PATHINFO_EXTENSION); //get prod image file extension 

    //image validating---------------------------//
    //check whether image size is less than 2 mb or not
    if($_FILES['prod_image']['size'][$i] > 2048576){  //for prod images
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> Image size for item '.$prod_Name[$i].' exceeds size limit of 2MB. Upload image having size less than 2MB</label>';
      die();
    }

    //check file is an image or not by checking extensions
    if(!in_array($extension_prod, $allowed_types)){  //for prod images
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> File uploading for prod '.$prod_Name[$i].' is not an image file. Upload image having type gif, jpg, jpeg OR png</label>';
      die();
    }   
  }
}
  //validating image ends---------------------------//

$id_count=1;
for($i = 0; $i < count($prod_Name); $i++){
  $imagePath ='';
  if(!empty(($_FILES['prod_image']['name'][$i]))){
    $extension = pathinfo($_FILES['prod_image']['name'][$i], PATHINFO_EXTENSION);

    $_FILES['userFile']['name'] = $prod_Name[$i].'_'.$user_id.'-'.$prod_quantity[$i].'.'.$extension;
    $_FILES['userFile']['type'] = $_FILES['prod_image']['type'][$i];
    $_FILES['userFile']['tmp_name'] = $_FILES['prod_image']['tmp_name'][$i];
    $_FILES['userFile']['error'] = $_FILES['prod_image']['error'][$i];
    $_FILES['userFile']['size'] = $_FILES['prod_image']['size'][$i];

      $uploadPath ='images/order_images/';  //upload images in images/desktop/ folder
      $config['upload_path'] = $uploadPath;
      $config['allowed_types'] = 'gif|jpg|png|jpeg'; //allowed types of images           
      $config['overwrite'] = TRUE;            
     // print_r($fileData = $this->upload->data());die();
      $this->load->library('upload', $config);  //load upload file config.
      $this->upload->initialize($config);

      if($this->upload->do_upload('userFile')){
        $fileData = $this->upload->data();
        $imagePath = $fileData['file_name'];
      }
    }

    $prod_Arr[]=array(
      'prod_no' => $id_count,
      'prod_Name' =>  $prod_Name[$i],
      'prod_quantity' =>  $prod_quantity[$i],
      'prod_image' => $imagePath,
      'prod_regret' =>  0
    );
    $id_count++;
  }

  $data['user_id']=$user_id;
  $data['business_field']=$business_field;
  $data['prod_associated']=json_encode($prod_Arr);
  //print_r($data);die();
  $path = base_url();
  $url = $path.'api/ManageOrder_api/addNewOrder';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  //print_r($response_json);die();
  
  if ($response['status'] != 200) {
    echo '<h4 class="w3-text-red w3-margin"><i class="fa fa-warning"></i> '.$response['status_message'].'</h4>
    <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
                //window.location.href="'.base_url().'project/project_listing";
    }, 1000);
    </script>';
  } else {
    echo '<h4 class="w3-text-green w3-margin"><i class="fa fa-check"></i> '.$response['status_message'].'</h4>
    <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
      window.location.href="'.base_url().'orders/manage_orders";
    }, 1000);
    </script>  ';
  }
}
//----------------this fun is to add order details end---------------//

//public function DeleteProfile(){
//  extract($_GET);
//  $path = base_url();
//  $url = $path . 'api/ManageProfile_api/DeleteProfile?profile_id='.$profile_id;
//  $ch = curl_init($url);
//  curl_setopt($ch, CURLOPT_HTTPGET, true);
//  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//  $response_json = curl_exec($ch);
//  curl_close($ch);
//  $response = json_decode($response_json, true);
//  redirect('inventory/AllProfiles');
//}
    //-------------this fun is used to update profile information-------------------------//


public function UpdateProfile(){
  extract($_POST); 
  $data = $_POST;
  
  $prod_Arr=array();  //prod_image array
  $allowed_types=['gif','jpg','png','jpeg','JPG','GIF','JPEG','PNG'];
  $extension_profile='';
  for($i = 0; $i < count($_FILES['prod_image']['name']); $i++){

    $extension_prod = pathinfo($_FILES['prod_image']['name'][$i], PATHINFO_EXTENSION); //get prod image file extension 
    $extension_profile = pathinfo($_FILES['profile_image']['name'], PATHINFO_EXTENSION); //get profile image file extension 

    //image validating---------------------------//
    //check whether image size is less than 1 mb or not
    if($_FILES['prod_image']['size'][$i] > 1048576){  //for prod images
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> Image size for prod '.$prod_Name[$i].' exceeds size limit of 1MB. Upload image having size less than 1MB</label>';
      die();
    }
    if($_FILES['profile_image']['size'] > 1048576){ //for profile image
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> Profile Image size exceeds size limit of 1MB. Upload image having size less than 1MB</label>';
      die();
    }

    //check file is an image or not by checking extensions
    if(!in_array($extension_prod, $allowed_types)){  //for prod images
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> File uploading for prod '.$prod_Name[$i].' is not an image file. Upload image having type gif, jpg, jpeg OR png</label>';
      die();
    }
    if(!in_array($extension_profile, $allowed_types)){  //for profile image
      echo '<label class="w3-small w3-label w3-text-red"><i class="fa fa-warning w3-xxlarge"></i> File uploading for profile '.$profile_name.' is not an image file. Upload image having type gif, jpg, jpeg OR png</label>';
      die();
    }
  }
  //validating image ends---------------------------//

  $imagePath ='';
  for($i = 0; $i < count($prod_Name); $i++){
    if(!empty($_FILES['prod_image']['name'])){
      $extension = pathinfo($_FILES['prod_image']['name'][$i], PATHINFO_EXTENSION);

      $_FILES['userFile']['name'] = $profile_name.'_'.$prod_Name[$i].'_'.$prod_Description[$i].'-'.$OD_quantity[$i].'.'.$extension;
      $_FILES['userFile']['type'] = $_FILES['prod_image']['type'][$i];
      $_FILES['userFile']['tmp_name'] = $_FILES['prod_image']['tmp_name'][$i];
      $_FILES['userFile']['error'] = $_FILES['prod_image']['error'][$i];
      $_FILES['userFile']['size'] = $_FILES['prod_image']['size'][$i];

      $uploadPath ='images/desktop/';  //upload images in images/desktop/ folder
      $config['upload_path'] = $uploadPath;
      $config['allowed_types'] = 'gif|jpg|png|jpeg'; //allowed types of images           
      $config['overwrite'] = TRUE;            

      $this->load->library('upload', $config);  //load upload file config.
      $this->upload->initialize($config);

      if($this->upload->do_upload('userFile')){
        $fileData = $this->upload->data();
        $imagePath='images/desktop/'.$fileData['file_name'];
      }
    }

    $prod_Arr[]=array(
      'prod_Name' =>  $prod_Name[$i],
      'prod_Description' =>  $prod_Description[$i],
      'prod_quantity' =>  $prod_quantity[$i],
      'prod_image' => $imagePath
    );
  }

  $data['prod_associated']=json_encode($prod_Arr);
  $data['profile_image']=($profileImg_path);
  
    //print_r($data);die();

  $path = base_url();                                                   // this code is for web service AND api for Update profile 
  $url = $path . 'api/ManageProfile_api/UpdateProfile';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
 //print_r($response_json);
  if ($response['status'] == 0) {
    echo '<div class="alert alert-danger">
    <strong>'.$response['status_message'].'</strong> 
    </div>
    <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
      location.reload();
    }, 1000);
    </script>';
  } else {
    echo '<div class="alert alert-success">
    <strong>'.$response['status_message'].'</strong> 
    </div>
    <script>
    window.setTimeout(function() {
      $(".alert").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove(); 
      });
      location.reload();
    }, 1000);
    </script>';
  }
}
     //-------------this fun is used to update profile information-------------------------//

// ---------------function to delete orders------------------------//
public function delOrder(){
  extract($_POST);

    //Connection establishment to get data from REST API
  $path=base_url();
  $url = $path.'api/ManageOrder_api/delOrder?order_id='.$order_id; 
    //echo $url;  
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response=json_decode($response_json, true);
  //print_r($response_json);die();
    //api processing ends

    //API processing end
  if($response['status']!=200){
    echo '<h4 class="w3-text-red w3-margin"><i class="fa fa-warning"></i> '.$response['status_message'].'</h4> 
    ';  
    
  }
  else{
    echo '<h4 class="w3-text-green w3-margin"><i class="fa fa-check"></i> '.$response['status_message'].'</h4>   
    ';        
    
  } 
  
}
// ---------------------function ends----------------------------------//

}