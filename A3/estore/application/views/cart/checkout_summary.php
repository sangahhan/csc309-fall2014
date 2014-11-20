<h1>Checkout Summary</h1>
<?php
// view to show checkout summary
echo "<p>" . anchor('cart/checkout_form','Back to payment') .  "</p>";
if (count($items)){
	echo "<h2>Items</h2>";
	foreach (array_keys($items) as $item_key) {
		echo "<div class=\"cart-cell\">";
		echo "<div class=\"info\">";
		echo "<h3>" . anchor(site_url('store/read') . "/$item_key", $items[$item_key]['name'], 'target="_blank"') . "</h3>";
		echo "<p><strong>Product ID: </strong>" . $item_key . "</p>";
		echo "<p><strong>Unit Price: </strong>$" . number_format($items[$item_key]['price'],2) . "</p>";
		echo "</div>";
		echo "<div class=\"quantity-control\">";
		echo "<p><strong>Quantity: </strong>" . $items[$item_key]['quantity'] . "</p>";
		echo "<p><strong>Subtotal: </strong>$" . number_format($items[$item_key]['quantity'] * $items[$item_key]['price'], 2) . "</p>";
		echo "</div>";
		echo "<div class=\"clearfix\"></div>";
		echo "</div>";
	}
	echo "<div id=\"cart-total\"><div id=\"summary-total\"><strong>Total: </strong>$" . number_format($order_details->total, 2) . "</div><div class=\"clearfix\"></div></div>";
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
echo "<p>" . anchor('cart/checkout','Confirm', 'class="button"') .  "</p>";
	
?>
