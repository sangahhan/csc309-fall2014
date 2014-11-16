<?php

class Customers extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    function index() {
        authenticate_login($this);
        authenticate_admin($this);
        $this->load->model('customer_model');
        $customers = $this->customer_model->getAll();
        $data['customers']=$customers;
        load_view($this, 'customers/list.php',$data);
    }

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

}
