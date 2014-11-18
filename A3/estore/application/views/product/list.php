<h1>Products</h1>
<?php
if (is_admin($this->session)){
	echo "<p>" . anchor('store/newForm','Add New') . "</p>";
}

echo "<div id=\"products-table\">";

foreach ($products as $product) {
	echo "<div class=\"products-table-cell\">";
	echo "<div class=\"info\">";
	echo "<h1>" . $product->name . "</h1>";
	echo "<img class=\"product-photo\" src=\"" . base_url() . "images/product/" . $product->photo_url . "\" /></td>";
	echo "<span class=\"price\"><strong>Price: </strong>$" . $product->price . "</span>";
	echo "<p class=\"description\">" . $product->description . "</p>";
	echo "</div>";
	echo "<ul class=\"actions\">";
	echo "<li>" . anchor("store/read/$product->id",'View') . "</li>";
	if (is_admin($this->session)){
		echo "<li>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</li>";
		echo "<li>" . anchor("store/editForm/$product->id",'Edit') . "</li>"; 
	} else {
		echo "<li>" . anchor("cart/add_to_cart/$product->id",'Add to Cart') . "</li>";
	}
	echo "</ul>";
	echo "</div>";
}
echo "</div>";
?>
