<?php error_reporting(E_ERROR | E_PARSE); ?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <title>Apply JOB</title>
        <!-- Bootstrap -->
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css">
        <link href="<?php echo base_url(); ?>css/freelancer.css" rel="stylesheet">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/normalize.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/stylesheet.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>dist/editor.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/alert/jquery-confirm.css">
        <link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>dist/bootstrap3-wysihtml5.min.css"></link>
        <link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">
        <script type="text/javascript" src="<?php echo base_url(); ?>css/js/const.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>css/js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>css/js/selectize.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>css/js/index.js"></script>
        <!---<script src="bootstrap/dist/js/bootstrap.min.js"></script>-->
        <script type="text/javascript" src="<?php echo base_url(); ?>css/alert/jquery-confirm.js"></script>
        <script type="text/javascript" src="<?php echo base_url(); ?>dist/editor.js"></script>
        <script src="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.js"></script>

        <style>
            .bluishGreen_bg{
                background-color:#00B59D;
                 font-size: 15px;
            }
            .button{
                background-color:#00B59D;
                 font-size: 15px;
            }
            #basic-addon{
                background-color:#00B59D;                
            }
            .inner-text-content{
                font-size: 12px;
                margin-top: 8px;
            }
            .page-title{
                font-size: 15px;
                color:#00B59D;
            }
            
        </style>
        <?php
        $job_id = '';
        $user_id = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('user_name');
        $company_name = '';
        $Postedby = '';
        $profile_type = '';
        $job_type = '';
        $job_name = '';
        $qualification = '';
        $responsibility = '';
        $skills = '';
        $address = '';
        $salary_range = '';
        $positions = '';
        $posted_time = '';
        $posted_date = '';
        $isActive = '';
        foreach ($jobDetails['status_message'] as $key) {
            $job_id = $key['jm_jobpost_id'];
            $Postedby = $key['jm_user_id'];
            $profile_type = $key['jm_profile_type'];
            $job_type = $key['jm_job_type'];
            $job_name = $key['jm_job_post_name'];
            $company_name = $key['jm_company_name'];
            $qualification = $key['jm_qualification'];
            $responsibility = $key['jm_responsibility'];
            $skills = $key['jm_skills'];
            $address = $key['jm_venue_address'];
            $salary_range = $key['jm_salary_range'];
            $positions = $key['jm_positions'];
            $posted_date = $key['jm_posted_date'];
            $posted_time = $key['jm_posted_time'];
            $isActive = $key['is_active'];
        }
        ?>
    </head>
