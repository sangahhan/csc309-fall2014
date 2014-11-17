<h1>Shopping Cart</h1>
<?php
echo "<p>" . anchor('store/','Back') . "</p>";
$sum = 0;
foreach (array_keys($items) as $item_key) {
	
	echo "<h3>". $items[$item_key]['name'] . " (". $items[$item_key]['quantity'] . ")</h3>";
	$sum = $sum + ($items[$item_key]['quantity'] * $items[$item_key]['price']);
	echo "<ul class=\"actions\">";
	
	echo "<li>" . anchor("store/read/$item_key",'View') . "</li>";
	echo "<li>" . anchor("cart/increase_in_cart/$item_key",'Increase') . "</li>";
	echo "<li>" . anchor("cart/reduce_from_cart/$item_key",'Decrease') . "</li>";
	echo "<li>" . anchor("cart/remove_from_cart/$item_key",'Remove') . "</li>";
	echo "</ul>";
}

	echo "Total: " . $sum;
?>
