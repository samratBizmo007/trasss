<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
error_reporting(E_ERROR | E_PARSE);
$user_id=$this->session->userdata('user_id');
$selected_profile_type=$this->session->userdata('selected_profile_type');
$profile_type=$this->session->userdata('profile_type');

if(($this->session->userdata('selected_profile_type'))==''){
  $selected_profile_type=$profile_type;
}
//echo 'sujeet';
//echo '<pre>';print_r($info);exit;
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
$search_cat=$this->input->get('search_param', TRUE);
?>
<!DOCTYPE html>
<html>
<head>
  <style type="text/css">
  //Reusing bootstrap 3 panel CSS
  .panel {
    background-color: #FFFFFF;
    border: 1px solid rgba(0, 0, 0, 0);
    border-radius: 4px 4px 4px 4px;
    box-shadow: 0 1px 1px rgba(0, 0, 0, 0.05);
    margin-bottom: 20px;
  }   

  .panel-primary {
    border-color: #1fbea9;
  }   

  .panel-primary > .panel-heading {
    background-color: #1fbea9;
    border-color: #1fbea9;
    color: #FFFFFF;
  }   

  .panel-heading {
    border-bottom: 1px solid rgba(0, 0, 0, 0);
    border-top-left-radius: 3px;
    border-top-right-radius: 3px;
    padding: 10px 15px;
  }   

  .panel-title {
    font-size: 16px;
    margin-bottom: 0;
    margin-top: 0;
  }   

  .panel-body:before, .panel-body:after {
    content: " ";
    display: table;
  }   

  .panel-body:before, .panel-body:after {
    content: " ";
    display: table;
  }   

  .panel-body:after {
    clear: both;
  }   

  .panel-body {
    padding: 15px;
  }   

  .panel-footer {
    background-color: #F5F5F5;
    border-bottom-left-radius: 3px;
    border-bottom-right-radius: 3px;
    border-top: 1px solid #DDDDDD;
    padding: 10px 15px;
  }

  //CSS from v3 snipp
  .user-row {
    margin-bottom: 14px;
  }

  .user-row:last-child {
    margin-bottom: 0;
  }

  .dropdown-user {
    margin: 13px 0;
    padding: 5px;
    height: 100%;
  }

  .dropdown-user:hover {
    cursor: pointer;
  }

  .table-user-information > tbody > tr {
    border-top: 1px solid rgb(221, 221, 221);
  }

  .table-user-information > tbody > tr:first-child {
    border-top: 0;
  }


  .table-user-information > tbody > tr > td {
    border-top: 0;
  }

  .bg_imageConfig{
    background-size: auto 130px;
    background-position: center;
    background-repeat: no-repeat;
  }
</style>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Freelancer List</title>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/font awesome/font-awesome.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/joblisting.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>css/w3.css">

