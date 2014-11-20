<h1>Order #<?= $order->id ?></h1>

<?php
// View for reading orders in the system. ADMIN ONLY
echo "<p>" . anchor(site_url('orders'),'Back to orders') . "</p>";
echo "<h2>Customer Information</h2>";
echo "<div class=\"admin-table-cell\">";
echo "<div class=\"info\">";
echo "<p><strong>ID: </strong>" . $customer->id . "<p>";
echo "<p><strong>Name: </strong>" . $customer->first . " " . $customer->last . "<p>";
echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
echo "<p><strong>Username: </strong>" . $customer->login . "</p>";
echo "</div>";

// Actions to be taken on the customer who created this order
echo "<ul class=\"actions\">";
echo "<li>" . anchor("customers/read/$customer->id",'View') . "</li>";
echo "</ul>";
echo "<div class=\"clearfix\"></div>";
echo "</div>";

if (count($items)){
	echo "<h2>Items</h2>";
	foreach ($items as $item) {
		echo "<div class=\"cart-cell\">";
		echo "<div class=\"info\">";
		echo "<h3>" . anchor(site_url('store/read') . "/$item->product_id", $item->name) . "</h3>";
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
	echo "<div id=\"cart-total\"><div id=\"summary-total\"><strong>Total: </strong>$" . $order->total . "</div><div class=\"clearfix\"></div></div>";
}
echo "<h2>Payment information</h2>";
echo "<div class=\"admin-table-cell\">";
echo "<div class=\"info\">";
echo "<p><strong>Credit card number: </strong>" . $order->creditcard_number . "<p>";
echo "<p><strong>Expiry date: </strong>" . $order->creditcard_month . "/" . $order->creditcard_year . "</span>";
echo "</div>";
echo "<div class=\"clearfix\"></div>";
echo "</div>";
// Actions to be taken on each order
echo "<div class=\"actions\">";
echo anchor("store/delete/$order->id",'Delete',
	array (
		'onclick' => "return confirmDelete();",
		'class' => 'button'
	)) ; 
echo "</div>";
?>
