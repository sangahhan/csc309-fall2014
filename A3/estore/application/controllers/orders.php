<?php

/*
 * This controller contains the functionalities to read and delete orders.
 * Only the admin user has the privilege to use these functionalities.
 */
class Orders extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    /*
     * Loads a list of all the orders
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
     * Given a order id, delete the order. If the id is invalid, load error view
     */
    function delete($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('order_model');
        $order = $this->order_model->get($id);
        if (!isset($order)){
            load_error_view($this, 'orders', '404');
            return;
        }

        if (isset($id)){
            $this->order_model->delete($id);
        }

        //Then we redirect to the orders page again
        redirect('orders', 'refresh');
    }

    /*
     * Given a order id, return the order with the given id. If the id is invalid
     * load the error view.
     */
    function read($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

		$this->load->model('order_model');
		$this->load->model('order_item_model');
		$this->load->model('customer_model');
		// get order
		$order = $this->order_model->get($id);
		// get items
		$items = $this->order_item_model->get_order($id);

        if (isset($order)){
            // get customer
            $customer = $this->customer_model->get($order->customer_id);

            $data['order'] = $order;
		    $data['items'] = $items;
		    $data['customer'] = $customer;
            load_view($this, 'orders/read.php', $data);
        } else {
            load_error_view($this, 'orders', '404');
        }
    }

}
