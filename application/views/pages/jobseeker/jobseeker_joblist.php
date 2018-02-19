<?php
defined('BASEPATH') OR exit('No direct script access allowed');
//error_reporting(E_ERROR | E_PARSE);
$user_id = $this->session->userdata('user_id');
//echo $user_id;
$user_name = $this->session->userdata('user_name');
$profile_type = $this->session->userdata('profile_type');
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Job List</title>
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.min.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css"> -->
  <link href="<?php echo base_url(); ?>css/bootstrap/bootstrap-toggle.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/alert/jquery-confirm.css">
  <!-- <link rel="stylesheet" href="<?php echo base_url(); ?>css/style.css"> -->
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">
  <link rel="stylesheet" href="<?php echo base_url(); ?>css/joblisting.css">

  <script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap/jquery-3.1.1.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/bootstrap/bootstrap.min.js"></script>
  <script src="<?php echo base_url(); ?>css/bootstrap/bootstrap-toggle.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/alert/jquery-confirm.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/const.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/loadingoverlay.min.js"></script>
  <script type="text/javascript" src="<?php echo base_url(); ?>css/js/loadingoverlay_progress.min.js"></script>
  <style>
  .bluishGreen_bg{
    background-color:#00B59D;
    color: #ffffff;
  }
  .bluishGreen_txt{
    color:#00B59D;
  }
  .button{
    background-color:#00B59D;
  }
  #basic-addon{
    background-color:#00B59D;                
  }

</style>
<style>
.pagination {
  display: inline-block;
}

.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  border: 1px solid #ddd;
}

.pagination a.active {
  background-color: #4CAF50;
  color: white;
  border: 1px solid #4CAF50;
}