<script>
// jQuery(document).ready(function($) {
//
//      if (window.history && window.history.pushState) {
//
//        $(window).on('popstate', function() {
//          var hashLocation = location.hash;
//          var hashSplit = hashLocation.split("#!/");
//          var hashName = hashSplit[1];
//
//          if (hashName !== '') {
//            var hash = window.location.hash;
//            if (hash === '') {
//              //alert('Back button was pressed.');
//                window.location='<?php echo base_url(); ?>jobseeker/Jobseeker_lists';
//                return false;
//            }
//          }
//        });
//
//        window.history.pushState('forward', null, './#forward');
//      }
//
//    });
</script>
    
    <body>
        <div class="w3-col l12 " style="padding-left:10px" >
            <a class="btn w3-round-jumbo w3-margin-top w3-text-black" title="Back To Job List" href="<?php echo base_url(); ?>jobseeker/Jobseeker_lists"><i class="fa fa-backward"> Back</i></a>            
        </div>
        <div class="container w3-margin-bottom w3-padding-bottom bind-main">

                    <div class="w3-margin-top w3-padding" id="JobList_Div">
                       
                            
                               
                                    <div class="w3-col l12 w3-margin-top ">
                                        <span class="w3-margin-right page-title" ><b><?php echo $job_name; ?></b></span>
                                    </div> 
                                
                                <div class="w3-col l12 inner-text-content w3-margin-top ">
                                        <span ><b><?php echo $company_name; ?></b></span>                                               
                                </div>
                                                        
                                                  
                              
                                    <div class="w3-col l6 inner-text-content">
                                        <span><b>Salary : &nbsp;&nbsp;&nbsp;</b><?php echo $salary_range; ?></span>
                                    </div>
                                    <div class="w3-col l6 inner-text-content">
                                        <span><b>Positions : &nbsp;&nbsp;&nbsp;</b><?php echo $positions; ?></span>
                                    </div>
                              
                               
                                    <div class="w3-col l6 inner-text-content">
                                        <span><b>Job Type :&nbsp;&nbsp;&nbsp;</b><?php echo $job_type; ?></span>
                                    </div>
                                    
                               
                        
                               
                                    
                                        <span class="inner-text-content"><b>Job Description :&nbsp;&nbsp;&nbsp;</b></span><br><br>
                                        <div class="w3-col l12 inner-text-content ">
                                            <p class="w3-left"><b>Responsibility:</b>&nbsp;&nbsp;<?php if($responsibility == ''){ echo 'Description Not Available'; }else{ echo $responsibility ;}?></p>                                            
                                        </div>
                                        <div class="w3-col l12 inner-text-content">
                                            <p class="w3-left"><b>Qualifications:</b>&nbsp;&nbsp;<?php if($qualification == ''){echo 'Description Not Available'; }else{ echo $qualification ;}?></p>
                                        </div>
                                        <div class="w3-col l12 inner-text-content">
                                            <p class="w3-left"><b>Date & Venue Address:</b>&nbsp;&nbsp;<?php if($address == ''){echo 'Description Not Available'; }else{ echo $address ;} ?></p>
                                        </div>
                                    
                        
                        <div class="inner-text-content">
                                <div class=" w3-col l12 " style="align-vertical:inline"  id="SkillId_<?php echo $job_id; ?>">
                                        <label style="margin-bottom:-5px"> Job Skills: </label>
                                </div>
                            </div>
                                       
                                    
                              
                          
                            <div class="w3-col l12 ">
                                <div class=" w3-col l6 w3-right" id="DisplayDiv" style=" display: none;">
                                   <span class="w3-right w3-medium w3-padding-small bluishGreen_bg w3-round-xxlarge w3-text-white">Already Applied!</span>
                                </div>
                                <div class="w3-col l6 w3-right" id="ApplyBtn">
                                    <a class="btn w3-right w3-medium w3-padding-small show_modal bluishGreen_bg w3-round-xxlarge w3-text-white" title="Add Details" data-toggle="modal" data-target="#Add_detailsModal">Apply</a>
                                </div> 
                                <div class="w3-col l6 inner-text-content w3-left">
                                        <span class="w3-left" style="font-size:9px"><b>Posted Date : &nbsp;&nbsp;&nbsp;</b><?php echo $posted_date; ?></span>
                                    </div>
                            </div>
                       
                        <!-------------------------------------------- div for project description------------------------------------------------>                       
                   
                </div>
            
        </div>
        <script>
            $(document).ready(function () {
                checkAlreadyApplied('<?php echo $job_id; ?>','<?php echo $user_id ;?>');
            });
        </script>
        <!-- Modal -->
        <div class="modal fade" id="Add_detailsModal">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="w3-padding bluishGreen_bg w3-text-white">
                        
                        <button type="button" class="close"  data-dismiss="modal" aria-label="Close">      
                            <span class="w3-xxlarge" aria-hidden="true">&times;</span>
                        </button>
                        <h4 class=" w3-text-white" id="exampleModalLabel">Add Details</h4>
                    </div>
                    <form id="Application_form" name="Application_form">
                        <div class="modal-body ">
                            <input type="hidden" name="user_id" id="user_id" value="<?php echo $user_id; ?>">
                            <input type="hidden" name="job_id" id="user_id" value="<?php echo $job_id; ?>">
                            <input type="hidden" name="user_name" id="user_name" value="<?php echo $user_name; ?>">                     <div class="w3-padding-left">    
                            <div class="row w3-col l12 ">
                                <div class="w3-col l5 w3-left">
                                    <label>Candidate Name :</label>
                                    <input  type="text" name="candidate_name" id="candidate_name" class="form-control" placeholder="Candidate Name..." required>
                                </div>
                                <div class="w3-col l5 w3-right ">
                                    <label>Candidate Email :</label>
                                    <input  type="email" name="Email_id" id="Email_id" class="form-control" placeholder="Email..." required>
                                </div>
                            </div>
                            <div class="row w3-col l12 ">
                                <div class="w3-col l5 w3-left">
                                    <label>Contact No(optional) :</label>
                                    <input type="number" name="contact_no" id="contact_no" class="form-control" placeholder="Contact Number">
                                </div>
                                <div class="w3-col l5 w3-right ">
                                    <label>Message(optional) :</label>
                                    <textarea id="message" name="message" class="form-control" rows="5 " cols="70" placeholder="Tell them something about yourself..." style=" resize: none;"></textarea> 
                                    <span class="help-block"></span> 
                                </div>
                            </div>
                            <div class="row w3-col l12 w3-padding-bottom  w3-margin-bottom ">
                                <div class="w3-col l8">
                                    <label>Attach Resume</label>
                                    <div class="w3-padding" style="border: 0.5px dashed;">
                                        <input type="file" class="" id="resume" name="resume" required/> 
                                    </div>
                                </div>
                            </div>
                        </div><br>
                        <div class="modal-footer" style="border:none">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn bluishGreen_bg w3-text-white">Apply</button>
                        </div>
                    </div>   
                    </form>
                </div>
            </div>
        </div>
    </body>
    <script>
        $(document).ready(function () {
            FetchSkills('<?php echo $job_id; ?>', '<?php echo $skills; ?>');
        });
    </script>
    <script>
        function checkAlreadyApplied(job_id,user_id){
           $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>jobseeker/Job_applications/checkAlreadyApplied",
                dataType: 'text',
                data: {
                    job_id: job_id,
                    user_id: user_id
                },
                cache: false,
                success: function (data) {
                    //alert(data);
                   if(data == 'TRUE'){
                       $('#ApplyBtn').css("display","none");
                       $('#DisplayDiv').css("display","block");
                   }else{
                       $('#ApplyBtn').css("display","block");
                       $('#DisplayDiv').css("display","none");
                   }
                 }
                });
        }
        function FetchSkills(job_id, Skills) {
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>job/Job_listings/FetchSkills",
                dataType: 'text',
                data: {
                    job_id: job_id,
                    Skills: Skills
                },
                cache: false,
                success: function (data) {
                    var key = JSON.parse(data);
                    //alert(key);
                    for (i = 0; i < key.length; i++) {
                        //$.alert(key[i].jm_skill_name);
                        $('#SkillId_' + job_id).append('<span w3-padding><span  class="w3-padding-small w3-margin-right w3-round-xxlarge  w3-text-white" style="display:inline-block;background-color:#787878;font-size:8px;">' + key[i].jm_skill_name + '</span></span>');
                    }
                }
            });
        }
    </script>

    <script>
        //-----this script is used to save the bidding and upload file for project cover letter-----------------// 
        $(function () {
            $("#Application_form").submit(function (e) {
                e.preventDefault();
                dataString = $("#Application_form").serialize();
                $.ajax({
                    type: "POST",
                    url: BASE_URL + "jobseeker/Job_applications/saveApplication",
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    // return: false, //stop the actual form post !important!
                    success: function (data)
                    {
                        $.alert(data);
                        //location.reload();
                    }
                });
                return false;  //stop the actual form post !important!
            });
        });
        //-----this script is used to save the bidding and upload file for project cover letter-----------------//
    </script>
    <script>
        $('#Add_detailsModal').on('hidden.bs.modal', function () {
            location.reload();
        });
    </script>