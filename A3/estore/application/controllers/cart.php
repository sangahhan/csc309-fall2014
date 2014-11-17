<?php

class Cart extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		date_default_timezone_set('America/New_York');
	}

	function index() {

		if (!authenticate_login($this)){
			return;
		}

		load_cart_view($this);
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
					"quantity" => 1,
					"price" => $product->price);
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

		load_cart_view($this);
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

		load_cart_view($this);
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

		load_cart_view($this);
	}

	function checkout_form(){
		if (!authenticate_login($this)){
			return;
		}
		load_view($this, 'cart/checkout_form.php');

	}

	function checkout_summary(){

		$this->load->library('form_validation');

		$this->form_validation->set_rules('creditcard_number','Credit card number',
			'required|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('creditcard_year','Credit card year',
			'callback__validate_date');


		if ($this->form_validation->run() == true) {

			$now = new DateTime("now");
			$order = new Order();
			$order->customer_id = $this->session->userdata('user_id');
			$order->creditcard_number = $this->input->get_post('creditcard_number');
			$order->creditcard_month = $this->input->get_post('month');
			$order->creditcard_year = $this->input->get_post('year');
			$order->order_time = $now->format('H:i:s');
			$order->order_date = $now->format('Y-m-d');
			$items = $this->session->set_userdata('card_info', array(
				'number' => $order->creditcard_number,
				'month' =>  $order->creditcard_month,
				'year' => $order->creditcard_year));
			$items = $this->session->userdata('cart');
			$order->total = calculate_total($this, $items);
			$data['order_details'] = $order;
			$data['items'] = $items;

			load_view($this,'cart/checkout_summary.php', $data);

		} else {
			load_view($this,'cart/checkout_form.php');
		}
	}

	function _validate_date($month){

		// Get the last date of the expiry date of the card
		$month = $this->input->get_post('month');
		$year = $this->input->get_post('year');
		$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);


		$today = new DateTime("now");
		$exp_date = new DateTime ($year. "-" . $month . "-" . $day);

		if (!($today < $exp_date)){
			$this->form_validation->set_message('_validate_date',
				'Expired credit card. Please a card with a future expiration date.');
			return false;
		}
		return true;
	}

	function checkout(){
		$this->session->set_userdata('cart', array());
		$this->load->model('order_model');
		$this->load->model('order_item_model');
		$data = json_decode($this->input->get_post('json'));
		$order_details = $data->order_details;
		$items = $data->items;
		
		if ($this->order_model->insert($order_details)){
			$new_order_id = $this->db->insert_id();
		
			if (!empty($items)){
			foreach ($items as $item){
				$order_item = new Order_Item();
				$order_item->order_id = $new_order_id;
				$order_item->product_id = $item->product_id;
				$order_item->quantity = $item->quantity;
				$this->order_item_model->insert($order_item);
			}}
			$this->output->set_output($new_order_id);
		}

	}

	function receipt($order_id) {
		$this->load->model('order_model');
		$this->load->model('order_item_model');
		// get order		
		$order = $this->order_model->get($order_id);
		// get items
		$items = $this->order_item_model->get_order($order_id);
		load_view($this, 'cart/receipt.php', array (
			'order_details' => $order,
			'items' => $items));
	}


}
