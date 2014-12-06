<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('asset_url()')){
	/*
	 * Return the url with static assets, e.g. css & js
	 */
	function assets_url($type="", $path="") {
		$assets_url = base_url().'assets/';
		if ($path && $type) return $assets_url.$type.'/'.$path;
		else if ($path) return $assets_url.'/'.$path;
		else if ($type) return $assets_url.'/'.$type.'/';
		return base_url().'assets/';
	}

	function js_url($path="") {
		if ($path) return assets_url("js", $path);
		return assets_url("js");
	}

	function css_url($path="") {
		if ($path) return assets_url("css", $path);
		return assets_url("css");
	}

}

if (!function_exists('load_view()')){
	/* 
	 * Takes a controller, template name & data (optional), returning HTML
	 * with header & footer sandwiches around the view with its data
	 */
	function load_view($c, $template, $data=false){
		$c->load->view('templates/header.php');
		if ($data) $c->load->view($template, $data);
		else $c->load->view($template);
		$c->load->view('templates/footer.php');
	}
}

