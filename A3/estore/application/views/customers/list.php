<h1>Customers</h1>
<?php
echo "<div id=\"customers-table\">";

foreach ($customers as $customer) {
	if ($customer->login != 'admin'){
		echo "<div class=\"customers-table-cell\">";
		echo "<h2>" . $customer->first . " " . $customer->last . "</h2>";

		echo "<ul class=\"actions\">";
		echo "<li>" . anchor("customers/read/$customer->id",'View') . "</li>";
		echo "<li>" . anchor("customers/delete/$customer->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</li>";
		echo "</ul>";
		echo "</div>";
	}}
		echo "</div>";
?>
