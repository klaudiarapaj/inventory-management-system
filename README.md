Prerequisites
1.	Make sure you have XAMPP and MySQL installed on your computer.
2.	Download the ZIP project
3.	Extract the ZIP and place the folder inside your C:\xampp\htdocs directory like this:
 
4.	Go to the subfolder:
C:\xampp\htdocs\inventory management system\database
Open dbconfig.php and import_db.php to make sure the MySQL username and password are set correctly.
Note: If your MySQL doesn’t have a password (like in my case), just leave the password empty but keep the username as root. Don't change the database name.
 

Steps to Run the Application
1.	Open XAMPP Control Panel.
2.	Start both Apache and MySQL services.
3.	Open your browser and go to this URL to import the database:
http://localhost/inventory%20management%20system/database/import_db.php
Once the database is imported successfully, the system is ready to use.
4.	Now open the main login page: http://localhost/inventory%20management%20system/system/login.php
5.	Use one of the following credentials to log in:
Login Credentials
Admin Access:
•	Email: klaudia@unyt.edu.al
•	Password: 12345678
Employee Access:
•	Email: gerta@unyt.edu.al
•	Password: 12345678
•	Email: hatixhe@unyt.edu.al
•	Password: 12345678

Admin Functionalities
•	Profile – View and update your personal profile, change your name or password.
•	Home – See dashboard stats: total products, transactions, and items low on stock.
•	Products – View all products with their details (name, price, rating, stock), search, edit, delete, or add new products.
•	Transactions – Record purchases by selecting items and quantities. The system will update stock levels and save transaction history.
•	Users – Add new users, assign roles (Admin/Employee) and delete users.

Employee Functionalities
•	Profile – Same as admin: view and edit personal info.
•	Home – See an overview of system statistics.
•	Products – View and manage product list (edit details or search).
•	Transactions – Record purchases and update inventory in real time.

