<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function __construct() {
        parent::__construct();
        //$this->load->model('search_model');
    }

    // -----------------------GET ALL ORDERS on admin dashboard MODEL----------------------//
    //-------------------------------------------------------------//
    public function AllOpen_Orders() {

        $query = "SELECT * FROM order_tab as ot join customer_tab as ct on (ct.user_id = ot.user_id) WHERE ot.status=2 ORDER BY ot.order_id DESC";

        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No orders found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }

    // -----------------------GET ALL ORDERS on admin dashboard MODEL----------------------//
    // -----------------------GET ALL OPEN ORDERS on admin dashboard  MODEL----------------------//
    //-------------------------------------------------------------//
    public function AllOrders() {

        $query = "SELECT * FROM order_tab as ot join customer_tab as ct on (ct.user_id = ot.user_id) WHERE ot.status=1 ORDER BY ot.order_id DESC";

        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No orders found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }

    // -----------------------GET ALL ORDERS on admin dashboard MODEL----------------------//
    // -----------------------GET ALL CLOSED ORDERS on admin dashboard MODEL----------------------//
    //-------------------------------------------------------------//
    public function AllClosed_Orders() {

        $query = "SELECT * FROM order_tab as ot join customer_tab as ct on (ct.user_id = ot.user_id) WHERE ot.status=0 ORDER BY ot.order_id DESC";

        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No orders found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }

    // -----------------------GET ALL CLOSED ORDERS on admin dashboard MODEL----------------------//
    //---------------delete ORder model-------------//
    function reOpen_Orders($order_id) {
        $query = "UPDATE order_tab SET status=2 WHERE order_id=" . $order_id . " ";

        if ($this->db->query($query)) {
            $response = array(
                'status' => 200,
                'status_message' => 'Order Opemed Successfully.'
            );
        } else {
            //insertion failure
            $response = array(
                'status' => 500,
                'status_message' => 'Sorry..Order Opening Failed!!!'
            );
        }

        return $response;
    }

    //----------------delete ORder ends--------------------------//
       //---------------delete ORder model-------------//
    function delOrder($order_id)
    {
        $query="UPDATE order_tab SET status=0 WHERE order_id=".$order_id." ";  
        
        if($this->db->query($query)){
            $response=array(
                'status' => 200,
                'status_message' =>'Order deleted Successfully.'         
            );
        }
        else
        {
            //insertion failure
            $response=array(
                'status' => 500,
                'status_message' =>'Sorry..Order Deletion Failed!!!'         
            );
        }

        return $response;
    }
    
    public function AllRegreted_orders(){
        $query = "SELECT * FROM order_tab as ot join customer_tab as ct on (ct.user_id = ot.user_id) WHERE ot.status= -1 ORDER BY ot.order_id DESC";

        $result = $this->db->query($query);

        if ($result->num_rows() <= 0) {
            $response = array(
                'status' => 500,
                'status_message' => 'No orders found.');
        } else {
            $response = array(
                'status' => 200,
                'status_message' => $result->result_array());
        }
        return $response;
    }

    //----------------delete ORder ends--------------------------//
    public function regretProduct($prod_no, $order_id) {

        $query = "SELECT * FROM order_tab WHERE order_id='$order_id'";

        $result = $this->db->query($query);
        $Product_details = '';
        if ($result->num_rows() <= 0) {
            $Product_details = array(
                'status' => 0,
                'status_message' => 'No Records Found.');
        } else {
            foreach ($result->result_array() as $row) {
                $Product_details = $row['order_products'];
            }
        }
        //$Product_details = QuotationForEnquiry_model::getOrderedProductDetails($order_id); //----fun for get ordered product details 
        $productArr = json_decode($Product_details, TRUE);

        foreach ($productArr as &$prod) {//-----loop for update json price
            if ($prod['prod_no'] == $prod_no) {
                $prod['prod_regret'] = 1;
            }
        }
        $productinfo = json_encode($productArr);

        $sqlupdate = "UPDATE order_tab SET order_products = '$productinfo'  WHERE order_id='$order_id'"; //----update enquiry befor insert to status 0
        $resultupdate = $this->db->query($sqlupdate);

        if ($resultupdate) {
            $response = array(
                'status' => 1,
                'status_message' => 'Product Regreted..!');
        } else {
            $response = array(
                'status' => 0,
                'status_message' => 'Product did not get Regreted...!');
        }
        return $response;
    }

    // -----------------------GET ALL ORDERS COUNT----------------------//
    //-------------------------------------------------------------//
    public function getOrderCount(){

        // -------------get active order count----------------------
        $activeCount=0;
        $active_query = $this->db->get_where('order_tab', array(//making selection
            'status' => '1'
        ));
        $activeCount=$active_query->num_rows();

        // -------------get open order count----------------------
        $openCount=0;
        $open_query = $this->db->get_where('order_tab', array(//making selection
            'status' => '2'
        ));
        $openCount=$open_query->num_rows();

        // -------------get close order count----------------------
        $closeCount=0;
        $close_query = $this->db->get_where('order_tab', array(//making selection
            'status' => '0'
        ));
        $closeCount=$close_query->num_rows();

        $response = array(
                'status' => 200,
                'status_message' => 'Count for all available orders',
                'activeOrders'  =>  $activeCount,
                'openOrders'  =>  $openCount,
                'closeOrders'  =>  $closeCount,
            );
        return $response;
    }
    // -----------------------GET ALL ORDERS COUNT MODEL----------------------//

}

?>