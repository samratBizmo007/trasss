<?php
if(!defined('BASEPATH')) exit('No direct script access allowed');

class Membership_model extends CI_Model
{

	// -----------------------GET ALL USER INFO MODEL----------------------//
	//-------------------------------------------------------------//
	public function getUserDetails_pay($user_id)
	{
		$query = "SELECT * FROM jm_user_tab, jm_userprofile_tab WHERE jm_user_tab.jm_user_id=jm_userprofile_tab.jm_user_id AND jm_user_tab.jm_user_id='$user_id'";
		$result=$this->db->query($query);  
		if ($result->num_rows() <= 0) 
		{
			$response = array(                                             
				'status' => 500,
				'status_message' => 'No Record Found.');                           
		} else {
			$response = array(
				'status' => 200,
				'status_message' => $result->result_array());
		}
		 // print_r($result->result_array());die();
		return $response;
		 // print_r($response);die();
	}

	// -----------------------GET ALL USER INFO MODEL----------------------//

	//---------------------function for save membership payment details--------------//
	function save_paymentdetails($data,$user_id){
        extract($data);
		$query="INSERT INTO jm_membership_payment(jm_user_id,jm_user_name,jm_status,jm_txnid,jm_amount,jm_hash, 	jm_subscribed_date)VALUES('$user_id','$user_name','$status','$txnid','$amount','$hash',NOW())";
     // echo $query();die();

       if($this->db->query($query)) {
   //     		$query = "UPDATE jm_usertransaction_tab SET paid_thisMonth='$amount' WHERE jm_user_id='$jm_user_id';
   //     	   $query = "UPDATE jm_user_tab SET membership_package,total_bids WHERE 'jm_user_id' ='$jm_user_id'";
   //     	    $result = $this->db->query($query);
			// if ($result) {
       			 Membership_model::get_update_subscription($membership_package,$user_id);
					$response = array(
					'status' => 200,
					'status_message' => 'Transaction saved successfully.');
			} 
		else {
			$response = array(
				'status' => 500,
				'status_message' => 'Transaction failed.');
		}
        -- //  $result = $this->db->query($query);
        -- // if(!$result) {
        -- //     $response = array(
        -- //         'status' => 500,
        -- //         'status_message' => 'Transaction Failed.');
        -- // } else {
        -- //     $response = array(
        -- //         'status' => 200,
        -- //         'status_message' => 'Transaction saved Successfully.');
        -- // }
        return $response;
      }
	//-----End function for save membership payment details-----------------------------//

      	public function get_update_subscription($membership_package,$user_id)
      	{
      		$query = "SELECT * FROM jm_user_tab WHERE jm_user_id='$user_id'";
      		$result = $this->db->query($query);
      		if ($result->num_rows() <= 0) {
			$response = array(
				'status' => 500,
				'status_message' => 'update subscription failed.');
			} else {
				$total_bids='';
			    $avail_bids='';
			foreach ($result->result_array() as $row) 
			{
				$total_bids = row['total_bids'];
				$avail_bids= row['avail_bids'];

			}
			switch($membership_package)
			{
				case 'P/M' :
						$total_bids=$total_bids-$avail_bids;
						$avail_bids;

				case 'P/Y' :
						$total_bids=$total_bids-$avail_bids;
						$avail_bids;

			}    
			$query = "UPDATE jm_user_tab SET membership_package='',total_bids='',$avail_bids='' WHERE 'jm_user_id' ='$jm_user_id'";	
			 $result = $this->db->query($sql);

        	if ($result) {
            $response = array(
                'status' => 200,
                'status_message' => ' Updated Successfully..!');
        	} else {
            $response = array(
                'status' => 500,
                'status_message' => ' Update Failed...!');
       			 }
        		return $response;
		}

		public function	cron_job_membership($user_id)
		{
			$query = "SELECT * FROM jm_membership_payment WHERE jm_user_id='$user_id'";
		    $result=$this->db->query($query);  
			if ($result->num_rows() <= 0) 
			{
			  $response = array(                                             
				'status' => 500,
				'status_message' => 'No data Found.');                           
		   } else {

			$jm_subscribed_date='';
			foreach ($result->result_array() as $row) 
			{
				$jm_subscribed_date = $row['jm_subscribed_date'];
				$current_date=date('Y-m-d');
       		    
                $date1Timestamp = strtotime($current_date);
                $date2Timestamp = strtotime($jm_subscribed_date);
                $difference = $date1Timestamp - $date2Timestamp;
                $diff= floor($difference / (60 * 60 * 24));
                $date_difference=$diff;
                if($current_date==$jm_subscribed_date)
               {
				if($profile_type==3 && $membership_package=="FREE")
				{
					if($date_difference>30)
					{
						$avail_view=3;
					}
				}
				if($profile_type==1 && $membership_package=="YEARLY")
				{
					if($date_difference>365)
					{
						$avail_view=20;
					}
				}
				}
			}
		}
		 // print_r($result->result_array());die();
		return $response;
		}

}//end of class