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

if ( ! function_exists('authenticate_login()')){
	/* Given a controller, if a user is not logged in, indicate to login and
	 * return false. Else return true.
	 */
	function authenticate_login($cont){
		if(!$cont->session->userdata('logged_in')){
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
		if($cont->session->userdata('logged_in')){
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
		if($cont->session->userdata('username') != 'admin'){
			load_view($cont, 'auth/admin_priv_needed.php');
			return false;
		}
		return true;
	}
}


?>
