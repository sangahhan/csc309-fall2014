<h1>Shopping Cart</h1>
<?php
        echo "<p>" . anchor('store/','Back') . "</p>";
        foreach (array_keys($items) as $item_key) {
            echo "<h2> Product Name : " . $items[$item_key]['name'] . "</h2>";
            echo "<span class=\"quantity\"> Quantity : " . $items[$item_key]['quantity'] . "</span>";
            echo "<ul class=\"actions\">";
            echo "<li>" . anchor("store/increase_in_cart/$item_key",'Increase') . "</li>";
            echo "<li>" . anchor("store/reduce_from_cart/$item_key",'Decrease') . "</li>";
            echo "<li>" . anchor("store/remove_from_cart/$item_key",'Remove') . "</li>";
            echo "</ul>";
        }

?>
