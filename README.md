# Products
 
Requirements:
Apache, 
MySQL, 
PHP 8.0.7, 
Composer, 
Symfony 5.3.2

Packages installed:
Doctrine, 
MakerBundle, 
Annotations, 
Twig

To set up the database, please run the SQL script \Products\products_database.sql

To run the application open a command window, go to the project directory on your computer and install project dependencies using command: composer install

Start the project with: symfony server:start

Afterwards, go to http://localhost:8000/ on your browser and the application should be running.

You will see a table on the main page of all current orders. You can filter by User ID or Email and sort by date of creation. Also, you are able to create new orders and add new products.

At the top of the page you are able to swtich between orders and products tables. At the products table you can update individual products amount and name.

For each of the orders you can view their assigned products.