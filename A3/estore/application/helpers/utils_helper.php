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
	/* Given a controller, if a user is not logged in, indicate to login and
	 * return false. Else return true.
	 */
	function authenticate_login($cont){
		if(! is_logged_in($cont->session)){
			load_view($cont, 'auth/permission_denied.php');
			return false;
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
			load_view($cont, 'auth/logged_in_user.php');
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
			load_view($cont, 'auth/admin_priv_needed.php');
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

?>
