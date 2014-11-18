<?php

class Orders extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();

    }

    /* Returns a list of all the orders
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
     * Given a order id, delete the order.
     */
    function delete($id) {
        if (!authenticate_login($this) or !authenticate_admin($this)){
            return;
        };

        $this->load->model('order_model');
        $order = $this->order_model->get($id);
        if (!isset($order)){
            load_view($this, 'auth/non_existent.php');
            return;
        }

        if (isset($id)){
            $this->order_model->delete($id);
        }

        //Then we redirect to the orders page again
        redirect('orders', 'refresh');
    }

    /*
     * Given a order id, return the order with the given id.
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
		// get customer
		$customer = $this->customer_model->get($order->customer_id);
        if (isset($order)){
		$data['order']=$order;
		$data['items'] = $items;
		$data['customer'] = $customer;
            load_view($this, 'orders/read.php',$data);
        } else {
            load_view($this, 'auth/non_existent.php');
        }
    }

}
