The ID of your AMI  :
    -

Access given to:
    -

Location of your source files within the AMI :
    - /var/www/???


Any necessary instructions for starting Apache
    -

Details about the browser the TA should use to test your assignment
    - Chrome preferred

Documentation for your Web site. Include a brief explanations of how it all
works, e.g., list of main user-defined objects, and datastructures.

    - User defined objects : Customers, Product, Order, Order_Item

    - User defined models :
        - customer model
            - inserts, deletes and retrieves customer objects from the database
        - product model
            - inserts, updates, deletes & retrieves product objects from the db
        - order model
            - inserts, deletes and retrieves order objects from the db
        - order_item model
            - inserts, deletes and retrieves order item objects from the db
            - retrieves the order to which a given order item belongs to


    - User defined Controller classes:
        Authentication:
            - Controller class auth : Controls functions such as login,
                registration and logout

        Admin user
            - Browse inventory
                - The store controller class handles the functions to create,
                    read, update and delete individual products
            - Browse orders
                - The orders controller class handles the viewing and deletion
                    of orders
            - Browse customers
                - The orders controller class handles the viewing and deletion
                    of customers

        Non Admin user
            - Browse inventory
                - The store controller class provides the functionality to
                    view the product list and the individual products
            - Shopping cart
                - The cart controller class provide the functionalities for
                    the user to add, remove and checkout items in a shopping
                    cart that is stored in the session.
                - After a successful checkout, the cart controller also handles
                    sending of the email to the user and presents the receipt
                    in a printable format.
