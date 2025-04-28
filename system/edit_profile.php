<?php
require_once "../database/dbconfig.php";
session_start();

if (!isset($_SESSION['login'])) {
    header("location: login.php");
    exit;
}

$userid = $_SESSION['id'];
$query = "SELECT * FROM users WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $userid);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();
?>
<!DOCTYPE HTML>
<html>

<head>
    <?php include "head.php"; ?>
    <style>
        .form-horizontal .form-group {
            margin-bottom: 10px;
        }

        .form-control {
            height: 35px;
            font-size: 14px;
        }

        .form-horizontal .col-sm-2 {
            text-align: left;
            font-weight: bold;
        }

        .form-body {
            max-width: 500px;
            margin: 0 auto;
        }

        .btn-info {
            padding: 8px 20px;
            font-size: 14px;
        }

        .breadcrumb {
            margin: 0;
            padding: 5px 10px;
            font-size: 14px;
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
                            <li class="active">Edit Profile</li>
                        </ol>
                    </div>
                    <div class="graph-visual tables-main">
                        <h2 class="inner-tittle">Edit Profile</h2>
                        <div class="graph">
                            <div class="form-body">
                                <form class="form-horizontal" action="myphp.php" method="post">
                                    <input type="hidden" name="user_id" value="<?php echo $user['userid']; ?>">

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Name</label>
                                        <div class="col-sm-10">
                                            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Email</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">Role</label>
                                        <div class="col-sm-10">
                                            <input type="text" class="form-control" value="<?php echo htmlspecialchars($user['role']); ?>" disabled>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-sm-2 control-label">New Password</label>
                                        <div class="col-sm-10">
                                            <input type="password" name="new_password" class="form-control" placeholder="Leave blank to keep current password" maxlength="255">
                                            <small id="passwordHelp" class="text-muted" style="color:red;"></small>

                                        </div>
                                    </div>
                                    <center><input type="submit" class="btn btn-info" name="update_profile" value="UPDATE"></center>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <?php include "side_bar.php"; ?>
    </div>
    <?php include "footer_script.php"; ?>


</body>

</html>