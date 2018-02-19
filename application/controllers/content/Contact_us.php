<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

//error_reporting(E_ERROR | E_PARSE);
class Contact_us extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        //$data['jobs']= About_us::getRecentJobs();		
        $this->load->view('includes/header.php');
        $this->load->view('pages/static/contact_us.php');
        $this->load->view('includes/footer.php');
    }

    public function sendContactEmail() {
        extract($_POST);
        //print_r($_POST);die();
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
        $this->email->to('customercare@jobmandi.in');
        $this->email->subject("JOBMANDI-Contact Form");
        $this->email->message("<html>"
                . "<head>"
                . "</head>"
                . "<body>"
                . "<p><label><h3><b>Contact Form</label></b></h3></p>"
                . "<p><label>Contact form has been submitted by: Name:- $user_name </label></p>"
                . "<p><label>Email Id:- $email </label></p>"
                . "<p><label>Subject:- $subject</label></p>"
                . "<p><label>For The Purpose Of: $message </label></p>"
                . "</body>"
                . "</html>");
        //print_r($this->email->send());die();
        if (!$this->email->send()) {
            echo '<div class="alert alert-danger" style="margin-bottom:5px">
            <strong>Message Sending Failed.</strong> 
            </div>
            <script>
            window.setTimeout(function() {
              $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                 $(this).remove(); 
                 location.reload();
             });
            }, 100);
            </script>';
        } else {

            $this->load->library('email', $config);
            $this->email->set_newline("\r\n");
            $this->email->from('customercare@jobmandi.in', "Admin Team");
            $this->email->to($email);
            $this->email->subject("JOBMANDI-Customer Care");
            $this->email->message("<html>"
                    . "<head>"
                    . "<title></title>"
                    . "</head>"
                    . "<body>"
                    . "<p><label><h3><b>JOBMANDI Customer Support</label></b></h3></p>"
                    . "<p><label>Your message was successfully sent!</label></p>"
                    . "<p><label>Thank you for contacting us, we will reply to your inquiry as soon as possible!</label></p>"
                    . "<p><label>Thank You..!</label></p>"
                    . "<p><label></label></p>"
                    . "</body>"
                    . "</html>");
            if ($this->email->send()) {
                echo '<div class="alert alert-success" style="margin-bottom:5px">
            <strong>Message Sent Successfully..!</strong> 
            </div>
            <script>
            window.setTimeout(function() {
              $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                 $(this).remove(); 
                 location.reload();
             });
            }, 100);
            </script>';
            } else {
                echo '<div class="alert alert-danger" style="margin-bottom:5px">
            <strong>Message Sending Failed..!</strong> 
            </div>
            <script>
            window.setTimeout(function() {
              $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                 $(this).remove(); 
                 location.reload();
             });
            }, 100);
            </script>';
            }
        }
    }

    //----------------------email verification code ends------------------------//
    //--------------------------------------------------------------------------//
}

?>