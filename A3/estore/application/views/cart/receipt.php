<h1>Receipt for Order #<?= $order_details->id ?></h1>
<?php
if (count($items)){
	echo "<h2>Items</h2>";
	foreach ($items as $item) {
	echo "<div class=\"cart-cell\">";
	echo "<div class=\"info\">";
	echo "<h3>" . $item->name . "</h3>";
	echo "<p><strong>Product ID: </strong>" . $item->product_id . "</p>";
	echo "<p><strong>Unit Price: </strong>$" . $item->price . "</p>";
	echo "</div>";
	echo "<div class=\"quantity-control\">";
	echo "<p><strong>Quantity: </strong>" . $item->quantity . "</p>";
	echo "<p><strong>Subtotal: </strong>$" . $item->quantity * $item->price . "</p>";
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
echo "<a href=\"#\" id=\"print-link\" class=\"button\">" . "Print" . "</a>";

?>
