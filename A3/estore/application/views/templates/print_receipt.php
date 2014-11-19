<html>
<head>
<title>eStore: Receipt for Order #<?= $order_id ?></title> 
<style>
@media print { .print-omit {display: none !important;} }
.cart-cell {border: 1px solid black; margin: 0 0 1em 0; padding: 0.5em; }
.cart-cell p, .cart-cell h3 {margin: 0.2em;}
.cart-cell .info { float: left; }
.cart-cell .quantity-control, #cart-total #summary-total { float: right; }
.clearfix { clear: both; }
</style>
</head><body style="padding: 0.25em;font-family: Arial,"Helvetica Neue",Helvetica,sans-serif; color: black; background: white;">
<div style="font-size: 2.75em; font-weight: bold;">eStore</div>
<?php
if (isset($print) && $print) {
	echo '<p class="print-omit"><input type="button" onclick="window.print()" value="Print" /> <input type="button" onclick="window.close()" value="Close Window" /></p>';
}
echo $content;
?>
</body>
</html>


