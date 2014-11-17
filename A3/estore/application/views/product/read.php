<h1><?php echo $product->name;?></h1>
<?php 
	function products_read_cell($child) {
		echo "<div class=\"products-read-cell\">";
		echo $child;
		echo "</div>";
	}

	echo "<p>" . anchor(site_url('store'),'Back to store') . "</p>";
	products_read_cell("<img class=\"product-photo\" src='" . base_url() . "images/product/" . $product->photo_url . "'/>");
	products_read_cell("<span class=\"id\"><strong>Product ID: </strong>" . $product->id . "</span>" . "<br />" . 
		"<span class=\"price\"><strong>Price: </strong>$" . $product->price . "</span>" . "<br />" . 
		"<p class=\"description\">" . $product->description . "</p>");
	echo "</div>";
		
?>	

