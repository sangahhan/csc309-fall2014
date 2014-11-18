<h1>Checkout Summary</h1>
<?php

echo "<p>" . anchor('cart/checkout_form','Back to payment') .  "</p>";
if (count($items)){
echo "<h2>Items</h2>";
foreach (array_keys($items) as $item_key) {
	echo "<div class=\"cart-cell\">";
	echo "<div class=\"info\">";
	echo "<h3>" . $items[$item_key]['name'] . "</h3>";
	echo "<p><strong>Product ID: </strong>" . $item_key . "</p>";
	echo "<p><strong>Unit Price: </strong>$" . $items[$item_key]['price'] . "</p>";
	echo "</div>";
	echo "<div class=\"quantity-control\">";
	echo "<p><strong>Quantity: </strong>" . $items[$item_key]['quantity'] . "</p>";
	echo "<p><strong>Subtotal: </strong>$" . $items[$item_key]['quantity'] * $items[$item_key]['price'] . "</p>";
	echo "</div>";
	echo "<div class=\"clearfix\"></div>";
	echo "</div>";
}
echo "<div id=\"cart-total\"><div id=\"summary-total\"><strong>Total: </strong>$" . $order_details->total . "</div><div class=\"clearfix\"></div></div>";
}
echo "<h2>Payment information</h2>";
	echo "<div class=\"cart-cell\">";
	echo "<div class=\"info\">";
echo "<p><strong>Credit card number: </strong>" . $order_details->creditcard_number . "<p>";
echo "<p><strong>Expiry date: </strong>" . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</span>";
echo "</div>";
echo "<div class=\"clearfix\"></div>";
echo "</div>";
echo "<br />";
echo "<a href=\"#\" id=\"purchase-link\" class=\"button\">" . "Confirm" . "</a>";
	
?>
<!-- TODO: clean up this JS -->
<script>
$(function(){
	var data = {};
	data['order_details'] = <?= json_encode($order_details) ?>;
	var items = [];
<?php 	
foreach (array_keys($items) as $item_key) {
?>
	items.push({
	'product_id': <?= $item_key ?>,
		'quantity': <?= $items[$item_key]['quantity']?>
}
);
<?php 
}
?>
	data['items'] = items;
	$('#purchase-link').click(function(){
		$.post(
			"<?= site_url('cart/checkout')?>", 
			"json=" + JSON.stringify(data), 
			function (data) {
				location.replace("<?= site_url('cart/receipt') ?>/" + data);
			});
	});
});
</script>
