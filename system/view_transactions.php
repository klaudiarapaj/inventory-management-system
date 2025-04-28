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
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.css">
  <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.js"></script>

  <script>
    $(document).ready(function() {
      $('#dtTransactions').DataTable();
    });
  </script>

  <style>
    .btn-add-transaction {
      margin-bottom: 30px;
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
              <li class="active">Transactions</li>
            </ol>
          </div>

          <div class="graph-visual tables-main">
            <div class="graph">
              <div class="block-page">
                <h3 class="inner-tittle two">Transaction History</h3>

                <!-- Add New Transaction Button -->
                <?php if ($role == 'admin' || $role == 'employee') { ?>
                  <a href="add_transaction.php">
                    <button class="btn btn-pill btn-primary btn-add-transaction"style="margin-left:0px">Add New Transaction</button>
                  </a>
                <?php } ?>

                <!-- Transactions Table -->
                <table id="dtTransactions" class="table table-striped table-bordered" cellspacing="0" width="100%">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>Date</th>
                      <th>Total</th>
                      <th>Remarks</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php
                    $transactions = mysqli_query($conn, "SELECT * FROM transactions ORDER BY transaction_date DESC");
                    while ($row = mysqli_fetch_assoc($transactions)) {
                      echo "<tr>
                                <td>{$row['id']}</td>
                                <td>{$row['transaction_date']}</td>
                                <td>{$row['total']} ALL</td>
                                <td>{$row['remarks']}</td>
                              </tr>";
                    }
                    ?>
                  </tbody>
                </table>
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
