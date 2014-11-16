<h1>Products</h1>
<?php 
		echo "<p>" . anchor('store/newForm','Add New') . "</p>";
 	  
		echo "<div id=\"products-table\">";
		//echo "<tr><th>Name</th><th>Description</th><th>Price</th><th>Photo</th></tr>";
		
		foreach ($products as $product) {
			echo "<div class=\"products-table-cell\">";
			echo "<h1>" . $product->name . "</h1>";
			echo "<span class=\"price\"> $" . $product->price . "</span>";
			echo "<img class=\"product-photo\" src=\"" . base_url() . "images/product/" . $product->photo_url . "\" width=\"100px\" /></td>";
			echo "<p class=\"description\">" . $product->description . "</p>";

			echo "<ul class=\"actions\">";	
			echo "<li>" . anchor("store/delete/$product->id",'Delete',"onClick='return confirm(\"Do you really want to delete this record?\");'") . "</li>";
			echo "<li>" . anchor("store/editForm/$product->id",'Edit') . "</li>";
			echo "<li>" . anchor("store/read/$product->id",'View') . "</li>";
			echo "<li>" . anchor("store/add_to_cart/$product->id",'Add to Cart') . "</li>";
			echo "</ul>";
			echo "</div>";
		}
		echo "</div>";
?>	

