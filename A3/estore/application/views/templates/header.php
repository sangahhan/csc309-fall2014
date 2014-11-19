<!DOCTYPE html>
<html>
	<head>
		<title>Assignment 3: eStore</title>
		<meta charset="utf-8">
		<meta name="description" content="eStore for g2sangah & g3tdirty's submission of A3, CSC309 Fall 2014">
		<link href="<?php echo assets_url();?>css/template.css" type="text/css" rel="stylesheet">
<script src="<?php echo assets_url();?>js/jquery.min.js"></script>
<script src="<?php echo assets_url();?>js/estore.js"></script>
	</head>
	<body>
		<div id="header">
		<div id="header-wrapper">
		<span id="site-name"><a href="<?php echo base_url(); ?>">eStore</a></span>
<?php 
if (is_logged_in($this->session)){

	echo "<div id=\"main-nav\">";
	echo "<div id=\"menu-button\">";
	echo str_repeat("<div class=\"menu-button-bar\"></div>", 3);
	echo "</div>";
	echo "<ul id=\"links\">";	
	if (is_admin($this->session)){
		echo "<li>" . anchor(site_url('store'), 'Inventory') . "</li>";
		echo "<li>" . anchor(site_url('orders'), 'Orders') . "</li>";
		echo "<li>" . anchor(site_url('customers'), 'Customers') . "</li>";
	} else {
		echo "<li>" . anchor(site_url('store'), 'Products') . "</li>";
		echo "<li>" . anchor(site_url('cart'), 'Cart') . "</li>";
	}
	echo "<li>" . anchor("auth/logout",'Logout') . "</li>";
	echo "</ul>";
	echo "</div>";	
	echo "<div id=\"dropdown\">";
	echo "<ul>";	
	if (is_admin($this->session)){
		echo "<li>" . anchor(site_url('store'), 'Inventory') . "</li>";
		echo "<li>" . anchor(site_url('orders'), 'Orders') . "</li>";
		echo "<li>" . anchor(site_url('customers'), 'Customers') . "</li>";
	} else {
		echo "<li>" . anchor(site_url('store'), 'Products') . "</li>";
		echo "<li>" . anchor(site_url('cart'), 'Cart') . "</li>";
	}
	echo "<li>" . anchor("auth/logout",'Logout') . "</li>";
	echo "</ul>";
	echo "</div>";
}
?>
</div>
		</div>
		<div id="main-wrapper">
		<div id="main">
