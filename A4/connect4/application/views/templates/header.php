<!DOCTYPE html>
<html>
	<head>
		<title>Assignment 4: Connect 4</title>
		<meta charset="utf-8">
		<meta name="description" content="Connect 4 for g2sangah & g3tdirty's submission of A4, CSC309 Fall 2014">
		<meta name="viewport" content="width=device-width, initial-scale=1">

		<link href="<?= css_url('template.css');?>" type="text/css" rel="stylesheet">
<script src="<?= js_url('jquery.min.js') ?>"></script>
<script src="<?= js_url('jquery.timers.js') ?>"></script>
<script src="<?= js_url('connect4.js') ?>"></script>
	</head>
	<body>
		<div id="header">
		<div id="header-wrapper">
		<span id="site-name"><a href="<?php echo base_url(); ?>">Connect&#32;4</a></span>
<?php 

	// construct a menu area if the user is logged in
	echo "<div id=\"main-nav\">";

	// dropdown menu button for document width < 600
	echo "<div id=\"menu-button\">";
	echo str_repeat("<div class=\"menu-button-bar\"></div>", 3); 
	echo "</div>";

	$links = "<li>" . anchor(site_url('arcade'), 'Link1') . "</li>" . 
			"<li>" . anchor(site_url('board'), 'Link2') . "</li>" . 
			"<li>" . anchor(site_url('account'), 'Link3') . "</li>";

	$link_logout = "<li>" . anchor("account/logout",'Logout') . "</li>";

	echo "<ul id=\"links\">";	
	echo $links.$link_logout;
	echo "</ul>";
	echo "</div>";	


	echo "<div id=\"dropdown\">";
	echo "<ul>";	
	echo $links.$link_logout;
	echo "</ul>";
	echo "</div>";

?>
		</div> <!-- end header-wrapper -->
		</div> <!-- end header -->
		<div id="main-wrapper">
		<div id="main">
<!-- begin content -->
