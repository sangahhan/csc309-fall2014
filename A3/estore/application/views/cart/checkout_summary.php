<h1>Checkout Summary</h1>
<?php

        echo "<p>" . anchor('cart/checkout_form','Back') . "</p>";
        echo "<p>" . anchor('cart/','Cancel') . "</p>";
        echo "<h4> Total : " . $total . "</h4>";
        foreach (array_keys($items) as $item_key) {
            echo "<p> Product Name : " . $items[$item_key]['name'] . "<p>";
            echo "<span class=\"quantity\"> Quantity : " . $items[$item_key]['quantity'] . "</span>";
        }
        echo "<br>";
        echo "<br>";

        echo "<h4> Payment information </h4>";
        echo "<p> Credit card number : " . $order_details->creditcard_number . "<p>";
        echo "<p> Expiry date : " . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</span>";

        echo "<br>";
        echo "<br>";

        echo "<p>" . anchor('cart/checkout/','Confirm') . "</p>";

?>
