<?php
session_start();
require_once "../database/dbconfig.php";
require_once "validation.php";

function iud($query)
{
	global $conn;  
	return mysqli_query($conn, $query);  
}

###########################################################
if (isset($_REQUEST['login'])) {
    $email = trim($_REQUEST['email']);
    $password = md5(trim($_REQUEST['password']));
    $valid = true;

    if (!checkemail($email)) {
        echo "Invalid email";  
        exit(); 
    }

    if ($valid) {
        $query = "SELECT * FROM users WHERE email = ? AND password = ?";

        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param("ss", $email, $password);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 1) {
                $data = $result->fetch_assoc();

                $_SESSION['id'] = $data['userid'];
                $_SESSION['name'] = $data['name'];
                $_SESSION['role'] = $data['role'];
                $_SESSION['email'] = $data['email'];
                $_SESSION['login'] = "yes";

                if ($data['role'] == 'admin') {
                    echo "1";  
                } elseif ($data['role'] == 'employee') {
                    echo "2";  
                } else {
                    echo "Unknown role";  
                }
            } else {
                echo "Email or password is incorrect";  
            }

            $stmt->close();
        } else {
            echo "Database query failed";  
        }
    }
    exit();  
}



##########################################################################
if (isset($_POST['update_profile'])) {
  $user_id = $_POST['user_id'];
  $name = $_POST['name'];
  $new_password = $_POST['new_password'] ?? '';

  if (!empty($new_password) && strlen($new_password) < 6) {
    echo "<script>alert('Password must be at least 6 characters long.'); window.history.back();</script>";
    exit;
}

  if (!empty($new_password)) {
      $hashed_password = md5($new_password);
      $query = "UPDATE users SET name = ?, password = ? WHERE userid = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("ssi", $name, $hashed_password, $user_id);
  } else {
      $query = "UPDATE users SET name = ? WHERE userid = ?";
      $stmt = $conn->prepare($query);
      $stmt->bind_param("si", $name, $user_id);
  }

  if ($stmt->execute()) {
      echo "<script>
              alert('Profile updated successfully');
              window.location='profile.php';
            </script>";
            exit;
  } else {
      echo "Error: " . $stmt->error;
  }

  $stmt->close();
  exit;
}

##########################################################################

if (isset($_REQUEST['add_item'])) {
    extract($_REQUEST);
    $error = $_FILES["image"]["error"];

    $name = $_FILES["image"]["name"];
    $type = $_FILES["image"]["type"];
    $size = $_FILES["image"]["size"];
    $tmp_name = $_FILES["image"]["tmp_name"];

    move_uploaded_file($tmp_name, "images/$name");

    $item_query = "INSERT INTO `items` (`title`, `category_id`, `item_rating`, `image`, `description`, `price`) 
                   VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($item_query);
    $stmt->bind_param("siisss", $title, $category_id, $rating, $name, $description, $price);

    if ($stmt->execute()) {
        $itemid = $stmt->insert_id; 
        $stmt->close();

        $inv_query = "INSERT INTO `inventory` (`item_id`, `quantity`) VALUES (?, ?)";
        $inv_stmt = $conn->prepare($inv_query);
        $inv_stmt->bind_param("ii", $itemid, $quantity);

        if ($inv_stmt->execute()) {
            echo "<script>alert('Item added successfully with quantity.');
                  window.location='view_products.php';
                  </script>";
            exit;
        } else {
            echo "<script>alert('Item added, but failed to update inventory.');
                  window.location='view_products.php';
                  </script>";
            exit;
        }
        $inv_stmt->close();

    } else {
        echo "<script>alert('Failed to add item.');
              window.location='add_product.php';
              </script>";
        exit;
    }
}


###################################################################################################
if (@$_REQUEST['delete_item'] == 'yes') {
	$itemid = $_REQUEST['id'];

	$inventoryQuery = "DELETE FROM `inventory` WHERE item_id='$itemid'";
	$inventoryResult = mysqli_query($conn, $inventoryQuery);

	if ($inventoryResult) {
		$itemsQuery = "DELETE FROM `items` WHERE itemid='$itemid'";
		$itemsResult = mysqli_query($conn, $itemsQuery);

		if ($itemsResult) {
			$_SESSION['message'] = 'Item deleted successfully';
		} else {
			$_SESSION['message'] = 'Error deleting item from items table';
		}
	} else {
		$_SESSION['message'] = 'Error deleting item from inventory table';
	}

	header("location:view_products.php");
	exit;
}


