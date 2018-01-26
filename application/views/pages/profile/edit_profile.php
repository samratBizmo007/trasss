<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
error_reporting(E_ERROR | E_PARSE);
$user_id=$this->session->userdata('user_id');
$user_name=$this->session->userdata('user_name');
$selected_profile_type=$this->session->userdata('selected_profile_type');
$profile_type=$this->session->userdata('profile_type');

if(($this->session->userdata('selected_profile_type'))==''){
  $selected_profile_type=$profile_type;
}
$profile_value='';
switch ($selected_profile_type) {
      //-------------case Freelancer  ----------------//    
  case '1':
  $profile_value='Freelancer' ;   
  break;

      //-------------case Freelancer Employer----------------//
  case '2':
  $profile_value='Freelancer Employer';    
  break;

      //-------------case Job Seeker----------------//
  case '3':
  $profile_value='Job Seeker' ;   
  break;

      //-------------case Job Employer----------------//
  case '4':
  $profile_value='Job Employer' ;   
  break;    
}    
?>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Profile</title>
  <!-- Bootstrap -->  
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/normalize.css">
  <!--  <link rel="stylesheet" href="<?php echo base_url(); ?>css/stylesheet.css">-->
  <link rel="stylesheet" href="<?php echo base_url(); ?>dist/editor.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/view_profile.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>css/alert/jquery-confirm.css">

  <link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/site.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/richtext.min.css">
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/jquery.min.js"></script>

  <script src="<?php echo base_url(); ?>css/js/jquery.richtext.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/const.js"></script>
    <script type="text/javascript" src="<?php echo base_url(); ?>css/alert/jquery-confirm.js"></script>

  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/profile/edit_profile.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/selectize.js"></script>
  <!-- <script type="text/javascript" src="<?php echo base_url();?>dist/editor.js"></script> -->
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/country2.js"></script>


 

  <style>
  .scrolly::-webkit-scrollbar
  {
    width: 4px;  
  }
  .scrolly::-webkit-scrollbar-track
  {
    background-color: #00B59D;

  }
  .scrolly::-webkit-scrollbar-thumb
  {
    background: rgba(0, 0, 0, 0.5);
  }
