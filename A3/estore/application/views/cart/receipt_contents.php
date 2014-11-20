<?php
// View for body of displayed + print version of receipt
echo "<h1>Receipt for Order #" . $order_details->id . "</h1>";
echo "<h2>Customer Information</h2>";
echo "<div class=\"cart-cell\">";
echo "<div class=\"info\">";
echo "<p><strong>Name: </strong>" . $customer->first . " " . $customer->last . "<p>";
echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
echo "<p><strong>Username: </strong>" . $customer->login . "</p>";
echo "</div>";
echo "<div class=\"clearfix\"></div>";
echo "</div>";
// if the purchase has items, grab and display items in tables
if (count($items)){
	echo "<h2>Items</h2>";
	foreach ($items as $item) {
		echo "<div class=\"cart-cell\">";
		echo "<div class=\"info\">";
		echo "<h3>" . $item->name . "</h3>";
		echo "<p><strong>Product ID: </strong>" . $item->product_id . "</p>";
		echo "<p><strong>Unit Price: </strong>$" . number_format($item->price, 2) . "</p>";
		echo "</div>";
		echo "<div class=\"quantity-control\">";
		echo "<p><strong>Quantity: </strong>" . $item->quantity . "</p>";
		echo "<p><strong>Subtotal: </strong>$" . number_format($item->quantity * $item->price, 2) . "</p>";
		echo "</div>";
		echo "<div class=\"clearfix\"></div>";
		echo "</div>";
	}
	echo "<div id=\"cart-total\"><div id=\"summary-total\"><strong>Total: </strong>$" . number_format($order_details->total, 2) . "</div><div class=\"clearfix\"></div></div>";
}

echo "<h2>Payment Information</h2>";
echo "<div class=\"cart-cell\">";
echo "<div class=\"info\">";
echo "<p><strong>Credit card number: </strong>" . $order_details->creditcard_number . "<p>";
echo "<p><strong>Expiry date: </strong>" . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</p>";
echo "</div>";
echo "<div class=\"clearfix\"></div>";
echo "</div>";
?>
