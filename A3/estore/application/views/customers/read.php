<h1><?php echo $customer->first . " " . $customer->last;?></h1>
<?php 
echo "<div class=\"admin-table-cell\">";
echo "<div class=\"info\">";
echo "<p><strong>ID: </strong>" . $customer->id . "<p>";
echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
echo "<p><strong>Username: </strong>" . $customer->login . "</p>";
echo "</div>";

echo "<div class=\"clearfix\"></div>";
echo "</div>";
echo "<div class=\"actions\">";	
echo anchor("customers/delete/$customer->id",'Delete',
	array(
		'onClick' => "return confirm('Do you really want to delete this record?');",
		'class' => 'button'
	)
);
echo "</div>";
?>	

