# inventory-management-system

## Prerequisites

1. Ensure **XAMPP** and **MySQL** are installed on your computer.
2. Download the project as a `.zip` file.
3. Extract the `.zip` and place the folder in the following directory:  
   `C:\xampp\htdocs`  
   Your path should look like:  
   `C:\xampp\htdocs\inventory management system`

4. Navigate to:  
   `C:\xampp\htdocs\inventory management system\database`  
   Open `dbconfig.php` and `import_db.php`, and make sure the **MySQL username and password** are correctly set.

> 💡 **Note**:  
> If your MySQL server does not require a password (e.g., default XAMPP setup), leave the password field empty but keep the username as `root`.  
> **Do not change the database name.**

---

## Steps to Run the Application

1. Open the **XAMPP Control Panel**.
2. Start both **Apache** and **MySQL** services.
3. In your browser, visit the following URL to import the database:  
   [http://localhost/inventory%20management%20system/database/import_db.php](http://localhost/inventory%20management%20system/database/import_db.php)

   Once the database is successfully imported, the system is ready for use.

4. Open the main login page:  
   [http://localhost/inventory%20management%20system/system/login.php](http://localhost/inventory%20management%20system/system/login.php)

5. Log in using one of the credentials listed below.

---

## Login Credentials

### Admin Access
- **Email**: `klaudia@unyt.edu.al`  
- **Password**: `12345678`

### Employee Access
- **Email**: `gerta@unyt.edu.al`  
  **Password**: `12345678`  
- **Email**: `hatixhe@unyt.edu.al`  
  **Password**: `12345678`

---

## Admin Functionalities

- **Profile** – View and update your personal profile (name and password).
- **Home** – Dashboard with stats: total products, transactions, and low-stock alerts.
- **Products** – View product details (name, price, rating, stock), search, edit, delete, or add new products.
- **Transactions** – Record purchases, update stock levels, and track transaction history.
- **Users** – Add or delete users, assign roles (Admin/Employee).

---

**Developed by Klaudia Rapaj for academic purposes.**

## Employee Functionalities

- **Profile** – View and edit your personal profile.
- **Home** – Overview of key system statistics.
- **Products** – View, search, and edit product details.
- **Transactions** – Record purchases and update inventory in real-time.
