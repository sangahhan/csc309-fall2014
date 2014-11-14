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
?>
