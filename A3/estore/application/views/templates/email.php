<?php
echo "<h1>Receipt for Order #" . $order_details->id . "</h1>";
echo "<h2>Customer Information</h2>";
echo "<div style=\"border: 1px solid black; margin: 0 0 1em 0; padding: 0.5em;\">";
echo "<p><strong>Name: </strong>" . $customer->first . " " . $customer->last . "<p>";
echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
echo "<p><strong>Username: </strong>" . $customer->login . "</p>";
echo "</div>";

if (count($items)){
	echo "<h2>Items</h2>";
	foreach ($items as $item) {
		echo "<div style=\"border: 1px solid black; margin: 0 0 1em 0; padding: 0.5em;\">";
		echo "<h3>" . $item->name . "</h3>";
		echo "<table style=\"border: 0; width: 100%;\">";
		echo "<tr><td><span><strong>Product ID: </strong>" . $item->product_id . "</span></td>" . 
			"<td style=\"text-align: right;\"><span><strong>Quantity: </strong>" . $item->quantity . "</span></td></tr>";
		echo "<tr><td><span><strong>Unit Price: </strong>$" . $item->price . "</span></td>" . 
			"<td style=\"text-align:right;\"><span><strong>Subtotal: </strong>$" . $item->quantity * $item->price . "</span></td></tr>";
		echo "</table>";
		echo "</div>";
	}
	echo "<div style=\"width:100%;text-align:right;\"><strong>Total: </strong>$" . $order_details->total . "</div>";
}

echo "<h2>Payment Information</h2>";
echo "<div style=\"border: 1px solid black; margin: 0 0 1em 0; padding: 0.5em;\">";
echo "<p><strong>Credit card number: </strong>" . $order_details->creditcard_number . "<p>";
echo "<p><strong>Expiry date: </strong>" . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</p>";
echo "</div>";
?>
