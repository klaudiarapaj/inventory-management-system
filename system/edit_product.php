<?php
require_once "../database/dbconfig.php";
session_start();
if (!isset($_SESSION['login'])) {
    header("location:login.php");
    exit;
}

$itemid = $_GET['id'];
$query = "SELECT items.*, inventory.quantity FROM items 
          INNER JOIN inventory ON items.itemid = inventory.item_id 
          WHERE items.itemid = '$itemid'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);
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
                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb m-b-0">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Edit Product</li>
                        </ol>
                    </div>
                    <div class="graph-visual tables-main">
                        <h2 class="inner-tittle">Edit Product</h2>
                        <div class="graph" style="height:1000px">
                            <div class="block-page">
                                <p>
                                <div class="form-body">
                                    <form class="form-horizontal" action="myphp.php" method="post" enctype="multipart/form-data">

                                        <input type="hidden" name="uid" value="<?php echo $product['itemid']; ?>">

                                        <div class="form-group">
                                            <label for="utitle" class="col-sm-2 control-label">Title</label>
                                            <div class="col-xs-6">
                                                <input type="text" class="form-control" name="utitle" value="<?php echo htmlspecialchars($product['title']); ?>" placeholder="Title" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="ucategory" class="col-sm-2 control-label">Category</label>
                                            <div class="col-xs-6">
                                                <select class="form-control" name="ucategory" required>
                                                    <option value="" selected disabled>Select Category</option>
                                                    <option value="1" <?php echo ($product['category_id'] == 1) ? 'selected' : ''; ?>>Fruits & Vegetables</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="urating" class="col-sm-2 control-label">Rating</label>
                                            <div class="col-xs-6">
                                                <input type="number" class="form-control" name="urating" min="1" max="5" value="<?php echo $product['item_rating']; ?>" placeholder="Rating">
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="uimage" class="col-sm-2 control-label">Image</label>
                                            <div class="col-xs-6">
                                                <input type="file" class="form-control" name="uimage">
                                                <?php if (!empty($product['image'])) : ?>
                                                    <img src="images/<?php echo $product['image']; ?>" height="60">
                                                <?php endif; ?>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="uprice" class="col-sm-2 control-label">Price</label>
                                            <div class="col-xs-6">
                                                <input type="text" class="form-control" name="uprice" value="<?php echo $product['price']; ?>" placeholder="Price" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="uquantity" class="col-sm-2 control-label">Quantity</label>
                                            <div class="col-xs-6">
                                                <input type="text" class="form-control" name="uquantity" value="<?php echo $product['quantity']; ?>" placeholder="Quantity" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="udescription" class="col-sm-2 control-label">Description</label>
                                            <div class="col-xs-6">
                                                <textarea name="udescription" class="form-control" placeholder="Enter description"><?php echo htmlspecialchars($product['description']); ?></textarea>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-xs-6 col-sm-offset-2">
                                                <center><input type="submit" class="btn btn-info" name="update_item" value="UPDATE"></center>
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