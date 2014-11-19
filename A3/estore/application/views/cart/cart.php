<h1>Shopping Cart</h1>
<?php
if (count($items)){
	echo "<p>" . anchor(site_url('store'),'Back to store') . "</p>";
	foreach (array_keys($items) as $item_key) {
		echo "<div class=\"cart-cell\">";	
		echo "<div class=\"info\">";

		echo "<h2>" . anchor(site_url('store/read') . "/$item_key", $items[$item_key]['name']) . "</h2>";
		echo "<p><strong>Unit price: </strong>$" . number_format($items[$item_key]['price'], 2) . "</p>";
		echo "<p><strong>Subtotal: </strong>$" . number_format($items[$item_key]['quantity'] * $items[$item_key]['price'], 2) . "</p>";
		echo "</div>";
		echo "<div class=\"quantity-control\">";
		echo "<span class=\"spinner\">" . anchor("cart/reduce_from_cart/$item_key",'-', array('class' => 'button')) . "</span>"; 
		echo "<span class=\"quantity\">" . $items[$item_key]['quantity'] . "</span>";
		echo "<span class=\"spinner\">" . anchor("cart/increase_in_cart/$item_key",'+', array('class' => 'button')) . "</span>";
		echo "</div>";
		echo "<ul class=\"actions\">";

		echo "<li>" . anchor("store/read/$item_key",'View') . "</li>";
		echo "<li>" . anchor("cart/remove_from_cart/$item_key",'Remove') . "</li>";
		echo "</ul>";
		echo "</div>";
	}
	echo "<div id=\"cart-total\">";
	echo "<div id=\"total\"><strong>Total: </strong>$" . number_format($total, 2)  . "</div>";
	echo "<div id=\"checkout\">";
	echo anchor(site_url('cart/checkout_form'), 'Checkout', array('class' => 'button'));
	echo "</div>";
	echo "</div>";

} else {
	echo "<p>You don't have anything in your cart! Go to " . anchor(site_url('store'), 'the store') . " to add to your cart!</p>";
}
?>