###############################################

if (@$_REQUEST['edit'] == 'yes') {
	$itemid = $_REQUEST['id'];
	header("location:edit_product.php?id=$itemid");
	exit;
}

###################################################	
if (isset($_POST['update_item'])) {

	$utitle = $_POST['utitle'];
	$ucategory = $_POST['ucategory'];
	$urating = $_POST['urating'];
	$udescription = $_POST['udescription'];
	$uprice = $_POST['uprice'];
	$uquantity = $_POST['uquantity'];
	$uid = $_POST['uid'];


	$error = $_FILES["uimage"]["error"];
	$name = $_FILES["uimage"]["name"];
	$type = $_FILES["uimage"]["type"];
	$size = $_FILES["uimage"]["size"];
	$tmp_name = $_FILES["uimage"]["tmp_name"];

	if ($error === 4) {
		$query = "UPDATE `items` 
                  SET `category_id`='$ucategory', 
                      `title`='$utitle', 
                      `item_rating`='$urating', 
                      `description`='$udescription', 
                      `price`='$uprice'
                  WHERE itemid='$uid'";
		$n = iud($query);
	} else {
		move_uploaded_file($tmp_name, "images/$name");

		$query = "UPDATE `items` 
                  SET `category_id`='$ucategory', 
                      `title`='$utitle', 
                      `item_rating`='$urating', 
                      `image`='$name', 
                      `description`='$udescription', 
                      `price`='$uprice'
                  WHERE itemid='$uid'";
		$n = iud($query);
	}

	$inventoryQuery = "UPDATE `inventory` 
                       SET `quantity`='$uquantity' 
                       WHERE item_id='$uid'";

	$inventoryUpdate = iud($inventoryQuery);

	if ($n == 1 && $inventoryUpdate == 1) {
		echo "<script>
            alert('Product updated successfully');
            window.location='view_products.php';
        </script>";
		exit;
	} else {
		echo "<script>
            alert('Product update failed');
            window.location='view_products.php';
        </script>";
		exit;
	}
}


####################################################################

if (isset($_POST['add_user'])) {
	$name = $_POST['name']; 
	$email = $_POST['email'];
	$password = $_POST['password']; 
	$role = $_POST['role'];

  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format'); window.history.back();</script>";
    exit;
}

if (strlen($password) < 6) {
    echo "<script>alert('Password must be at least 6 characters'); window.history.back();</script>";
    exit;
}

  $check = mysqli_query($conn, "SELECT 'user_id' FROM users WHERE email = '$email'");
  if (mysqli_num_rows($check) > 0) {
      echo "<script>
              alert('Email already exists. Please use a different email.');
              window.location='add_user.php';
            </script>";
      exit;
  }

	$password = md5($password);
	$query = "INSERT INTO `users` (`name`, `email`, `password`, `role`) 
				  VALUES ('$name', '$email', '$password', '$role')";
	$n = iud($query);


	if ($n == 1) {
		echo "<script>
					alert('User added successfully');
					window.location='view_users.php';
				  </script>";
				  exit;
	} else {
		echo "User could not be added.";
		exit;
	}
}

####################################################################	

if (@$_REQUEST['delete_user'] == 'yes') {
	$user_id = $_REQUEST['id'];


	$query = "DELETE FROM `users` WHERE userid='$user_id'";

	$n = mysqli_query($conn, $query);

	if ($n) {
		$_SESSION['message'] = 'User deleted successfully';
	} else {
		$_SESSION['message'] = 'Something went wrong while deleting the user';
	}

	header("location:view_users.php");
	exit;
}

####################################################################


