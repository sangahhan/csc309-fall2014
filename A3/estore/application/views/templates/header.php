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
		if (!check_logged_out($this)){
?>	
		<ul id="main-nav">
			<li><a href="#">Inventory</a></li>
			<li><a href="#">Orders</a></li>
			<li><a href="#">Customers</a></li>
			<li><?= anchor("auth/logout",'Logout') ?></li>
		</ul>
<?php 
		}
?>
		</div>
		<div id="main-wrapper">
		<div id="main">
