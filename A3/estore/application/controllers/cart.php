<?php

/*
 * This controller contains the functionalities for the shopping cart such as
 * adding/removing items from it and the checkout process. The "admin" user does
 * not have permission to carry out cart functionalities expect for the
 * reciept.
 */
class Cart extends CI_Controller {


	function __construct() {
		// Call the Controller constructor
		parent::__construct();
		date_default_timezone_set('America/New_York');
	}

	/*
	 * Display all the elements in the cart. If there are none, the view
	 * indicates a link to return back to the store.
	 */
	function index() {

		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}
		load_cart_view($this);
	}

	/*
	 * Given a product id, if the product doesn't already exist in the user's cart,
	 * add the price, quantity and the name of the product to the cart. If it
	 * already exist, increment the quanitity of the product in the cart
	 */
	function add_to_cart($product_id){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$items = $this->session->userdata('cart');

		if (array_key_exists($product_id, $items)){
			$item = & $items[$product_id];
			$item['quantity'] = $item['quantity'] + 1;
		} else {
			// If the product doesn't arleady exist.
			$this->load->model('product_model');
			$product = $this->product_model->get($product_id);
			if (isset($product)){
				$items[$product_id] = array("name" => $product->name,
					"quantity" => 1,
					"price" => $product->price);
			} else {
				// If the given product id is invalid, then load an error view
				load_error_view($this, 'store', '404');
				return;
			}
		}

		// Update the session variable. Since this method is called from the
		// store (as opposed to from within the cart view), we return to
		// the view with the store products
		$this->session->set_userdata('cart', $items);
		load_product_list($this);
	}

	/*
	 * Given a product id, if an item with the given id already exists in the
	 * cart, reduce the quantity by 1. Otherwise, it is an invalid id and
	 * therefore load an error view
	 */
	function reduce_from_cart($product_id){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
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
			load_error_view($this, 'cart', '404');;
			return;
		}

		$this->session->set_userdata('cart', $items);

		// The controller is called from within the cart. so return to the
		// shopping cart
		load_cart_view($this);
	}


	/*
	 * Given a product id, if an item with the given id already exists in the
	 * cart, increase the quantity by 1. Otherwise, it is an invalid id and
	 * therefore load an error view
	 */
	function increase_in_cart($product_id){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$items = $this->session->userdata('cart');

		if (array_key_exists($product_id, $items)){
			$item = & $items[$product_id];
			$item['quantity'] = $item['quantity'] + 1;
		} else {
			load_error_view($this, 'cart', '404');
			return;
		}

		$this->session->set_userdata('cart', $items);

		load_cart_view($this);
	}

	/*
	 * Given a product id, if an item with the given id already exists in the
	 * cart, remove the item form the cart entirely. Otherwise, it is an invalid
	 * id and therefore load an error view
	 */
	function remove_from_cart($product_id){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$items = $this->session->userdata('cart');

		if (array_key_exists($product_id, $items)){
			$item = & $items[$product_id];
			unset($items[$product_id]);
		} else {
			load_error_view($this, 'cart', '404');
			return;
		}

		$this->session->set_userdata('cart', $items);

		load_cart_view($this);
	}

	/* If the current cart is not empty, carry on to the checkout form to
	 * get the users credit card information. Otherwise, load an error
	 * view indicating that the user cannot checkout an empty cart
	 */
	function checkout_form(){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$items = $this->session->userdata('cart');
		if (! $items or empty($items)) {
			load_error_view($this, 'store', 'generic',
				"In order to proceed with checkout, you need a non empty shopping cart.");
			return;
		};

		load_view($this, 'cart/checkout_form.php');

	}

	/* Get all the information from the checkout form and validate it.
	 * If the form is valid, load a checkout summary for the user
	 * to confirm. If the form is not valid, then load the form again.*/
	function checkout_summary(){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$items = $this->session->userdata('cart');
		if (! $items or empty($items)) {
			load_error_view($this, 'store', 'generic',
				"In order to proceed with checkout, you need a non empty shopping cart.");
			return;
		};


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

	/*
	 * The month given as the parameter is not used. Instead, get the
	 * month and the year in the posted information and return true if
	 * the last date of that month is after the current date and false otherwise
	 */
	function _validate_date($year){

		// Get the last date of the expiry date of the card
		$month = $this->input->get_post('month');
		$year = $this->input->get_post('year');
		$day = cal_days_in_month(CAL_GREGORIAN, $month, $year);


		$today = new DateTime("now");
		$exp_date = new DateTime ($year. "-" . $month . "-" . $day);

		if (!($today < $exp_date)){
			$this->form_validation->set_message('_validate_date',
				'Expired credit card. Please provide a card with a future expiration date.');
			return false;
		}
		return true;
	}

	/*
	 * If there is no order information set in the session, then the user has
	 * not yet typed in any credit card information and therefore load an error
	 * view.
	 * If both the order info and cart items exist, then create an Order object and
	 * the required Order items and insert in to the database. If the transaction
	 * is successfull, then email the user a copy of the reciept and direct the
	 * user to the receipt within the browser as well. Before redirecting,
	 * reset the order cart and remove the order details from the session info
	 */
	function checkout(){
		if (!authenticate_login($this) or !authenticate_non_admin($this)){
			return;
		}

		$order_info = $this->session->userdata('order_info');
		$items = $this->session->userdata('cart');
		if (! $order_info){
			load_error_view($this, 'cart', 'error',
				"Unfortunately, there has been an error in the checkout process. Please retry.");
		} elseif (! $items or empty($items)) {
			load_error_view($this, 'store', 'generic',
				"In order to proceed with checkout, you need a non empty shopping cart.");
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

			// Adding of the order and the order items is a transaction
			$this->db->trans_begin();

			$this->order_model->insert($order);
			$new_order_id = $this->db->insert_id();
			$order->id = $new_order_id;

			foreach (array_keys($items) as $item_key) {
				$order_item = new Order_Item();
				$order_item->order_id = $new_order_id;
				$order_item->product_id = $item_key;
				$order_item->quantity = $items[$item_key]['quantity'];
				$this->order_item_model->insert($order_item);
			}

			// If the insertions fail, then rollback and load an error view
			// Otherwise, commit the data to the db, reset cart variables.
			// Send the reciept to users email and redirect to the
			// reciept view to be viewed in the browser as well.
			if ($this->db->trans_status() === FALSE){
				$this->db->trans_rollback();
				load_error_view($this, 'cart', 'error',
					"Unfortunately, there has been an error in the checkout process. Please retry.");
			} else {
				$this->db->trans_commit();
				// now hide 12 digits of card number from output
				$order->creditcard_number = '**** **** **** ' . substr($order->creditcard_number, 12);
				$content = get_email_content($this, $order);
				$message = get_print_page($this, $content, $order->id);

				$this->load->model('customer_model');
				$customer = $this->customer_model->get($this->session->userdata('user_id'));
				$status = send_email($this, $message, $customer->email);

				// Indicates whether the email was successfully sent
				$this->session->set_userdata('email_sent', $status);

				$this->session->set_userdata('cart', array());
				$this->session->set_userdata('total', 0);
				redirect('cart/receipt/'.$new_order_id, 'refresh');
			}
		}
	}

	/*
	 * Given an order id, display its customer, order and order item details
	 * If the order id is invalid, load an error view.
	 * If the order id does not belong to the current user, load a permission
	 * denied view.
     */
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
		if ($order){
			$order->creditcard_number = '**** **** **** ' . substr($order->creditcard_number, 12);
			// Only the admin and the owner of the order can see the receipt
			if ($order->customer_id == $user_id or is_admin($this->session)){
				$data['order_details'] = $order;

				$items = $this->order_item_model->get_order($order_id);
				$data['items'] = $items;

				$customer = $this->customer_model->get($user_id);
				$data['customer'] = $customer;

				// The content for the reciept for the printer friendly version
				$content = $this->load->view('templates/receipt_contents.php', $data, true);

				// printable content is used when the user clicks on the print option.
				$printable_content = get_print_page($this, $content, $order->id, true, true);
				
				load_view($this, 'cart/receipt.php',
					array(
						'content' => $content,
						'printable_content' => $printable_content
					));
			} else {
				load_error_view($this, 'store', '403');
			}
		} else {
			load_error_view($this, 'cart', '404');
		}
	}
}
