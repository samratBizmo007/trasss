<?php

class Login extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->model('search_model');
    }

    // -----------------------USER REGISTERATION MODEL BY MOBILE----------------------//
    //-------------------------------------------------------------//
    public function send_otpForMobile($user_name, $email_id) {
        
            if ($user_name == '') {
            $response = array(
                'status' => 500,
                'status_message' => 'Username Not Found..!');
            return $response;
            die();
        }

        if ($email_id == '') {
            $response = array(
                'status' => 500,
                'status_message' => 'Email Not Found..!');
            return $response;
            die();
        }

        $cust_id = "";
        $email_idRegistered = '';
        $checkEmail = login::checkEmail_exist($email_id);
        $checkusername = login::checkUsername_exist($user_name);
        //print_r($checkEmail);die();
        if ($checkEmail == 0 && $checkusername == 0) {
            $otp = rand(100000, 999999);

            $otp_function = login::sendEmailotp($user_name, $email_id, $otp);
            
            if ($otp_function) {
                //$otp_save_pudate =login::saveOtp($email_id,$otp); 
                $sqlselect = "SELECT email_id FROM otp_expiry WHERE email_id = '$email_id'";
                
                $result = $this->db->query($sqlselect);
                
                if ($result->num_rows() >= 1) {
                    foreach ($result->result_array() as $row) {
                        $email_idRegistered = $row['email_id'];
                    }
                }

                if ($email_id == $email_idRegistered) {

                    $query = "UPDATE otp_expiry SET otp = '$otp',user_name = '$user_name' WHERE email_id = '$email_id' AND user_name='$user_name'";
                    
                    $result = $this->db->query($query);

                    if ($result) {
                        $response = array(
                            'status' => 200, //---------insert db success code
                            //'otp' => $otp,
                            'status_message' => 'OTP Has Been Sent To Your Email ID. Please Verify The OTP.'
                        );
                    }
                } else {
                    $query = "INSERT INTO otp_expiry(email_id,otp,create_at,user_name) VALUES ('$email_id','$otp',NOW(),'$user_name')";
                    
                    $result = $this->db->query($query);
                    if ($result) {
                        $response = array(
                            'status' => 200, //---------insert db success code
                            //'otp' => $otp,
                            'status_message' => 'OTP Has Been Sent To Your Email ID. Please Verify The OTP.'
                        );
                    } else {
                        $response = array(
                            'status' => 500, //---------insert db success code
                            'status_message' => 'OTP Sending Failed.'
                        );
                    }
                }
            }
        } else {
            //if email-Id already regiterd then show error
            $response = array(
                'status' => 500,
                'status_message' => 'Email OR Username Already Registered. Login by same or use another Email OR Username.!!!'
            );
        }
        return $response;
    }

    // -----------------------USER REGISTERATION MODEL by mobile----------------------//
    
    public function registerCustomer($user_name, $email_id, $password, $register_mobile_no, $register_address) {
    	
        $checkEmail = login::checkEmail_exist($email_id);
        $checkusername = login::checkUsername_exist($user_name);
        if ($checkEmail == 0 && $checkusername == 0) {
        	$data = array(
               'username' => $user_name,
               'password' => base64_encode($password),
                'email' => $email_id,
                'mobile_no' => $register_mobile_no,
                'address' => $register_address
        	);
        	if($this->db->insert('customer_tab', $data))
        	{
	        	$response=array(
					'status' => 200,	//---------insert db success code
					'status_message' =>'Registration Successfull. Please Login With Your Registered Email-ID.'
				);
        	
        	} else
			{
				$response=array(
				'status' => 500,	//---------db error code 
				'status_message' =>'Something went wrong... Registration Failed!!!'
			);
			}
    	  }else{
	 	//if email-Id already regiterd then show error
			$response=array(
				'status' => 500,
				'status_message' =>'Email ID Already Registered for this profile. Login by same or use another Email-ID!!!'					
			);	
		}	
		return $response;
    }  
    // -----------------------USER REGISTERATION MODEL----------------------//
    //-------------------------------------------------------------//
