<h1>Checkout Summary</h1>
<?php

echo "<p>" . anchor('cart/checkout_form','Back') . "</p>";
echo "<p>" . anchor('cart/','Cancel') . "</p>";
echo "<h4> Total : " . $order_details->total . "</h4>";
foreach (array_keys($items) as $item_key) {
	echo "<p> Product Name : " . $items[$item_key]['name'] . "<p>";
	echo "<span class=\"quantity\"> Quantity : " . $items[$item_key]['quantity'] . "</span>";
}
echo "<br>";
echo "<br>";

echo "<h4> Payment information </h4>";
echo "<p> Credit card number : " . $order_details->creditcard_number . "<p>";
echo "<p> Expiry date : " . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</span>";

echo "<br>";
echo "<br>";

echo "<p id=\"purchase-link\">" . "Confirm" . "</p>";

?>

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
				location.replace("<?= site_url('store') ?>");
			});
	});
});
</script>
