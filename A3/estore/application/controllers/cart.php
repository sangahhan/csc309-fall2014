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
		if (!authenticate_login($this)){
			return;
		}

		$this->load->library('form_validation');

		$this->form_validation->set_rules('creditcard_number','Credit card number',
			'required|min_length[16]|max_length[16]');
		$this->form_validation->set_rules('creditcard_year','Credit card year',
			'callback__validate_date');


		if ($this->form_validation->run() == true) {

			$order = new Order();
			$order->creditcard_number = $this->input->get_post('creditcard_number');
			$order->creditcard_month = $this->input->get_post('month');
			$order->creditcard_year = $this->input->get_post('year');

			$items = $this->session->userdata('cart');
			$order->total = calculate_total($this, $items);

			$data['order_details'] = $order;
			$data['items'] = $items;

			$this->session->set_userdata('order_info', array(
				'number' => $order->creditcard_number,
				'month' =>  $order->creditcard_month,
				'year' => $order->creditcard_year,
				'total' => $order->total));

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
		if (!authenticate_login($this)){
			return;
		}

		$order_info = $this->session->userdata('order_info');
		$items = $this->session->userdata('cart');
		if (! $order_info){
			//TODO
			load_view($this, 'auth/generic_error.php',
				array("Unfortunately, there has been an error in the checkout process. Please retry."));
		} elseif (! $items or empty($items)) {
			// TODO:
			load_view($this, 'auth/generic_permission_denied.php',
				array("In order to proceed with checkout, you need a non empty shopping cart."));
		} else {
			$this->load->model('order_model');
			$this->load->model('order_item_model');

			$now = new DateTime("now");

			$order = new Order();
			$order->customer_id = $this->session->userdata('user_id');
			$order->order_time = $now->format('H:i:s');
			$order->order_date = $now->format('Y-m-d');
			$order->total = $order_info['total'];
			$order->creditcard_number = $order_info['number'];
			$order->creditcard_year = $order_info['year'];
			$order->creditcard_month = $order_info['month'];

			$data = array('order_info' => array());
			$this->session->unset_userdata($data);

			$this->db->trans_begin();

			$this->order_model->insert($order);
			$new_order_id = $this->db->insert_id();

			foreach (array_keys($items) as $item_key) {
				$order_item = new Order_Item();
				$order_item->order_id = $new_order_id;
				$order_item->product_id = $item_key;
				$order_item->quantity = $items[$item_key]['quantity'];
				$this->order_item_model->insert($order_item);
			}

			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				// TODO: Redirect back to cart.
				load_view($this, 'auth/generic_error.php',
				array("Unfortunately, there has been an error in the checkout process. Please retry."));
			} else {
    			$this->db->trans_commit();

				$message = get_email_content($this, $order);

				$this->load->model('customer_model');
				$customer = $this->customer_model->get($this->session->userdata('user_id'));
				$status = send_email($this, $message, $customer->email);

				// TODO: Print out the staus of the email in the reciept. If the
				// email wasnt sent, tell them to print the receipt for sure?
				$this->session->set_userdata('email_error', $status);

				$this->session->set_userdata('cart', array());
				$this->session->set_userdata('total', 0);
				redirect('cart/receipt/'.$new_order_id, 'refresh');
    		}
		}
	}

	function receipt($order_id) {
		if (!authenticate_login($this)){
			return;
		}

		$this->load->model('order_model');
		$this->load->model('order_item_model');
		$this->load->model('customer_model');
		// get order
		$order = $this->order_model->get($order_id);
		$user_id = $this->session->userdata('user_id');
		if (isset($order)){
			if ($order->customer_id == $user_id){
				$data['order_details'] = $order;

				$items = $this->order_item_model->get_order($order_id);
				$data['items'] = $items;

				$customer = $this->customer_model->get($user_id);
				$data['customer'] = $customer;

				load_view($this, 'cart/receipt.php', $data);
			} else {
				//TODO
				load_view($this, 'auth/generic_permission_denied.php',
					array("You do not have permission to view this content."));
			}
		} else {
			load_view($this, 'auth/non_existent.php');
		}
	}
}