//    public function registerCustomer($user_name, $email_id, $password, $register_mobile_no, $register_address) {
//        $cust_id = "";
//        $email_idRegistered = '';
//        $checkEmail = login::checkEmail_exist($email_id);
//        $checkusername = login::checkUsername_exist($user_name);
//        //print_r($checkEmail);die();
//        if ($checkEmail == 0 && $checkusername == 0) {
//            $otp = rand(100000, 999999);
////            $data = array(
////                'username' => $user_name,
////                'password' => base64_encode($password),
////                'email' => $email_id,
////                'mobile_no' => $register_mobile_no,
////                'address' => $register_address
////                    //'otp'=> $otp
////            );
//
//            $otp_function = login::sendEmailotp($user_name, $email_id, $otp);
//            //$checkEmail = login::checkEmail_existForOtp($email_id);
//            if ($otp_function) {
//                //$otp_save_pudate =login::saveOtp($email_id,$otp); 
//                $sqlselect = "SELECT email_id FROM otp_expiry WHERE email_id = '$email_id'";
//                $result = $this->db->query($sqlselect);
//                if ($result->num_rows() >= 1) {
//                    foreach ($result->result_array() as $row) {
//                        $email_idRegistered = $row['email_id'];
//                    }
//                }
//
//                if ($email_id == $email_idRegistered) {
//
//                    $query = "UPDATE otp_expiry SET otp = '$otp',user_name = '$user_name' WHERE email_id = '$email_id' AND user_name='$user_name'";
//                    $result = $this->db->query($query);
//
//                    if ($result) {
//                        $response = array(
//                            'status' => 200, //---------insert db success code
//                            //'otp' => $otp,
//                            'status_message' => 'OTP Has Been Sent To Your Email ID. Please Verify The OTP.'
//                        );
//                    }
//                } else {
//                    $query = "INSERT INTO otp_expiry(email_id,otp,create_at,user_name) VALUES ('$email_id','$otp',NOW(),'$user_name')";
//                    $result = $this->db->query($query);
//                    if ($result) {
//                        $response = array(
//                            'status' => 200, //---------insert db success code
//                            //'otp' => $otp,
//                            'status_message' => 'OTP Has Been Sent To Your Email ID. Please Verify The OTP.'
//                        );
//                    } else {
//                        $response = array(
//                            'status' => 500, //---------insert db success code
//                            'status_message' => 'OTP Sending Failed.'
//                        );
//                    }
//                }
//            }
//        } else {
//            //if email-Id already regiterd then show error
//            $response = array(
//                'status' => 500,
//                'status_message' => 'Email OR Username Already Registered. Login by same or use another Email OR Username.!!!'
//            );
//        }
//
//        return $response;
//    }

    // -----------------------USER REGISTERATION MODEL----------------------//
    public function getNextID($col_name, $table_name) {


        $sql = "SELECT MAX($col_name) as id FROM $table_name";
        $resultnew = $this->db->query($sql);

        $id = "";

        foreach ($resultnew->result_array() as $row) {
            $id = $row['id'];
        }
        return $id;
    }

    //-------------------------------------------------------------//
    //-----------------------function to check whether username already exists------------------//

    function checkEmail_exist($email_id) {
        $query = null;
        $query = $this->db->get_where('customer_tab', array(//making selection
            'email' => $email_id
        ));

        if ($query->num_rows() <= 0) {
            return 0;
        } else {
            return 1;
        }
    }

    //-----------------------function to check whether email-ID or username already exists------------------//

    public function checkUsername_exist($user_name) {
        $query = null;
        $query = $this->db->get_where('customer_tab', array(//making selection
            'username' => $user_name
        ));

        if ($query->num_rows() <= 0) {
            return 0;
        } else {
            return 1;
        }
    }

    public function checkEmail_existForOtp($email_id) {
        $query = $this->db->get_where('otp_expiry', array(//making selection
            'email_id' => $email_id
        ));

        if ($query->num_rows() > 0) {
            return 0;
        } else {
            return 1;
        }
    }

