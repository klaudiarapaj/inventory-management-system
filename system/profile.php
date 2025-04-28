<?php
session_start();
require_once "../database/dbconfig.php";


if (!isset($_SESSION['login'])) {
    header("location: login.php");
    exit();
}

$user_id = $_SESSION['id'];


$query = "SELECT name, email, role FROM users WHERE userid = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$user = mysqli_fetch_assoc($result);
mysqli_stmt_close($stmt);


$name = $_SESSION['name'];
$email = $_SESSION['email'];
$role = $_SESSION['role'];
$profile_picture = "../system/images/admin3.jpg";

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "head.php"; ?>
    <style>
        .profile-container {
            max-width: 500px;
            margin: 40px auto;
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .profile-picture {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
            border: 3px solid #007bff;
        }

        .profile-container h2 {
            margin-bottom: 25px;
            font-weight: 600;
            font-size: 24px;
        }

        .profile-info {
            text-align: left;
            margin-bottom: 30px;
        }

        .profile-info label {
            font-weight: bold;
            color: #333;
        }

        .profile-info p {
            margin-bottom: 15px;
            font-size: 15px;
            color: #555;
        }

        .edit-btn {
            display: inline-block;
            background-color: #007bff;
            color: #fff;
            padding: 10px 25px;
            border-radius: 5px;
            text-decoration: none;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .edit-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="page-container">
    <div class="left-content">
        <div class="inner-content">
            <div class="outter-wp">
                <div class="sub-heard-part">
                    <ol class="breadcrumb m-b-0">
                        <li><a href="index.php">Home</a></li>
                        <li class="active">Profile</li>
                    </ol>
                </div>

                <div class="profile-container">
                    <h2>My Profile</h2>

                    <img src="<?php echo $profile_picture; ?>" alt="Profile Picture" class="profile-picture">

                    <div class="profile-info">
                        <label>Name:</label>
                        <p><?php echo ucwords($name); ?></p>

                        <label>Email:</label>
                        <p><?php echo htmlspecialchars($email); ?></p>

                        <label>Role:</label>
                        <p><?php echo ucfirst($role); ?></p>
                    </div>

                    <a href="edit_profile.php" class="edit-btn">Edit Profile</a>
                </div>

            </div>
        </div>
    </div>
    <?php include "side_bar.php"; ?>
</div>
<?php include "footer_script.php"; ?>
</body>
</html>
