<?php

/*
 * This controller contains the functionalities to read and delete customers.
 * Only the admin user has the privilege to use these functionalities.
 */
class Customers extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    /*
     * Load a list of all the customers
     */
    function index() {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('customer_model');
        $customers = $this->customer_model->getAll();
        $data['customers']=$customers;
        load_view($this, 'customers/list.php',$data);
    }

    /*
     * Given a customer id, delete the customer and redirect to list of customers.
     * If the id belongs to admin user, load a forbidden error view
     * If the id is invalid, load a non existent error view
     */
    function delete($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('customer_model');
        $customer = $this->customer_model->get($id);
        if (!isset($customer)){
            load_error_view($this, 'customers', '404');
            return;
        }

        if ($customer->login == "admin"){
            load_error_view($this, 'customers', '403', 'Admin user cannot be deleted.');
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
     * If the id is invalid, load a non existent error view.
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
            load_error_view($this, 'customers', '404');
        }
    }

}
