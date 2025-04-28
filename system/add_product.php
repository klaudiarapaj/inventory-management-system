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
  <script type="text/javascript" src="js/nicEdit-latest.js"></script>
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

    textarea.form-control {
      height: 120px;
      resize: none;
    }

    .form-horizontal .col-sm-2 {
      text-align: left;
      padding-right: 0;
      font-weight: bold;
    }

    .form-horizontal .col-sm-6 {
      padding-left: 0;
    }

    .form-body {
      max-width: 700px;
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
        <?php 
        ?>
        <div class="outter-wp">
          <div class="sub-heard-part">
            <ol class="breadcrumb m-b-0">
              <li><a href="index.php">Home</a></li>
              <li class="active">Add Product</li>
            </ol>
          </div>
          <div class="graph-visual tables-main">
            <h2 class="inner-tittle">Add Product</h2>
            <div class="graph" style="height:1000px">
              <div class="block-page">
                <p>

                <div class="form-body">
                  <form class="form-horizontal" action="myphp.php" method="post" enctype="multipart/form-data">

                    <div class="form-group">
                      <label for="title" class="col-sm-2 control-label">Title</label>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" id="title" name='title' placeholder="Title" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="category" class="col-sm-2 control-label">Category</label>
                      <div class="col-xs-6">
                        <select class="form-control" name="category_id" required>
                          <option value="" selected disabled>Select Category</option>
                          <option value="1">Fruits & Vegetables</option>
                        </select>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="rating" class="col-sm-2 control-label">Rating</label>
                      <div class="col-xs-6">
                        <input type="number" class="form-control" name="rating" min="1" max="5" value="5" placeholder="Rating">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="image" class="col-sm-2 control-label">Image</label>
                      <div class="col-xs-6">
                        <input type="file" class="form-control" id="image" name="image">
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="price" class="col-sm-2 control-label">Price</label>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" id="price" name="price" placeholder="Price" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="quantity" class="col-sm-2 control-label">Quantity</label>
                      <div class="col-xs-6">
                        <input type="text" class="form-control" id="quantity" name="quantity" placeholder="Quantity" required>
                      </div>
                    </div>

                    <div class="form-group">
                      <label for="description" class="col-sm-2 control-label">Description</label>
                      <div class="col-xs-6">
                        <textarea name="description" class="form-control" placeholder="Enter description"></textarea>
                      </div>
                    </div>

                    <div class="form-group">
                      <div class="col-xs-6 col-sm-offset-2">
                        <center><input type="submit" class="btn btn-info" name="add_item" id="add_item" value="SUBMIT"></center>
                      </div>
                    </div>

                  </form>
                </div>

                </p>
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