<h1><?php echo $customer->first . " " . $customer->last;?></h1>
<?php 
	echo "<p>" . anchor('customers/index','Back') . "</p>";
	echo "<div class=\"products-table-cell\">";
	echo "<span>Name: " . $customer->first . " " . $customer->last . "</span>";
	echo "<br /><span>E-Mail: " . $customer->email . "</span>";
	echo "<br /><span>" . anchor("customers/delete/$customer->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</span>";
	echo "</div>";
		
?>	