</style>
</head>
<body>
  <div class="container" >

    <?php
    //print_r($all_userProfile_info);
    foreach ($all_userProfile_info['status_message'] as $key) {
      $name=$key['jm_user_name'];
      $nameArr=explode(' ',$name);
      $fname=$nameArr[0];
      $lname=$nameArr[1];
      $prof_image=$key['jm_profile_image'];
      $jm_userDesignation=$key['jm_userDesignation'];
      $jm_linkedIn_url=$key['jm_linkedIn_url'];
      $jm_userCity=$key['jm_userCity'];
      $jm_userState=$key['jm_userState'];
      $jm_userCountry=$key['jm_userCountry'];
      $jm_userDescription=$key['jm_userDescription'];
      $jm_ratePerHr=$key['jm_ratePerHr'];
      $expected_salary=$key['expected_salary'];
      $jm_userAspiration=$key['jm_userAspiration'];
      $jm_education=$key['jm_education'];
      $jm_experience=$key['jm_experience'];
    }

    ?>
    <!-- div for about details of user and it's score row -->
    <?php 
    $hide_fullDiv="";
    $hide_rateDiv="";
    $hide_extraDiv="";
    switch ($selected_profile_type) {
      //-------------case Freelancer  ----------------//    
      case '1':
  //$hide_fullDiv="w3-hide";
      $hide_extraDiv="w3-hide";
      break;

      //-------------case Freelancer Employer----------------//
      case '2':
  //$hide_fullDiv="w3-hide";
      $hide_rateDiv="w3-hide"; 
      $hide_extraDiv="w3-hide";   
      break;

      //-------------case Job Seeker----------------//
      case '3':
      $hide_rateDiv="w3-hide";
      $hide_fullDiv="w3-hide";
  //$hide_rateDiv="w3-hide";
      break;

      //-------------case Job Employer----------------//
      case '4':
  // $hide_fullDiv="w3-hide";
  // $hide_rateDiv="w3-hide"; 
      $hide_extraDiv="w3-hide"; 
      break;
    }
    ?>
    <div class="col-lg-2"></div>
    <div class="w3-col l8">
     <form class="form-horizontal" id="Edit_profile" name="Edit_profile" role="form" enctype="multipart/form-data">
      <div class="w3-col l12">
        <div class="w3-col l8 ">
         <h2 class="bluishGreen_txt"><b>Edit Profile</b></h2>
         <hr>
       </div>
       <div class="w3-col l4 w3-padding">
        <div class="text-center profile_portfolio ">
          <img class="img img-thumbnail" alt="Profile Image not found" style="height: 100%; width: 100%; object-fit:contain; " align="right" src="<?php echo base_url().$prof_image; ?>" id="profile_imagePreview" onerror="this.src='<?php echo base_url()?>css/logos/default_noimage.jpg'">
          <div class="w3-col l12 ">
            <h6>Upload a profile photo</h6>
            <input type="file" class="w3-input" name="jm_profile_image" id="jm_profile_image">
            <input type="hidden" class="w3-input" name="jm_profile_image_edit" id="jm_profile_image_edit" value="<?php echo $key['jm_profile_image']; ?>">
          </div>
        </div>
      </div>
    </div>

    <div class ="w3-col l12" id="full_name">
      <h5 class="w3-col l12 w3-padding-tiny w3-text-black  w3-round w3-margin-bottom" style="padding-left:20px;"><b>Personal Details:</b></h5>
      <div class="w3-col l6 w3-padding">
        <label class="control-label ">First name:</label>
        <span class="w3-text-red">*</span>
        <input class="w3-input" type="text" name="jm_user_name" value="<?php echo $fname; ?>" placeholder="Name" required>
      </div> 
      <div class="w3-col l6 w3-padding">
        <label class="control-label">Last name:</label>
        <span class="w3-text-red">*</span>
        <input class="w3-input" type="text" name="jm_user_last" value="<?php echo $lname; ?>" placeholder="Surname" required>
      </div>
    </div>

    <div class="w3-col l12" id="designation">
      <div class="w3-col l6 w3-padding">
        <label class="control-label">Designation:</label>
        <span class="w3-text-red">*</span>
        <input class="w3-input" type="text" name="jm_userDesignation" value="<?php echo $jm_userDesignation; ?>" placeholder="Php Developer" required>
      </div>

      <div class="w3-col l6 w3-padding">
        <label class="control-label">Rate/Hour:</label>
        <input class="w3-input" type="number" placeholder="Rate/Hour" name="jm_rateHr" value="<?php echo $jm_ratePerHr; ?>">
      </div>
    </div>

    <div class="w3-col l12 scrolly" id="user_description" style="padding-right: 5px;max-height: 350px;overflow: scroll;">
     <label class="control-label">Description:</label>
     <textarea id="txtEditor-new" name="jm_userDescription" class="content" rows="7" placeholder="Describe you here..." ><?php echo $jm_userDescription; ?></textarea> 
     <span class="help-block"></span>
   </div>

   <div class="w3-col l12 w3-margin-top" id="location">
    <div class="col-lg-4">
      <label class="control-label">Country:</label>
      <span class="w3-text-red">*</span>
      <!--         	<span id = "countrydata" name = "countrydata" style = "color:red; display: block;">&nbsp;</span>-->
      <select class="w3-input"  id="user_country" name="user_country"  onchange="print_state('user_state', this.selectedIndex);" required>
        <option value="<?php echo $jm_userCountry ?>" <?php if($jm_userCountry == 'Angola'){echo'selected=selected';} ?>><?php echo $jm_userCountry ?></option>
      </select>
    </div>

    <div class="col-lg-4">
      <label class="control-label">State:</label>
      <span class="w3-text-red">*</span>
      <!--         	<span id = "statedata" name = "statedata" style = "color:red; display: block;">&nbsp;</span>-->
      <select class="w3-input" name="user_state" id="user_state" required></select>
    </div>

    <div class="col-lg-4">
     <label class="control-label">City:</label>
     <span class="w3-text-red">*</span>
     <input class="w3-input" type="text" placeholder="Enter your city" name="jm_userCity" value="<?php echo $jm_userCity; ?>" required>
   </div>
 </div>

 <div class="w3-col l12 w3-margin-top">
   <h5 class="w3-col l12 w3-text-black w3-round w3-padding-top"><b>Job Seeker Miscellaneous Details:</b></h5>
 </div>

 <div class="w3-col l12 scrolly" id="user_aspiration" style="padding-right: 5px;max-height: 350px;overflow: scroll;">
   <label class=" control-label">Job Seeker's Aspiration:</label>
   <textarea id="jm_userAspiration" name="jm_userAspiration" class="content" rows="7" placeholder="Describe you details here..." ><?php echo $jm_userAspiration; ?></textarea>                 

   <span class="help-block"></span>
 </div>
 <div class="w3-col l12 w3-margin-top">
  <div class="col-lg-6">
    <label class="control-label">Expected Salary:</label>

    <select class="w3-input" id="expected_salary" name="expected_salary" selected>
      <option value="0">Select Salary</option>
      <option value="0-1 LPA" <?php if($expected_salary=='0-1 LPA'){ echo 'selected'; } ?>>0-1 LPA</option>
      <option value="1-2 LPA" <?php if($expected_salary=='1-2 LPA'){ echo 'selected'; } ?>>1-2 LPA</option>
      <option value="2-3 LPA" <?php if($expected_salary=='2-3 LPA'){ echo 'selected'; } ?>>2-3 LPA</option>
      <option value="3-4 LPA" <?php if($expected_salary=='3-4 LPA'){ echo 'selected'; } ?>>3-4 LPA</option>
      <option value="4-5 LPA" <?php if($expected_salary=='4-5 LPA'){ echo 'selected'; } ?>>4-5 LPA</option>
      <option value="More Than 5 LPA">More Than 5 LPA</option>
    </select>
  </div>

  <div class="col-lg-6">
    <label class="control-label">LinkedIn URL:</label>
    <input class="w3-input"  type="text" name="LinkedIn_url" placeholder="Add URL here..." value="<?php echo $jm_linkedIn_url; ?>">
  </div>