.pagination a:hover:not(.active) {background-color: #ddd;}
</style>
</head>
<body>

  <div class="container search_main">
    <div class="col-md-12">
      <div class="col-md-2">

      </div>
      <div class="col-md-8">

        <div class="row">
          <form class="form-group">
            <div class="search">
              <span class="fa fa-search"></span>
              <input placeholder="Search jobs by profile..." id="strsearch" onclick="this.select();" class="search_input form-control" name="search">
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>

  <hr>
  <div class="container w3-margin-bottom">
    <div class="">
      <label><h2 class="" style=" color: #00B59D; font-size: 20px;">Job List</h2></label>
    </div>

    <div class=" w3-border w3-col l10" id="Job_ListDiv">

      <!-- -------------------Div to bind for project Description------------------------------>                    
      <?php
        //$user_id = $this->session->userdata('user_id');
        //$user_name = $this->session->userdata('user_name');
        //print_r($job_bookmarks);die();
        //echo $user_id;die();
        $K = 0;
$Bookmark_jobs = array();
if ($job_bookmarks['status'] == 200) {
    $Bookmark_jobs = json_decode($job_bookmarks['status_message'][0]['jm_job_bookmarks'], TRUE);
}
//echo $Bookmark_jobs;die();
if ($jobs['status'] == 200) {

    foreach ($jobs['status_message'] as $key) {
        $class = "fa-bookmark-o";
        $title = "Add Bookmark";
        if ($Bookmark_jobs) {
            if (in_array($key['job_id'], $Bookmark_jobs)) {

                $class = "fa-bookmark";
                $title = "Bookmarked";
            }
        }
        ?>
        <?php
        $apply_link = base_url() . 'jobseeker/jobseeker_lists/' . $key['job_id'];
        if ($user_id == '' || $profile_type == '') {
            $apply_link = base_url() . 'auth/login?profile=3&payload=ApplyJob&value=' . base64_encode($key['job_id']);
        }
        ?>
          <div class="w3-col l12 w3-border-bottom" id="JobList_Div">
            <!-- div for project description-->
            <div class="row w3-padding ">
              <div class="w3-col l12 w3-padding-left">
                <div class="row w3-col l12">
                  <div class="w3-col l11 s11 m11">
                      <a href="<?php echo $apply_link;?>"><span class="bluishGreen_txt w3-padding-left w3-margin-right" style=" font-size: 25px;"><b><?php echo $key['job_name']?></b></span></a>
                  </div> 
                  <div class="w3-col l1 s1 m1 w3-right w3-medium">
                      <a class="w3-right w3-padding-left" data-toggle="fa" onclick="add_bookmarkForJob('<?php echo $user_id; ?>','<?php echo $key['job_id']; ?>')" title="<?php echo $title; ?>">
                      <i id="job_<?php echo $key['job_id']; ?>" class="fa <?php echo $class; ?>" style="font-size:25px; color: black;">                                                       
                      </i>
                    </a>
                  </div>  
                </div>

                <div class="row w3-col l12 w3-padding-left">
                  <div class="w3-col l6 w3-padding-bottom w3-medium">
                      <span><b><?php echo $key['company_name']; ?></b></span>
                  </div>                                                                                               
                </div>

                <div class="row w3-col l12 w3-padding-left">
                  <div class="w3-col l3 w3-padding-bottom w3-medium">
                      <i class="fa fa-rupee w3-text-grey" style="font-size:15px;"></i><span> <?php echo $key['Salary_range']; ?> </span>
                  </div>
                  <div class="w3-col l3 w3-padding-bottom w3-medium">
                      <i class="fa fa-user w3-text-grey" style="font-size:15px;"></i><span> <?php echo $key['positions']; ?></span>
                  </div>
                  <div class="w3-col l3 w3-padding-bottom w3-medium">
                      <i class="fa fa-briefcase w3-text-grey" style="font-size:15px;"></i><span> <?php echo $key['job_type']; ?></span>       
                  </div>
                  <div class="w3-col l3 w3-padding-bottom w3-medium">
                      <i class="fa fa-map-marker w3-text-grey" style="font-size:15px;"></i><span> <?php echo $key['city']; ?></span>       
                  </div>
                </div>

                  <!-- ====================================SKILLS DIV=============================================                               -->
                  <div class="row w3-col l12 m12 s12 w3-padding-left" style="overflow-wrap:break-word;">                     
                    <div class="w3-medium w3-col l12 s12 m12" id="SkillId_<?php echo $key['job_id'];?>">
                        <label>Skills : </label>
                    </div>
                  </div>  
                  <!-- ====================================APPLY JOB BUTTON=============================================                               -->   
                <div class="row w3-col l12 w3-padding-left w3-medium">                                               
                  <div class="w3-col l12 s12 m12">
                    <a title="Apply To This Job" class="w3-right w3-round-xxlarge w3-padding-small btn w3-text-white" data-toggle="tooltip" style="background-color: black; font-size:10px" href="<?php echo $apply_link;?>">Apply Now</a>                                                                   
                  </div>
                </div>

              </div>
            </div>
            <!-- div for project description-->                       
          </div>
          <script>
         $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip(); 
            $('[data-toggle="fa"]').tooltip();
        });
            $(document).ready(function () {
             FetchSkills('<?php echo $key['job_id'];?>','<?php echo $key['skills'];?>');
           });
         </script>
         <?php 
       }

     }else{     
      ?>
      <div class="w3-margin-top w3-margin-bottom w3-padding w3-center" id="elseDiv">
        <span class="alert alert-success  w3-center bluishGreen_bg w3-round-xxlarge" style="text-align: center;">No records Found.</span>
      </div>
      <?php }?>
      <!---------------------/div bind for project description-------------------------->
    </div>
    <div class="pagination">
     <?php echo $links; ?>
<!--  		  <a href="#">&laquo;</a>
  	 	  <a href="#">1</a>
		  <a href="#" class="">2</a>
		  <a href="#">3</a>
		  <a href="#">4</a>
		  <a href="#">5</a>
		  <a href="#">6</a>
		  <a href="#">&raquo;</a>-->
   </div>
 </div>

 <!---------------------/div bind for project description-------------------------->

