<?php error_reporting(E_ERROR | E_PARSE);
$class="fa-bookmark-o";
$title="Add Bookmark";
$user_id=$this->session->userdata('user_id');
?>

<?php foreach ($result as $key) { ?>
      <div class="w3-col 12 w3-padding">              
      <div class="w3-col l12 w3-border-bottom">
      <div class="w3-right w3-margin-right w3-padding-right"><a onclick="add_bookmark(<?php echo $user_id ?>,<?php echo $key['jm_project_id'];?>" title="<?php echo $title ?>"><i id='project_'<?php echo $key['jm_project_id']; ?> class="fa '.$class.'" style="font-size:25px; color: black"></i></a></div>
      <div class="col-lg-8">
      <h4><?php echo $key['jm_project_title'] ?></h4>
      <div>
      <p>
      <div style="max-height:200px;overflow: hidden">
      <?php echo $key['jm_project_description']?><a class="w3-margin-left" href="<?php echo base_url().'project/view_project/'.base64_encode($key['jm_project_id'])?>"><span style="color:#02b28b"><i>more</i></span></a>
      </div>
      </p>
      </div>
      <div class="para_second">
      <p>Tags & Skills: </p>
      </div>
      <div class="w3-col l8 w3-margin-bottom">
      <div class="w3-col l12">
      <div class="w3-col l3 s3 w3-padding-tiny w3-tiny"><b><?php echo $key['jm_job_type']?></b></div>
      
      </div>
      </div>              
      </div>
      <div class="col-lg-4 w3-hide-small">
      <div class="">
      <div class="w3-small w3-col l12 "><b class="w3-right w3-margin-top w3-margin-bottom"><?php echo $key['jm_projectbudget_type']?></b></div>
      <div class="w3-col l12"><a href="<?php echo base_url().'project/view_project/'.base64_encode($key['jm_project_id'])?>" class="w3-small w3-black w3-right w3-round-xlarge w3-padding-tiny btn">VIEW PROJECT</a></div>
      <div class=" w3-col l12 w3-small"><span class="w3-right" style="padding-right:5px;margin-top:10px"><?php echo $key['jm_project_bid']?> Proposals</span></div>
      <div class="w3-col 12 w3-padding-tiny w3-margin-top w3-right w3-tiny w3-text-grey"><i class="w3-right">posted <?php echo timeago($key['jm_posting_date'])?></i></div>
      </div>
      </div>
      
      <div class="col-lg-4 w3-hide-large">
      <div class="">
      <div class="w3-small w3-col l6 s6"><b class="w3-left w3-margin-top w3-margin-bottom"><?php echo $key['jm_projectbudget_type']?></b></div>
      <div class="w3-col l6 s6"><a href="<?php echo base_url().'project/view_project/'.base64_encode($key['jm_project_id'])?>" class="w3-small w3-black w3-right w3-round-xlarge w3-padding-tiny btn">VIEW PROJECT</a>
          </div>
          
      <div class=" w3-col l12 s6 w3-small">
          <span class="w3-right" style="padding-right:5px; margin-top:10px"><?php echo $key['jm_project_bid']?> Proposals</span></div>
          
      <div class="w3-col l6 s6 w3-padding-tiny w3-margin-top w3-left w3-tiny w3-text-grey"><i class="w3-left">posted <?php echo timeago($key['jm_posting_date'])?></i></div>
      </div>
      </div>
      </div>             
      </div>
<?php } ?>
          