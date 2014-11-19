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
	/* Takes a controller, view name and data (optional), returning HTML
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
	function load_product_list($cont){
		$cont->load->model('product_model');
		$products = $cont->product_model->getAll();
		$data['products']=$products;
		load_view($cont, 'product/list.php',$data);
	}
}
if ( ! function_exists('is_logged_in()')){
	function is_logged_in($session){
		return $session->userdata('logged_in');
	}
}
if ( ! function_exists('is_admin()')){
	function is_admin($session){
		return $session->userdata('username') == 'admin';
	}
}
if ( ! function_exists('authenticate_login()')){
	/* Given a controller, if a user is not logged in, redirect to login. Else return true.
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
	/* Given a controller, if a user is already logged in display the view to
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
	/* Given a controller, if the user is not an admin user, indicate that
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
	/* Given a controller, if the is an admin user, indicate that
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
	function load_cart_view($cont){

		$items = $cont->session->userdata('cart');
		$data['items'] = $items;
		$data['total'] = calculate_total($cont, $items);
		load_view($cont, 'cart/cart.php', $data);
	}
}

if ( ! function_exists('calculate_total()')){
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
	function get_print_page($cont, $content, $order_id, $print=false, $trim=false){
		$data = array (
			'content' => $content,
			'order_id' => $order_id,
			'print' => $print
		);
		$html = $cont->load->view('templates/print_page.php', $data, true);
		if ($trim) return trim(str_replace(PHP_EOL, '', $html));
		return $html;
	}
}

/*
 * Send an email to the current logged in customer with message as the email
 * content. If the email is successfully sent, return TRUE. Else, return False.
 */
if ( ! function_exists('send_email()')){
	function send_email($cont, $message, $email){

	// Define email config
		$config = array (
		'protocol' => 'mail',
		'mailtype' => 'html',
		'charset' => 'utf-8',
		'priority' => '3', 
		'wordwrap' => false
	);
    	// Loads the email library
	$cont->load->library('email');
	$cont->email->initialize($config);

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

/*
 * Given an order, create the content of an email reciept to be sent to the customer.
 */
if ( ! function_exists('get_email_content()')){
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

			$content = $cont->load->view('templates/email.php', $data, true);
		}
		return $content;
	}
}

/*
* Given an order, create the content of an email reciept to be sent to the customer.
*/
if ( ! function_exists('load_error_view()')){
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
