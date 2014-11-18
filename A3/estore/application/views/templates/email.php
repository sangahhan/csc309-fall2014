<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    </head>
    <body>
        <h1>Receipt for Order #<?= $order_details->id ?></h1>
        <?php

        echo "<h2>Customer Information</h2>";
        echo "<p><strong>Name: </strong>" . $customer->first . " " . $customer->last . "<p>";
        echo "<p><strong>E-Mail Address: </strong>" . $customer->email . "</p>";
        echo "<p><strong>Username: </strong>" . $customer->login . "</p>";
        if (count($items)){
            echo "<h2>Items</h2>";
            foreach ($items as $item) {
                echo "<h3>" . $item->name . "</h3>";
                echo "<p><strong>Product ID: </strong>" . $item->product_id . "</p>";
                echo "<p><strong>Unit Price: </strong>$" . $item->price . "</p>";
                echo "<p><strong>Quantity: </strong>" . $item->quantity . "</p>";
                echo "<p><strong>Subtotal: </strong>$" . $item->quantity * $item->price . "</p>";
            }
            echo "<p><strong>Total: </strong>$" . $order_details->total . "</p>";
        }

        echo "<h2>Payment Information</h2>";
        echo "<p><strong>Credit card number: </strong>" . $order_details->creditcard_number . "<p>";
        echo "<p><strong>Expiry date: </strong>" . $order_details->creditcard_month . "/" . $order_details->creditcard_year . "</p>";

        ?>
    </body>
</html>
