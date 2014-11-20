<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
if ( ! function_exists('asset_url()')){
	/* Return the url with static assets, e.g. css & js
	 */
	function assets_url() {
		return base_url().'assets/';
	}
}

if ( ! function_exists('load_view()')){
	/*
	 * Takes a controller, view name and data (optional), returning HTML
	 * with header & footer sandwiched around view with its data
	 */
	function load_view($cont, $view_name, $data=false){
		$cont->load->view('templates/header.php');
		if (isset($data)) $cont->load->view($view_name, $data);
		else $cont->load->view($view_name);
		$cont->load->view('templates/footer.php');
	}
}

if ( ! function_exists('load_product_list()')){
	/*
	 * Given a controller, load the product list for the store.
	 */
	function load_product_list($cont){
		$cont->load->model('product_model');
		$products = $cont->product_model->getAll();
		$data['products']=$products;
		load_view($cont, 'product/list.php',$data);
	}
}
if ( ! function_exists('is_logged_in()')){
	/*
	 * Return if the current session is logged in to by a user.
	 */
	function is_logged_in($session){
		return $session->userdata('logged_in');
	}
}
if ( ! function_exists('is_admin()')){
	/*
	 * Return true of the current user is the admin. Otherwise, return false.
	 */
	function is_admin($session){
		return $session->userdata('username') == 'admin';
	}
}
if ( ! function_exists('authenticate_login()')){
	/*
	 * Given a controller, if a user is not logged in, redirect to login. Else
	 * return true.
	 */
	function authenticate_login($cont){
		if(! is_logged_in($cont->session)){
			$cont->session->set_flashdata('redirect', 1);
			redirect('auth', 'refresh', 401);
		}
		return true;
	}
}

if ( ! function_exists('check_logged_out()')){
	/*
	 * Given a controller, if a user is already logged in display the view to
	 * indicate it and return false, Otherwise, return true.
	 */
	function check_logged_out($cont){
		if(is_logged_in($cont->session)){
			load_error_view($cont, 'store', '403', 'You are already logged in. To register or login as a new user, please logout first.');
			return false;
		}
		return true;
	}
}


if ( ! function_exists('authenticate_admin()')){
	/*
	 * Given a controller, if the user is not an admin user, indicate that
	 * The user needs admin permissions and return false. Else, return true.
	*/
	function authenticate_admin($cont){
		if(! is_admin($cont->session)){
			load_error_view($cont, 'store', '403', 'To view this page, administrative privileges are required.');
			return false;
		}
		return true;
	}
}

if ( ! function_exists('authenticate_non_admin()')){
	/*
	 *Given a controller, if the logged in user is an admin user, indicate that
	* The user cannot checkout items from the store.
	*/
	function authenticate_non_admin($cont){
		if(is_admin($cont->session)){
			load_error_view($cont, 'store', '403', 'Admin users cannot use the shopping cart functionalities');
			return false;
		}
		return true;
	}
}

if ( ! function_exists('load_cart_view()')){
	/*
	* Given a controller, load the cart items.
	*/
	function load_cart_view($cont){

		$items = $cont->session->userdata('cart');
		$data['items'] = $items;
		$data['total'] = calculate_total($cont, $items);
		load_view($cont, 'cart/cart.php', $data);
	}
}

if ( ! function_exists('calculate_total()')){
	/*
	* Given a controller, return the total price of all the items in the cart.
	*/
	function calculate_total($cont, $items){
		$cont->load->model('product_model');
		$total = 0;
		foreach (array_keys($items)  as $item_key){
			$product = $cont->product_model->get($item_key);
			$total = $total + ($product->price * $items[$item_key]['quantity']);
		}

		return $total;
	}
}

if (! function_exists('get_print_page()')) {
	/*
	* Given a controller, return the html content of the reciept to be
	* printed
	*/
	function get_print_page($cont, $content, $order_id, $print=false, $trim=false){
		$data = array (
			'content' => $content,
			'order_id' => $order_id,
			'print' => $print
		);
		$html = $cont->load->view('cart/print_receipt.php', $data, true);
		if ($trim) return trim(str_replace(PHP_EOL, '', $html));
		return $html;
	}
}


if ( ! function_exists('send_email()')){
	/*
	* Send an email to the current logged in customer with message as the email
	* content. If the email is successfully sent, return TRUE. Else, return False.
	*/
	function send_email($cont, $message, $email){


    // Loads the email library
	$cont->load->library('email');

    	// Defines the email details
	$cont->email->from("estore309@gmail.com", 'eStore');
	$cont->email->to($email);
	$cont->email->subject('eStore Receipt');
    	$cont->email->message($message);

    	// If true, the email will be sent
    	if ($cont->email->send()) {
    		return TRUE;
    	} else {
    		return FALSE;
    	}
	}
}


if ( ! function_exists('get_email_content()')){
	/*
	* Given a controller and an order, create the content of an email reciept
	* to be sent to the customer.
	*/
	function get_email_content($cont, $order){

		$content = "";
		if (isset($order)){
			$data = array();
			$data['order_details'] = $order;
			
			$cont->load->model('order_item_model');
			$items = $cont->order_item_model->get_order($order->id);
			$data['items'] = $items;


			$cont->load->model('customer_model');
			$customer = $cont->customer_model->get($order->customer_id);
			$data['customer'] = $customer;

			$content = $cont->load->view('cart/email.php', $data, true);
		}
		return $content;
	}
}


if ( ! function_exists('load_error_view()')){
	/*
	 * Given a controller, a return location and an error title, load an error
	 * view.
	 */
	function load_error_view($cont, $return, $title, $msg=false){

		if ($return == 'auth'){
			$link = "/auth";
			$phrase = 'login page';
		} else if ($return == 'cart'){
			$link = "/cart";
			$phrase = 'cart';
		} else if ($return == 'customers'){
			$link = '/customers';
			$phrase = 'customer page';
		} else if ($return == 'orders'){
			$link = '/orders';
			$phrase = 'orders';
		} else {
			$link = '/store';
			$phrase = 'store';
		}

		$data['return_link'] = $link;
		$data['return_phrase'] = $phrase;


		if (!$msg and $title == "403"){
			$msg = "You do not have permission to view this content";
		} else if (!$msg){
			$msg = "Sorry! The page you are looking for does not exist.";
		}

		$data['err_msg'] = $msg;

		if ($title == "404"){
			$data['title'] = "404 Page not found!";
			$cont->output->set_header("HTTP/1.1 404 Not Found");
		} else if ($title == "403"){
			$data['title'] = "403 Permission denied!";
			$cont->output->set_header("HTTP/1.1 403 Forbidden");
		} else if ($title == "error"){
			$data['title'] = "Error!";
		} else {
			$data['title'] = "Sorry!";
		}


		load_view($cont,'templates/error.php', $data);
	}
}


?>
