<?php

//Admin Dashboard controller
class Dashboard extends CI_Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {

        $data['orderCount'] = Dashboard::getOrderCount();     //-------show all Raw prods
        
        $this->load->view('includes/admin_header.php');
        $this->load->view('pages/admin/dashboard', $data);
        //$this->load->view('includes/footer.php');
    }

    //----------this function to get all my orders count-----------------------------
 public function getOrderCount() {

  $path = base_url();
  $url = $path . 'api/Dashboard_api/getOrderCount';
  $ch = curl_init($url);
  curl_setopt($ch, CURLOPT_HTTPGET, true);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response_json = curl_exec($ch);
  curl_close($ch);
  $response = json_decode($response_json, true);
  return $response;
}
//----------------this fun get all my orders count end---------------//

}
