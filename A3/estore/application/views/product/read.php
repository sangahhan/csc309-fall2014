<h1><?php echo $product->name;?></h1>
<?php 
	function products_read_cell($child) {
		echo "<div class=\"products-read-cell\">";
		echo $child;
		echo "</div>";
	}
	products_read_cell("<img class=\"product-photo\" src='" . base_url() . "images/product/" . $product->photo_url . "'/>");
	$product_info = "<span class=\"id\"><strong>Product ID: </strong>" . $product->id . "</span>" . "<br />" . 
		"<span class=\"price\"><strong>Price: </strong>$" . number_format($product->price, 2) . "</span>" . "<br />" . 
		"<p class=\"description\">" . $product->description . "</p>";
	products_read_cell($product_info);
	echo "<div class=\"actions\">";
	if (is_admin($this->session)){
		echo
			anchor("store/delete/$product->id",'Delete',
				array (
					'onclick' => "return confirm('Do you really want to delete this record?');",
					'class' => 'button'
				)) . " " . 
		anchor("store/editForm/$product->id",'Edit', 'class="button"'); 
	} else {
		echo anchor("cart/add_to_cart/$product->id",'Add to Cart', array('class' => 'button'));
	}
	echo "</div>";
		
?>	

