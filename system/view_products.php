<?php
session_start();
require_once "../database/dbconfig.php";


if (!isset($_SESSION['login'])) {
  header("location:login.php");
  exit;
}


$role = $_SESSION['role'];
?>

<!DOCTYPE HTML>
<html>

<head>
  <?php include "head.php"; ?>
  <script type="text/javascript" src="js/nicEdit-latest.js"></script>
  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  <script type="text/javascript">
    $(document).ready(function() {
      $('#dtBasicExample').DataTable();
      $('.dataTables_length').addClass('bs-select');
    });
  </script>
  <style>
    table.dataTable thead>tr>td.sorting,
    table.dataTable thead>tr>td.sorting_asc,
    table.dataTable thead>tr>td.sorting_desc,
    table.dataTable thead>tr>th.sorting,
    table.dataTable thead>tr>th.sorting_asc,
    table.dataTable thead>tr>th.sorting_desc {
      padding-right: 30px
    }

    table.dataTable thead .sorting,
    table.dataTable thead .sorting_asc,
    table.dataTable thead .sorting_asc_disabled,
    table.dataTable thead .sorting_desc,
    table.dataTable thead .sorting_desc_disabled {
      cursor: pointer;
      position: relative
    }


    table.dataTable thead .sorting_asc:before,
    table.dataTable thead .sorting_desc:after {
      opacity: 1
    }

    table.dataTable thead .sorting_asc_disabled:before,
    table.dataTable thead .sorting_desc_disabled:after {
      opacity: 0
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
              <li class="active">My Inventory</li>
            </ol>
          </div>
          <div class="graph-visual tables-main">
            <div class="graph">
              <div class="block-page">
                <p>
                <h3 class="inner-tittle two">Grocery List</h3>

                <!-- Show Add New Items button only for Admins -->
                <?php if ($role == 'admin') { ?>
                  <a href="add_product.php">
                    <button class="btn btn-pill btn-primary btn-add-item">Add New Item</button>
                  </a>
                <?php } ?>

                <div class="form-body">
                  <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                    <thead>
                      <tr>
                        <th class="th-sm">S.no.</th>
                        <th class="th-sm">Title</th>
                        <th class="th-sm">Category</th>
                        <th class="th-sm">Image</th>
                        <th class="th-sm">Price</th>
                        <th class="th-sm">Rating</th> 
                        <th class="th-sm">Stock</th> 
                        <th class="th-sm">Description</th>
                        <th class="th-sm">Operation</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                      
                      $query = "SELECT items.*, categories.name AS category_name, inventory.quantity 
                                FROM items 
                                INNER JOIN categories ON items.category_id = categories.categoryid
                                INNER JOIN inventory ON items.itemid = inventory.item_id"; 
                      $result = mysqli_query($conn, $query); 

                      
                      if ($result) {
                        $n = 1;
                        while ($r = mysqli_fetch_array($result)) {
                          extract($r); 
                      ?>
                          <tr>
                            <td><?php echo $n; ?></td>
                            <td><?php echo ucwords($title); ?></td>
                            <td><?php echo $category_name; ?></td>
                            <td><img src="images/<?php echo $image; ?>" style="height:40px"></td>
                            <td><?php echo $price; ?> ALL</td>
                            <td><?php echo $item_rating; ?> / 5</td>
                            <td><?php echo $quantity; ?></td>
                            <td><?php echo ucwords($description); ?></td>
                            <td>
           
                              <?php if ($role == 'admin' || $role == 'employee') { ?>
                                <a href="myphp.php?edit=yes&id=<?php echo $itemid; ?>">
                                  <span class="glyphicon glyphicon-pencil"></span>
                                </a>
                              <?php } ?>

                              <?php if ($role == 'admin') { ?>
                                &nbsp;&nbsp;&nbsp;
                                <a href="javascript:void(0);" onclick="confirmDelete(<?php echo $itemid; ?>)">
                                  <span class="glyphicon glyphicon-remove"></span>
                                </a>
                              <?php } ?>


                          </tr>
                      <?php
                          $n++; 
                        }
                      } else {
                        
                        echo "<tr><td colspan='7'>No items available</td></tr>";
                      }
                      ?>
                    </tbody>
                  </table>
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
</body>

</html>

<script type="text/javascript">

  function confirmDelete(itemid) {
   
    var result = confirm("Are you sure you want to delete this item?");

    if (result) {
 
      window.location.href = "myphp.php?delete_item=yes&id=" + itemid;
    } else {
     
      return false;
    }
  }
</script>

<style>
.btn-add-item {
  margin-bottom: 30px;
  margin-left: 0px;
}


.table-wrapper {
  margin-top: 20px; 
}
</style>