//-----------------------function to check whether email-ID or username already exists------------------//
 

    // -----------------------USER LOGIN API----------------------//
    public function sendEmailotp($username, $email, $otp) {

        $config = Array(
            'protocol' => 'smtp',
            'smtp_host' => 'mx1.hostinger.in',
            'smtp_port' => '587',
            'smtp_user' => 'customercare@jobmandi.in', // change it to yours
            'smtp_pass' => 'Descartes@1990', // change it to yours
            'mailtype' => 'html',
            'charset' => 'utf-8',
            'wordwrap' => TRUE
        );
        $config['smtp_crypto'] = 'tls';
        //return ($config);die();

        $this->load->library('email', $config);
        $this->email->set_newline("\r\n");
        $this->email->from('customercare@jobmandi.in', "Admin Team");
        $this->email->to($email, $username);
        $this->email->subject("OTP Send");
        //$this->email->message("Dear ".$username.",\nPlease click on below URL or paste into your browser to verify your Email Address\n\n <a href='".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."'>".base_url()."auth/login/verify_email/".base64_encode($email)."?profile=".$profile_type."</a>\n"."\n\nThanks\nAdmin Team");

        $this->email->message('<html>
			<head>
			<meta name="viewport" content="width=device-width, initial-scale=1.0">
			<link rel="stylesheet" href="http://jobmandi.in/css/bootstrap/bootstrap.min.css">
			<script src="http://jobmandi.in/css/bootstrap/jquery.min.js"></script>
			<script src="http://jobmandi.in/css/bootstrap/bootstrap.min.js"></script>
			</head>
			<body>
			<div class="container col-lg-8" style="box-shadow: 0 2px 4px 0 rgba(0,0,0,0.16),0 2px 10px 0 rgba(0,0,0,0.12)!important;margin:10px; font-family:Candara;">
			<h2 style="color:#4CAF50; font-size:30px">Welcome To Joomla Business!!</h2>
			<h3 style="font-size:15px;">Hello ' . $username . ',<br></h3>
			<h3 style="font-size:15px;">Your OTP is ' . $otp . ',<br>Please Login with OTP</h3>
			
			<div class="col-lg-12">
			<div class="col-lg-4"></div>
			<div class="col-lg-4">
			
			</div>
			</body></html>');

        if ($this->email->send()) {
            $response = array(
                'status' => 200, //---------email sending succesfully 
                'status_message' => 'Email Sent Succesfully.'
            );
        } else {
            //print_r($this->email->print_debugger());die();
            $response = array(
                'status' => 500, //---------email send failed
                'status_message' => 'Email Sending Failed.'
            );
        }
        return $response;
    }

    //----------------------email verification code ends------------------------//
//----------------------verify otp for mobile---------------------------------------//
    public function verify_otpForRegisterCustomer($register_username, $register_email, $register_password, $register_mobile_no, $register_address, $OTP_id){
        //echo strlen($register_password);        die();
        if ($register_password == '' || strlen($register_password) < 8) {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Password size is invalid must be greater than 8 chars!');
                return $response;
                die();
            }
        if ($register_email == '') {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Email Not Found!');
                return $response;
                die();
            }
        if ($register_username == '') {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Username not found!');
                return $response;
                die();
            }
        if (!(is_numeric($register_mobile_no))) {
            if ($register_mobile_no == '') {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Mobile number not found!');
                return $response;
                die();
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Mobile number should be numeric!');
                return $response;
                die();
            }
        }
          if (!(is_numeric($OTP_id))) {
            if ($OTP_id == '') {
                $response = array(
                    'status' => 500,
                    'status_message' => 'OTP code invalid!');
                return $response;
                die();
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'OTP code invalid!');
                return $response;
                die();
            }
        }
        $otp = '';
        $selectquery = "SELECT otp FROM otp_expiry WHERE email_id = '$register_email'";
        //echo $selectquery; die();
        $resultselect = $this->db->query($selectquery);
        if ($resultselect->num_rows() == 1) {

            foreach ($resultselect->result_array() as $row) {
                $otp = $row['otp'];
            }
            //echo $otp;
            //echo $OTP_id;die();
            if ($otp == $OTP_id) {
                $insertquery = "INSERT INTO customer_tab(username,password,email,mobile_no,address) VALUES "
                        . "('$register_username','" . base64_encode($register_password) . "','$register_email','$register_mobile_no','$register_address')";
                //echo $insertquery; die();
                $result = $this->db->query($insertquery);
                $response = array(
                    'status' => 200,
                    'status_message' => 'Registration successfull.');
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Invalid OTP. Please Validate Otp Again By Filling The Registration Form.!');
            }
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'OTP Generation Failed. Please Register Once Again..!');
        }
        return $response;
    }
    //----------------------verify otp for mobile---------------------------------------//

    //----------------------otp verification code starts here------------------------//

    function verify_otp($register_username, $register_email, $register_password, $register_mobile_no, $register_address, $OTP_id) {

        $otp = '';
        $selectquery = "SELECT otp FROM otp_expiry WHERE email_id = '$register_email'";
        //echo $selectquery; die();
        $resultselect = $this->db->query($selectquery);
        if ($resultselect->num_rows() == 1) {

            foreach ($resultselect->result_array() as $row) {
                $otp = $row['otp'];
            }
            //echo $otp;
            //echo $OTP_id;die();
            if ($otp == $OTP_id) {
                $insertquery = "INSERT INTO customer_tab(username,password,email,mobile_no,address) VALUES "
                        . "('$register_username','" . base64_encode($register_password) . "','$register_email','$register_mobile_no','$register_address')";
                //echo $insertquery; die();
                $result = $this->db->query($insertquery);
                $response = array(
                    'status' => 200,
                    'status_message' => 'Registration successfull.');
            } else {
                $response = array(
                    'status' => 500,
                    'status_message' => 'Invalid OTP. Please Validate Otp Again By Filling The Registration Form.!');
            }
        } else {
            $response = array(
                'status' => 500,
                'status_message' => 'OTP Generation Failed. Please Register Once Again..!');
        }
        return $response;
    }

    //-------------------------------------------------------------//
    public function loginCustomer($user_name, $password) {
        //sql query to check login credentials
        $pass = base64_encode($password);
        $query = "SELECT * FROM customer_tab WHERE (email='$user_name' || username='$user_name') AND password='$pass'";
        //echo $query;die();
        $result = $this->db->query($query);
        $user_id = '0';
        $privilege = '';
        //if credentials are true, their is obviously only one record
        if ($result->num_rows() == 1) {

            foreach ($result->result_array() as $row) {
                $user_name = $row['username'];
                $user_id = $row['user_id'];
            }

            if ($result) {
                $sql = "UPDATE customer_tab SET active='1' WHERE user_id='$user_id'";
                //echo $sql;die();
                $result = $this->db->query($sql);

                //response with values to be stored in sessions if update session_bool true
                $response = array(
                    'status' => 200,
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'status_message' => 'Login Successfull'
                );
            } else {
                $response = array(
                    'status' => 500,
                    'user_id' => $user_id,
                    'user_name' => $user_name,
                    'status_message' => 'Error to start session for ' . $user_name . ' !!!',
                );
            }
        } else {
            //login failed response
            $response = array(
                'status' => 500,
                'status_message' => 'Sorry..Login credentials are incorrect!!!',
                'user_id' => $user_id,
                'user_name' => $user_name,
            );
        }
        return $response;
    }

    //----------------------------LOGIN END------------------------------//
    // -----------------------USER LOGIN API----------------------//
    //-------------------------------------------------------------//
    public function adminLogin($user_name, $password) {
        //sql query to check login credentials
        $pass = base64_encode($password);
        $query = "SELECT * FROM admin_tab WHERE (admin_email='$user_name' || username='$user_name') AND password='$password'";
        //echo $query;die();
        $result = $this->db->query($query);
        $admin_id = '0';
        $privilege = '';
        //if credentials are true, their is obviously only one record
        if ($result->num_rows() == 1) {

            foreach ($result->result_array() as $row) {
                $user_name = $row['username'];
                $admin_id = $row['admin_id'];
            }

            //response with values to be stored in sessions if update session_bool true
            $response = array(
                'status' => 200,
                'user_id' => $admin_id,
                'user_name' => $user_name,
                'status_message' => 'Login Successfull'
            );
        } else {
            //login failed response
            $response = array(
                'status' => 500,
                'status_message' => 'Sorry..Login credentials are incorrect!!!',
                'user_id' => $admin_id,
                'user_name' => $user_name,
            );
        }
        return $response;
    }

    //--------------Logout User-----------------------------//
    function logout_user($user_id) {
        $sql = "UPDATE customer_tab SET active='0' WHERE user_id='$user_id'";
        //echo $sql;die();
        $this->db->query($sql);
        return $this->db->affected_rows();
    }

    //-------End Logout user--------------------------------//
    //----------------------------LOGIN END------------------------------//
}