<script type="text/javascript" src="<?php echo base_url(); ?>css/js/const.js"></script>
<style>
.bluishGreen_bg{
  background-color:#1fbea9;
  color: #ffffff;
}
.bluishGreen_txt{
  color:#1fbea9;
}
.button{
  background-color:#1fbea9;
}
#basic-addon{
  background-color:#1fbea9;                
}

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
              <input placeholder="Search Freelancers by name..." id="strsearch" onclick="this.select();" class="search_input form-control" name="search">
            </div>
          </form>
        </div>
      </div>
      <div class="col-md-2">
      </div>
    </div>
  </div>

  <hr>



  <div class="w3-container">
    <div class="col-lg-2 "></div>
    <div class="col-md-10 ">
      <h3 class="w3-padding-left">Explore Freelancers</h3>
      <div class="col-md-10  w3-margin-bottom" id="showResult">
        <div class="table-responsive">
          <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-striped table-hover">          
            <thead>
              <tr class="w3-light-grey">
                <th class="text-center"><h6>#</h6></th>
                <th class="text-center"><h6>Name</h6></th>
                <th class="text-center"><h6>Designation</h6></th>
                <th class="text-center"><h6>Average Ratings</h6></th>
                <th class="text-center"><h6>City</h6></th>
                <th class="text-center"><h6>Email-ID</h6></th>
                <th class="text-center"><h6>Action</h6></th>
              </tr>
            </thead>
            <tbody>
              <?php $i=1; 
              foreach ($info['status_message'] as $key => $value) { ?>
              <tr>
                <td class="text-center"><?php echo $i.'.'; ?></td>
                <td class="text-center"><?php if($value['jm_user_name']!='') {echo $value['jm_user_name'];}else{ echo '<b>Not Available</b>';} ?></td>
                <td class="text-center"><?php if($value['jm_userDesignation']!='') {echo $value['jm_userDesignation'];}else{ echo '<b>Not Available</b>';} ?></td>
                <td class="text-center"><span class="stars" data-rating="<?php echo $value['jm_avg_rating']; ?>" data-num-stars="5" ></span></td>
                <td class="text-center"><?php if($value['jm_userCity']!='') {echo $value['jm_userCity'];}else{ echo '<b>N/A</b>';} ?></td>
                <td class="text-center"><?php echo $value['jm_email_id']; ?></td>
                <td class="text-center"><?php  ?>
                  <a style="padding:2px" class="w3-medium btn " title="View Profile Card" ><i class="fa fa-address-card-o" style="color: #1fbea9" data-toggle="modal" data-target="#Profile_<?php echo $value['jm_user_id']; ?>"></i> </a>
                  <a href="" style="padding:2px" class="w3-medium btn " title="Chat with"><i class="fa fa-weixin" style="color: #1fbea9"></i> </a></td>
                </tr>

                <!-- Modal -->
                <div id="Profile_<?php echo $value['jm_user_id']; ?>" class="modal fade" role="dialog"><!--  modal for vshow portfolio information -->
                  <div class="modal-dialog modal-md">
                    <!-- Modal content-->
                    <div class="modal-content">

                      <div class="modal-body w3-small w3-round-large">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class="w3-container w3-margin-bottom" >
                          <div class="w3-col l12 w3-padding" >
                            <div class="w3-col l4 w3-margin-top w3-round-large">
                              <img class="img img-thumbnail" alt="Profile Image not found" style="height: 70%; width: 70%; object-fit: contain" src="<?php echo base_url().''.$value['jm_profile_image']; ?>" onerror="this.src='<?php echo base_url()?>css/logos/default_noimage.jpg'">
                            </div>
                            <div class="w3-col l8">
                              <h4 class=""><?php echo $value['jm_user_name']; ?></h4>
                              <div class="w3-col l12"><span class="w3-medium"><?php echo $value['jm_userDesignation']; ?></span></div>                              
                              <?php

                              echo 
                              '<span class="w3-small">';
                              if($value['jm_userCity']!=''){
                               echo '<i class="w3-large fa fa-map-marker"></i> '.$value['jm_userCity'].', '.$value['jm_userState'].', '.$value['jm_userCountry'].'</span>';
                             }
                             echo '<br>
                             <span class="w3-tiny w3-text-grey">Member since '.date('M d,Y', strtotime($value['joining_date'])).'</span>';
                             ?>                                
                           </div>
                         </div> 
                         <div class="w3-col l12 w3-white w3-round w3-padding">
                          <div class="w3-col l6 w3-padding">
                            <div class="w3-col l12"><label class="w3-medium">About Me</label></div>
                            <div class="w3-col l12 w3-text-grey">
                              <p>
                                <?php 
                                if($value['jm_userDescription']=='' || $value['jm_userDescription']=='<div><br></div>'){
                                  echo 'No Description Available for this Freelancer';
                                }
                                else{
                                  echo $value['jm_userDescription'];
                                  
                                }
                                ?>
                              </p>
                            </div>
                          </div>
                          <div class="w3-col l6  w3-padding-top">
                            <div class="w3-col l6 w3-padding  w3-border-left w3-border-right">
                              <div class="col-lg-12 w3-white w3-center w3-margin-top w3-card w3-padding-small w3-circle prof_pic">
                                <div class="w3-padding-top"><h2><i class="fa fa-inr"></i> <?php echo $value['jm_ratePerHr']; ?></h2>
                                  <span>INR/hr</span></div>
                                </div>
                                <div class="w3-col l12 w3-center">                  
                                  <span class="stars" data-rating="<?php echo $value['jm_avg_rating']; ?>" data-num-stars="5" ></span><br>

                                  <!-- script to dispaly stars -->
                                  <script>
                                    $.fn.stars = function() {
                                      return $(this).each(function() {
                                        var rating = $(this).data("rating");
                                        var numStars = $(this).data("numStars");
                                        var fullStar = new Array(Math.floor(rating + 1)).join('<i class="fa fa-star" style="margin-right:3px"></i>');
                                        var halfStar = ((rating%1) !== 0) ? '<i class="fa fa-star-half-empty" style="margin-right:3px"></i>': '';
                                        var noStar = new Array(Math.floor(numStars + 1 - rating)).join('<i class="fa fa-star-o" style="margin-right:3px"></i>');
                                        $(this).html(fullStar + halfStar + noStar);
                                      });
                                    }
                                    $('.stars').stars();
                                  </script>
                                  <!-- script to dispaly stars ends-->
                                  <span class="w3-text-grey w3-small"><?php echo $value['jm_avg_rating']; ?> Feedback</span>
                                </div>
                              </div>
                              
                              <div class="w3-col l6 w3-padding-small w3-tiny">
                                <!-- progress bar div -->
                                <div class="w3-col l12 w3-small ">
                                  <span><i class="w3-small fa fa-check-square-o"></i>&nbsp;Jobs Completed</span> 
                                  <div class="w3-col l10" style="padding-top: 7px">
                                    <div class="w3-round-xlarge progress w3-border" style="height: 7px !important;">
                                      <div class="w3-green w3-round-large progress" style="width: 0%"></div>              
                                    </div>
                                  </div>           
                                  <div class="w3-col l2">
                                    <span class="w3-tiny" style="padding-top: 0"><b>&nbsp;0%</b></span><br>
                                  </div>  
                                </div>
                                <!-- progress bar ends -->

                                <!-- progress bar div -->
                                <div class="w3-col l12 w3-small  ">
                                  <span><i class="w3-small fa fa-dollar w3-circle"></i>&nbsp;On Budget</span> 
                                  <div class="w3-col l10" style="padding-top: 7px">
                                    <div class="w3-round-xlarge progress w3-border" style="height: 7px !important;">
                                      <div class="w3-green w3-round-large progress" style="width: 0%"></div>              
                                    </div>
                                  </div>           
                                  <div class="w3-col l2">
                                    <span class="w3-tiny" style="padding-top: 0"><b>&nbsp;0%</b></span><br>
                                  </div>  
                                </div>
                                <!-- progress bar ends -->

                                <!-- progress bar div -->
                                <div class="w3-col l12 w3-small  ">
                                  <span><i class="w3-small fa fa-hourglass-half"></i>&nbsp;On Time</span> 
                                  <div class="w3-col l10" style="padding-top: 7px">
                                    <div class="w3-round-xlarge progress w3-border" style="height: 7px !important;">
                                      <div class="w3-green w3-round-large progress" style="width: 0%"></div>              
                                    </div>
                                  </div>           
                                  <div class="w3-col l2">
                                    <span class="w3-tiny" style="padding-top: 0"><b>&nbsp;0%</b></span><br>
                                  </div>  
                                </div>
                                <!-- progress bar ends -->

                              </div>
                            </div>
                          </div>                         
                        </div>
                      </div>  
                    </div>
                  </div>
                </div>
                <!-- modal ends here -->
                <?php $i++; } ?>
              </tbody>
             <!--  <tfoot>
                <tr>
                  <td colspan="7" class="text-center">PAGINATION.</td>
                </tr>
              </tfoot> -->
            </table>
          </div><!--end of .table-responsive--> 
        </div>
        <div class="w3-col l3 w3-padding">
          <div>
            <div><b>Skills :</b></div>
            <div class="skill"></div>
          </div>
          <div class="small_search">
            <div style="display:inline">
              <form >
                <input type="hidden" class="" id="skills_filtered">
                <input list="skill_list" type="text" name="allSkill" id="term" class="latest_search uneditable-input" placeholder="search by skills..." style="padding-left: 10px;width: 165px">
                <datalist id="skill_list">
                  <?php 
                  foreach($all_skills['status_message'] as $result) { ?>
                  <option data-value="<?php echo $result['jm_skill_id']; ?>" value="<?php echo $result['jm_skill_name']; ?>"><?php echo $result['jm_skill_name']; ?></option>                  
                  <?php } 
                  ?>
                </datalist>
                <i class="fa fa-plus-circle" style="font-size:20px;" name='usrname' id="hit"></i>
              </form>
            </div>
          </div>
          
        </div>
      </div>
      <div class="col-lg-1"></div>
    </div>


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
      skill = $('#skills_filtered').val();
      var str = $('#strsearch').val();
      if (timeout) {  
        clearTimeout(timeout);
      }
    //alert(str);
    if(str.length != 1 || event.keyCode != 32){

      timeout = setTimeout(function(){
        $.ajax({
          url :BASE_URL+'project/project_listing/filterProject',
          type : 'POST',
          dataType : 'text',
          data : {
            'fileds' : {
              // 'jm_userCity' : str+'/LIKE',
              'jm_user_name' : str+'/LIKE',
              'jm_skills' : skill+'/REGEXP',
            },
            'order' : {
              'field' : '',
              'order' : '',
            },
            'table' : {
              'table' : 'jm_user_tab',
            },
            'mode' : {
              'mode' : 'freelancer_list',
            }
          },
        }).
        done(function(data){
          console.log(data);
          $('#showResult').html(data);
        });//end of ajax
      },2000);//end of timeout function
    }else{
      $('#err-msg').text("No content for search");
      $('.do-err').fadeIn("slow");
      $(".do-err").delay(1000).fadeOut();
    }
  });

    $('#hit').on('click',function(event){
      event.preventDefault();
      var str = $('#term').val();
      skill=$('#skills_filtered').val();
      var skill_selected = $('#skill_list option[value="' + $('#term').val() + '"]').data('value');
      if(str!=""){
        if(skill=='')
          skill=skill_selected;
        else
          skill = skill+'|'+skill_selected;
        $('.skill').append('<div id="'+skill_selected+'" class="skill-tabs"><span><a class="btn" onclick="delSkill('+skill_selected+')" style="padding:0;margin:0"><i class="fa fa-times-circle-o" style="font-size: 15px; color: black"></i></a><span style="font-size:12px; padding-left:7px; color: black;text-decoration: none;"><label class="getskill">'+str+'</label></span></span></div>');
        $('#term').val('');
        $('#skills_filtered').val(skill);
    }//end if if
  });//end of click





    $('#hit').on('click',function(event){
      event.preventDefault();
    //var str = $('#term').val();
    skill = $('#skills_filtered').val();
    if(skill == ''){
      return false;
    }
    var str = $('#strsearch').val();
    
    $.ajax({
      url :BASE_URL+'project/project_listing/filterProject',
      type : 'POST',
      dataType : 'text',
      data : {
        'fileds' : {
          'jm_user_name' : str+'/LIKE',
          'jm_skills' : skill+'/REGEXP',
        },
        'order' : {
          'field' : '',
          'order' : '',
        },
        'table' : {
          'table' : 'jm_user_tab',
        },
        'mode' : {
          'mode' : 'freelancer_list',
        }
      },
    }).
    done(function(data){
      console.log(data);
      $('#showResult').html(data);
    });//end of ajax

  });

  });

// ------------------delete skill from skill filter list-------------------
function delSkill(id){
  $('#'+id+'').remove();
  var strValue=$('#skills_filtered').val();
  //alert(strValue);
  var res = strValue.replace('|'+id, '');
  var res = strValue.replace(id, '');
  var res = strValue.replace('|'+id, '');
  //alert(res);
  skill = $('#skills_filtered').val();
    if(skill == ''){
      return false;
    }
    var str = $('#strsearch').val();
    

  $.ajax({
    url :BASE_URL+'project/project_listing/filterProject',
    type : 'POST',
    dataType : 'text',
    data : {
      'fileds' : {
        'jm_project_title' : str+'/LIKE',
        'jm_project_skill' : skill+'/REGEXP',
        'jm_project_price' : value+'/<'
      },
      'order' : {
        'field' : field,
        'order' : order,
      },
      'table' : {
        'table' : 'jm_project_list',
      },
      'mode' : {
        'mode' : 'project_list',
      }
    },
  })
  done(function(data){
    console.log(data);
    $('#showResult').html(data);
    });//end of ajax
  
}
// ----------------------remove skill form skill filter ends here
//  </script>
</body>
</html>
<script></script>