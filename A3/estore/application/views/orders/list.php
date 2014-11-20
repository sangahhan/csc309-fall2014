<h1>Orders</h1>
<?php
// View for listing orders in the system. ADMIN ONLY
foreach ($orders as $order) {
	echo "<div class=\"admin-table-cell\">";

	echo "<div class=\"info\">";
	echo "<h2>Order #" . $order->id . "</h2>";
	echo "<p><strong>Order date: </strong>" . $order->order_date . "</p>";
	echo "<p><strong>Order time: </strong>" . $order->order_time . "</p>";
	echo "</div>";
	// Actions to be taken on each order
	echo "<ul class=\"actions\">";
	echo "<li>" . anchor(site_url('orders/read') . "/$order->id",'View') . "</li>";
		echo "<li>" . anchor(site_url('orders/delete') . "/$order->id",'Delete',"onClick='return confirmDelete();'") . "</li>";
	echo "</ul>";
	echo "</div>";
}
?>