</div>

<div class ="w3-col l12 w3-margin-top">
  <h5 class="w3-col l12 w3-padding-tiny w3-text-black w3-round w3-margin-top"><b>Educational Details:</b></h5>
  <?php 
  $count=0;
  if($jm_education==''){?>
  <div class="w3-col l12">
    <div class="col-lg-4">
      <label class="control-label">Course :</label>
      <span class="w3-text-red">*</span>
      <input class="w3-input"  type="text" name="course[]" placeholder="BE IT" value="<?php echo $edu['jm_course']; ?>">
    </div>

    <div class="col-lg-4">
      <label class="control-label">Passing Year :</label>
      <span class="w3-text-red">*</span>
      <input class="w3-input" type="number" name="passing_year[]"  placeholder="2018" value="<?php echo $edu['jm_passing_year']; ?>" style="">
    </div>

    <div class="col-lg-4">
      <label class="control-label">University :</label>
      <span class="w3-text-red">*</span>
      <input class="w3-input" type="text" name="university[]" placeholder="university name" value="<?php echo $edu['jm_university']; ?>">
    </div>
  </div> 
  <?php } 
  else {
    foreach (json_decode($jm_education,TRUE) as $edu) {
      $hide='';
      if($count==0){
        $hide='w3-hide';
      }
      ?>
      <div class="w3-col l12">
        <div class="col-lg-4">
          <label class="control-label">Course :</label>
          <span class="w3-text-red">*</span>
          <input class="w3-input"  type="text" name="course[]" placeholder="BE IT" value="<?php echo $edu['jm_course']; ?>">
        </div>

        <div class="col-lg-4">
          <label class="control-label">Passing Year :</label>
          <span class="w3-text-red">*</span>
          <input class="w3-input" type="number" name="passing_year[]"  placeholder="2018" value="<?php echo $edu['jm_passing_year']; ?>" style="">
        </div>

        <div class="col-lg-4">
          <label class="control-label">University :</label>
          <span class="w3-text-red">*</span>
          <input class="w3-input" type="text" name="university[]" placeholder="university name" value="<?php echo $edu['jm_university']; ?>">
        </div>
      </div> 
      <?php 
      $count++;
    } }
    ?>
    <div id="more_education" class=""></div>
    <span><a  id="add_more" class="btn add_moreMaterial w3-small bluish-green w3-right">Add more <i class="fa fa-plus"></i></a></span>
  </div>

  <div class ="w3-col l12">
    <h5 class="w3-col l12  w3-padding-tiny w3-text-black w3-round " style="padding-left:1px;"><b>Work Experience Details:</b></h5>
    <?php 
    $count=0; 
    if($jm_experience==''){?>
    <div class="w3-col l12">
     <div class="col-lg-4">
      <label class="control-label">Previous designation :</label>
      <input class="w3-input"  type="text" name="jm_previous_designation[]" placeholder="UI Designer" value="<?php echo $exp['jm_designation']; ?>">
    </div>

    <div class="col-lg-4 ">
      <label class="control-label">Worked-till :</label>
      <input class="w3-input" type="date" name="jm_worked_till[]" value="<?php echo $exp['jm_worked_till']; ?>" style="padding:0px">
    </div>

    <div class="col-lg-4 ">
     <label class="control-label">Organisation :</label>
     <input class="w3-input" type="text" name="jm_organisation[]" placeholder="company name " value="<?php echo $exp['jm_organisation']; ?>">
   </div>     
 </div>
 <?php 
}
else {
  foreach (json_decode($jm_experience,TRUE) as $exp) {
    $hide='';
    if($count==0){
      $hide='w3-hide';
    }
    ?>
    <div class="w3-col l12">
     <div class="col-lg-4">
      <label class="control-label">Previous designation :</label>
      <input class="w3-input"  type="text" name="jm_previous_designation[]" placeholder="UI Designer" value="<?php echo $exp['jm_designation']; ?>">
    </div>

    <div class="col-lg-4 ">
      <label class="control-label">Worked-till :</label>
      <input class="w3-input" type="date" name="jm_worked_till[]" value="<?php echo $exp['jm_worked_till']; ?>" style="padding:0px">
    </div>

    <div class="col-lg-4 ">
     <label class="control-label">Organisation :</label>
     <input class="w3-input" type="text" name="jm_organisation[]" placeholder="company name " value="<?php echo $exp['jm_organisation']; ?>">
   </div>     
 </div>
 <?php 
}
$count++;
} ?>
<div id="more_experiance" class=""></div>
<span><a  id="add_more_experiance" class="btn add_moreMaterial w3-small bluish-green w3-right">Add more <i class="fa fa-plus"></i></a></span>
</div>  

<div class="form-group w3-margin-top w3-margin-bottom">
  <div class="w3-col l12 w3-center">
    <input type="submit" class="btn btn-lg w3-text-white bluishGreen_bg" value="Save Changes">
    <span></span>
    <input type="reset" class="btn btn-lg" value="Reset">
  </div>
</div>
</form>
</div>
<div class="col-lg-2"></div>
</div>

<script type="text/javascript">
  $(function () {
  $("#Edit_profile").submit(function (e) {
    e.preventDefault();
    dataString = $("#Edit_profile").serialize();
    //alert(dataString);
   // return false;
    $.ajax({
      type: "POST",
      url: BASE_URL + "profile/Edit_profile/get_allEditinfo",
      data:  new FormData(this),
      contentType: false,
      cache: false,
      processData:false,
      success: function (data)
      {        
       $.alert(data);
      }
    });
    return false;  
  });
});
</script>  
 <script>
    $(document).ready(function () {
      print_country("user_country");
    });
  </script>
  <script>
    $(document).ready(function() {
      $('#txtEditor-new').richText();
      $('#jm_userAspiration').richText();
    });
  </script>
</body>