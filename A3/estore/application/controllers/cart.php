<?php

class Cart extends CI_Controller {


    function __construct() {
        // Call the Controller constructor
        parent::__construct();
    }

    function index() {

        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');
        $data['items'] = $items;
        load_view($this, 'cart/cart.php', $data);
    }

    function add_to_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            $item['quantity'] = $item['quantity'] + 1;
        } else {
            $this->load->model('product_model');
            $product = $this->product_model->get($product_id);
            if (isset($product)){
                $items[$product_id] = array("name" => $product->name,
                                    "quantity" => 1);
            } else {
                load_view($this, 'auth/non_existent.php');
                return;
            }
        }

        $this->session->set_userdata('cart', $items);
        load_product_list($this);
    }

    function reduce_from_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];

            if ($item['quantity'] <= 1){
                unset($items[$product_id]);
            } else {
                $item['quantity'] = $item['quantity'] - 1;
            }
        } else {
            load_view($this, 'auth/non_existent.php');
            return;
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'cart/cart.php', $data);
    }

    function increase_in_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            $item['quantity'] = $item['quantity'] + 1;
        } else {
            load_view($this, 'auth/non_existent.php');
            return;
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'cart/cart.php', $data);
    }

    function remove_from_cart($product_id){
        if (!authenticate_login($this)){
            return;
        }

        $items = $this->session->userdata('cart');

        if (array_key_exists($product_id, $items)){
            $item = & $items[$product_id];
            unset($items[$product_id]);
        } else {
            load_view($this, 'auth/non_existent.php');
            return;
        }

        $this->session->set_userdata('cart', $items);

        $data['items'] = $items;
        load_view($this, 'cart/cart.php', $data);
    }
}
