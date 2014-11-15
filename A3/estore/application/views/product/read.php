<h1><?php echo $product->name;?></h1>
<?php 
	echo "<p>" . anchor('store/index','Back') . "</p>";
	echo "<div class=\"products-table-cell\">";
	echo "<span> Product ID: " . $product->id . "</span>";
	echo "<span class=\"price\">$" . $product->price . "</span>";
	echo "<img class=\"product-photo\" src='" . base_url() . "images/product/" . $product->photo_url . "' width='100px'/>";
	echo "<p class=\"description\">" . $product->description . "</p>";
	echo "</div>";
		
?>	

