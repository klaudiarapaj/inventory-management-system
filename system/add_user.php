<?php require_once "../database/dbconfig.php";
session_start();
if (isset($_SESSION['login'])) {
} else {
  header("location:login.php");
}
?>
<!DOCTYPE HTML>
<html>

<head>
  <?php include "head.php"; ?>
  <style>
    .form-horizontal .form-group {
      margin-bottom: 10px;
    }

    .form-horizontal .col-xs-6 {
      padding-left: 5px;
      padding-right: 5px;
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
      max-width: 700px;
      margin: 0 auto;
    }

    .btn-info {
      padding: 8px 20px;
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
              <li class="active">Add User</li>
            </ol>
          </div>
          <div class="graph-visual tables-main">
            <h2 class="inner-tittle">Add User</h2>
            <div class="graph">
              <div class="block-page">
                <div class="form-body">
                  <form class="form-horizontal" action="myphp.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="name" class="col-sm-2 control-label">Full Name</label>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="email" class="col-sm-2 control-label">Email</label>
                      <div class="col-xs-6">
                        <input type="email" class="form-control" name="email" placeholder="Email" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="password" class="col-sm-2 control-label">Password</label>
                      <div class="col-xs-6">
                        <input type="password" class="form-control" name="password" placeholder="Password" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="role" class="col-sm-2 control-label">Role</label>
                      <div class="col-xs-6">
                        <select class="form-control" name="role" required>
                          <option value="" selected disabled>Select Role</option>
                          <option value="admin">Admin</option>
                          <option value="employee">Employee</option>
                        </select>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-xs-6 col-sm-offset-2">
                        <center><input type="submit" class="btn btn-info" name="add_user" value="SUBMIT"></center>
                      </div>
                    </div>
                  </form>
                </div>
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