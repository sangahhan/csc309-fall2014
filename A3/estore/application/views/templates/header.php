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
		<span id="site-name"><a href="<?php echo base_url(); ?>">eStore</a></span>
<?php 
if (is_logged_in($this->session)){
	echo "<ul id=\"main-nav\">";	
	if (is_admin($this->session)){
		echo "<li>" . anchor('#', 'Inventory') . "</li>";
		echo "<li>" . anchor('#', 'Orders') . "</li>";
		echo "<li>" . anchor('#', 'Customers') . "</li>";
	} else {
		echo "<li>" . anchor(site_url('cart'), 'Cart') . "</li>";
	}
	echo "<li>" . anchor("auth/logout",'Logout') . "</li>";
	echo "</ul>";
}
?>
		</div>
		<div id="main-wrapper">
		<div id="main">
