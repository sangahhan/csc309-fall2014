<h1>Customers</h1>
<?php
// View for listing customers in the system. ADMIN ONLY
foreach ($customers as $customer) {
	if ($customer->login != 'admin'){
		echo "<div class=\"admin-table-cell\">";
		echo "<div class=\"info\">";

		echo "<h2>" . $customer->first . " " . $customer->last . " (" . $customer->login . ")</h2>";
		echo "<p><strong>ID: </strong>" . $customer->id . "<p>";
		echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
		echo "</div>";
		echo "<ul class=\"actions\">";
		// Actions to be taken on each customer
		echo "<li>" . anchor("customers/read/$customer->id",'View') . "</li>";
		echo "<li>" . anchor("customers/delete/$customer->id",'Delete',"onClick='return confirmDelete();'") . "</li>";
		echo "</ul>";
		echo "</div>";
	}}
		echo "</div>";
?>