</body>
</html>
<script>
  function CloseJob(job_id){
    $.confirm({
      title: '<label class="w3-large w3-text-red"><i class="fa fa-envelope"></i> Delete Job.</label>',
      content: '<span class="w3-medium">Do You really want to delete this Job?</span>',
      buttons: {
        confirm: function () {
          $.ajax({
            type:'get',
            url:BASE_URL+'job/Job_listings/CloseJob?job_id='+job_id,                                    
            success:function(data) {
              $.alert(data);              
              $("#JobList_Div").load(location.href + " #JobList_Div>*", "");
              $("#elseDiv").load(location.href + "elseDiv>*", "")
              location.reload();
            }
          });
        },
        cancel: function () {}
      }
    });
  }    
  function FetchSkills(job_id,Skills){
   $('#SkillId_'+job_id).append('<i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');       
	  $.ajax({
      type: "POST",
      url: "<?php echo base_url(); ?>job/Job_listings/FetchSkills",
      dataType: 'text',
      data: {
        job_id: job_id,
        Skills: Skills
      },
      cache: false,
      success: function(data) {
                          //$.alert(data);
   $('#SkillId_'+job_id).html('');       
        var key=JSON.parse(data);
                //$.alert(key);
                for(i=0; i< key.length; i++){
                    //$.alert(key[i].jm_skill_name);
                    $('#SkillId_'+job_id).append('<span w3-padding><span  class="w3-padding-small w3-light-grey w3-round" style="display:inline-block; margin-top:5px; margin-right: 5px; font-size:10px;">'+key[i].jm_skill_name+'</span></span>');
                  }
                }
              });
  }

  // -----------------fucntion add bookmark-------------
  function add_bookmarkForJob(user_id,job_id){
    var uri=BASE_URL+"jobseeker/Jobseeker_lists/add_bookmarkForJob";
    if($('#job_'+job_id).hasClass('fa-bookmark')){
     uri=BASE_URL+"jobseeker/Jobseeker_lists/del_bookmarkForJob";
   }
   dataString='user_id='+user_id+'&job_id='+job_id;
   $.LoadingOverlay("show");

   $.ajax({
     type: "POST",
     url: uri,
     data: dataString,
     return: false,  
     success: function(data)
     {	
      $.LoadingOverlay("hide");
      $('#bookmark_msg').html(data); 
      location.reload(); 

    }
  });	
 }
//----------------------function ends-----------------//
</script>
<script>
  $(document).ready(function() {
    var panels = $('.user-infos');
    var panelsButton = $('.dropdown-user');
    panels.hide();

    //Click dropdown
    panelsButton.click(function() {
        //get data-for attribute
        var dataFor = $(this).attr('data-for');
        var idFor = $(dataFor);

        //current button
        var currentButton = $(this);
        idFor.slideToggle(400, function() {
            //Completed slidetoggle
            if(idFor.is(':visible'))
            {
              currentButton.html('<i class="fa fa-chevron-circle-up w3-xlarge" title="Hide" style="color: #1fbea9"></i>');
            }
            else
            {
              currentButton.html('<i class="fa fa-chevron-circle-down w3-xlarge" title="Expand" style="color: #1fbea9"></i>');
            }
          })
      });


    $('[data-toggle="tooltip"]').tooltip();

    $('button').click(function(e) {
      e.preventDefault();
      // alert("This is a demo.\n :-)");
    });

    var timeout = null;
    $('input[name="search"]').on('keyup',function(event){
      //alert("sujeet");
      event.preventDefault();
      var str = $('#strsearch').val();
      if (timeout) {  
        clearTimeout(timeout);
      }
    //alert(str);
    if(str.length != 1 || event.keyCode != 32){
      timeout = setTimeout(function(){
        $.ajax({
          url :BASE_URL+'job/post_jobs/filterJobs',
          type : 'POST',
          dataType : 'text',
          data : {
            'fileds' : {
              'jm_job_city' : str+'/LIKE',
              'jm_job_post_name' : str+'/LIKE'
            },
            'order' : {
              'field' : '',
              'order' : '',
            },
            'table' : {
              'table' : 'jm_post_job',
            },
            'mode' : {
              'mode' : 'job_list',
            }
          },
        }).
        done(function(data){
          console.log(data);
          $('#Job_ListDiv').html(data);
        });//end of ajax
      },1000);//end of timeout function
    }else{
      $('#err-msg').text("No content for search");
      $('.do-err').fadeIn("slow");
      $(".do-err").delay(1000).fadeOut();
    }
  });
  });

</script>