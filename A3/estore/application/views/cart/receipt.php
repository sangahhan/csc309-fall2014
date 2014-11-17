<h1>Receipt</h1>
<?php

        echo "<p>" . anchor(,'Back') . "</p>";
        echo "<p>" . anchor('cart/','Cancel') . "</p>";
        echo "<h4> Total : " . $order_details->total . "</h4>";
        foreach ($items as $item) {
            echo "<p> Product Name : " . $item->name . "<p>";
            echo "<span class=\"quantity\"> Quantity : " . $item->quantity . "</span>";
        }
        echo "<br>";
        echo "<br>";

        echo "<h4> Payment information </h4>";
        echo "<p> Credit card number : " . $order_details->creditcard_number . "<p>";
        echo "<p> Expiry date : " . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</span>";


?>
