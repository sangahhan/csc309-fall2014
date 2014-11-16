<?php

class Customers extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    /* Returns a list of all the customers
     */
    function index() {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('customer_model');
        $customers = $this->customer_model->getAll();
        $data['customers']=$customers;
        load_view($this, 'customers/list.php',$data);
    }

    /*
     * Given a customer id, delete the customer.
     */
    function delete($id) {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('customer_model');

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
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('customer_model');
        $customer = $this->customer_model->get($id);
        $data['customer']=$customer;
        load_view($this, 'customers/read.php',$data);
    }

}
