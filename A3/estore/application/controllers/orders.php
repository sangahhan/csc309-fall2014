<?php

class Orders extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    /* Returns a list of all the customers
     */
    function index() {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('order_model');
        $orders = $this->order_model->getAll();
        $data['orders']=$orders;
        load_view($this, 'orders/list.php',$data);
    }

    /*
     * Given a customer id, delete the customer.
     */
    function delete($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('customer_model');
        $customer = $this->customer_model->get($id);
        if (!isset($customer)){
            load_view($this, 'auth/non_existent.php');
            return;
        }

        if (isset($id)){
            $this->customer_model->delete($id);
        }

        //Then we redirect to the customers page again
        redirect('customers', 'refresh');
    }

    /*
     * Given a customer id, return the customer with the given id.
     */
    function read($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('customer_model');
        $customer = $this->customer_model->get($id);
        if (isset($customer)){
            $data['customer']=$customer;
            load_view($this, 'customers/read.php',$data);
        } else {
            load_view($this, 'auth/non_existent.php');
        }
    }

}