if (isset($_POST['update_user'])) {
	$user_id = $_POST['user_id'];
	$new_role = $_POST['role'];

	$query = "SELECT role FROM users WHERE userid = ?";
	$stmt = mysqli_prepare($conn, $query);
	mysqli_stmt_bind_param($stmt, "i", $user_id);
	mysqli_stmt_execute($stmt);
	mysqli_stmt_bind_result($stmt, $current_role);
	mysqli_stmt_fetch($stmt);
	mysqli_stmt_close($stmt);

	if ($user_id == $_SESSION['id']) {
		if ($current_role == 'admin' && $new_role != 'admin') {
			echo "<script>
                    alert('You cannot change your own role from Admin to another role.');
                    window.location='view_users.php';
                  </script>";
			exit;
		}
	}

	if ($current_role == 'admin' && $new_role != 'admin') {
		$admin_count_query = "SELECT COUNT(*) FROM users WHERE role = 'admin'";
		$admin_count_result = mysqli_query($conn, $admin_count_query);
		$admin_count_row = mysqli_fetch_array($admin_count_result);
		$admin_count = $admin_count_row[0];

		if ($admin_count <= 1) {
			echo "<script>
                    alert('The system must have at least one admin.');
                    window.location='view_users.php';
                  </script>";
			exit;
		}
	}

	$update_query = "UPDATE users SET role = ? WHERE userid = ?";
	$update_stmt = mysqli_prepare($conn, $update_query);
	mysqli_stmt_bind_param($update_stmt, "si", $new_role, $user_id);
	$update_result = mysqli_stmt_execute($update_stmt);
	mysqli_stmt_close($update_stmt);

	if ($update_result) {
		echo "<script>
                window.location='view_users.php';
              </script>";
			  exit;
	} else {
		echo "<script>
                alert('User role update failed.');
                window.location='view_users.php';
              </script>";
			  exit;
	}
}


####################################################################


if (!isset($_POST['add_transaction'])) {
    header("Location: add_transaction.php");
    exit;
}

$remarks = mysqli_real_escape_string($conn, $_POST['remarks']);
$date = date('Y-m-d');

$item_ids = $_POST['item_id'] ?? [];
$quantities = $_POST['quantity'] ?? [];

if (empty($item_ids) || empty($quantities)) {
    echo "<script>alert('Please add at least one item.'); window.history.back();</script>";
    exit;
}

$total = 0;
$itemsData = [];

foreach ($item_ids as $index => $item_id) {
    $item_id = (int)$item_id;
    $qty = (int)$quantities[$index];

    if ($qty <= 0) {
        echo "<script>alert('Quantity must be greater than 0.'); window.history.back();</script>";
        exit;
    }

    $item_sql = "
        SELECT i.itemid, i.title, i.price, inv.quantity as stock
        FROM items i
        JOIN inventory inv ON inv.item_id = i.itemid
        WHERE i.itemid = $item_id
        LIMIT 1
    ";

    $item_res = mysqli_query($conn, $item_sql);
    $item = mysqli_fetch_assoc($item_res);

    if (!$item) {
        echo "<script>alert('Invalid item selected.'); window.history.back();</script>";
        exit;
    }

    if ($qty > $item['stock']) {
        echo "<script>
            alert('Not enough stock for \"{$item['title']}\". Available: {$item['stock']}, Requested: $qty');
            window.history.back();
        </script>";
        exit;
    }

    $line_total = $item['price'] * $qty;
    $total += $line_total;

    $itemsData[] = [
        'itemid' => $item['itemid'],
        'title' => $item['title'],
        'qty' => $qty,
        'price_each' => $item['price']
    ];
}

$insertTransaction = "INSERT INTO transactions (transaction_date, remarks, total)
                      VALUES ('$date', '$remarks', '$total')";
if (!mysqli_query($conn, $insertTransaction)) {
    die("Error creating transaction: " . mysqli_error($conn));
}
$transaction_id = mysqli_insert_id($conn);

foreach ($itemsData as $item) {
    $itemid = $item['itemid'];
    $qty = $item['qty'];
    $price = $item['price_each'];

    mysqli_query($conn, "INSERT INTO transaction_lines (transaction_id, item_id, quantity, price_each)
                         VALUES ($transaction_id, $itemid, $qty, $price)");

    mysqli_query($conn, "UPDATE inventory
                         SET quantity = quantity - $qty, last_updated = NOW()
                         WHERE item_id = $itemid");
}

echo "<script>alert('Transaction added successfully.'); window.location='view_transactions.php';</script>";
exit;
