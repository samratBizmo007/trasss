<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

error_reporting(E_ERROR | E_PARSE);

class Applied_candidate_lists extends CI_Controller {

    public function __construct() {
        parent::__construct();
        //start session	
        $this->load->helper('file');
        $this->load->helper('download');
        $user_id = $this->session->userdata('user_id');
        $user_name = $this->session->userdata('user_name');
        $profile_type = $this->session->userdata('profile_type');
        //check session variable set or not, otherwise logout
        if (($user_id == '') || ($user_name == '') || ($profile_type == '')) {
            redirect('auth/login');
        }
    }

    public function index() {

    }

    //---------------download user resume----------------------//
    public function download($user_id = '') {
        $path = base_url();
        $url = $path . 'api/AppliedCandidate_Lists_api/download?user_id='.$user_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        $file = explode("/", $response);
        $file_name = $file[2];
        $file = base_url().$response;
        $data =   file_get_contents($file);            
        force_download($file_name,$data);        
    }
    // -----------------download function ends---------------//

    public function DownloadCsv(){
        extract($_POST);
        $path = base_url();
        $url = $path . 'api/AppliedCandidate_Lists_api/DownloadCsv?job_id='.$job_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        print_r($response_json);die();
        $query = $response['query'];
        

        // Starting the PHPExcel library
        $this->load->library('PHPExcel');
        $this->load->library('PHPExcel/IOFactory');

        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");

        $objPHPExcel->setActiveSheetIndex(0);

        // Field names in the first row
        $fields = $query->list_fields();
        $col = 0;
        foreach ($fields as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
            $col++;
        }

        // Fetching the table data
        $row = 2;
        foreach($query->result() as $data)
        {
            $col = 0;
            foreach ($fields as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $data->$field);
                $col++;
            }

            $row++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        $objWriter = IOFactory::createWriter($objPHPExcel, 'Excel5');

        // Sending headers to force the user to download the file
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Products_'.date('dMy').'.xls"');
        header('Cache-Control: max-age=0');

        $objWriter->save('php://output');
        
        
        $query = $response['query'];
        $delimiter = $response['delimiter'];
        $newline = $response['newline'];
        
        $data = $this->dbutil->csv_from_result($query, $delimiter, $newline);
        force_download('CSV_Report.csv', $data);
        
    }

    public function SaveStatus(){
        extract($_POST);
       // print_r($_POST);die();
        if($candidate_id == ''){
            echo'<div class="alert alert-danger w3-margin" style="text-align: center;">
            <strong>Please Select At Least One Candidate...!</strong> 
            </div>    
            ';
            die();
        }
        if($Candidate_Status == '0'){
            echo'<div class="alert alert-danger w3-margin" style="text-align: center;">
            <strong>Please Select Status...!</strong> 
            </div>    
            '; 
            die();
        }
        $candidate_id = json_encode($candidate_id);
        $path = base_url();
        $url = $path.'api/AppliedCandidate_Lists_api/SaveStatus?candidate_id='.$candidate_id.'&Candidate_Status='.$Candidate_Status;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        //print_r($response_json);
        if ($response['status'] == 200) {
            echo'<div class="alert alert-success w3-margin" style="text-align: center;">
            <strong>' . $response['status_message'] . '</strong> 
            </div>    
            ';
        } else {
            echo'<div class="alert alert-danger w3-margin" style="text-align: center;">
            <strong>' . $response['status_message'] . '</strong> 
            </div>    
            ';
        }
    }

    // ------------------HIRE CANDIDATE FOR JOB---------------------//
    public function hireSelectedStudents(){
        extract($_POST);
       // print_r($_POST);die();
        if($candidate_id == ''){
            echo'<div class="alert alert-danger w3-margin" style="text-align: center;">
            <strong>Please Select At Least One Candidate...!</strong> 
            </div>    
            ';
            die();
        }
        $candidate_id = json_encode($candidate_id);
        //echo $candidate_id; die();
        $path = base_url();
        $url = $path.'api/AppliedCandidate_Lists_api/hireSelectedStudents?candidate_id='.$candidate_id.'&job_id='.$job_id;
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response_json = curl_exec($ch);
        curl_close($ch);
        $response = json_decode($response_json, true);
        print_r($response_json);die();
        if ($response['status'] == 200) {
            echo'<div class="alert alert-success" style="margin-bottom:5px">
            <strong>'.$response['status_message'].'</strong> 
            </div>
            <script>
            window.setTimeout(function() {
              $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
                 $(this).remove(); 
             });
             window.location.href="'.base_url().'profile/dashboard";
         }, 100);
         </script>';
     } else {
        echo'<div class="alert alert-danger" style="margin-bottom:5px">
        <strong>'.$response['status_message'].'</strong> 
        </div>
        <script>
        window.setTimeout(function() {
          $(".alert").fadeTo(1000, 0).slideUp(1000, function(){
             $(this).remove(); 
         });
         window.location.href="'.base_url().'profile/dashboard";
     }, 100);
     </script>    
     ';
 }            
}
    //----------------------------ENDS-----------------------------------//
}
