<?php
session_start();
require_once "../database/dbconfig.php";

if (!isset($_SESSION['login'])) {
    header("location:login.php");
    exit;
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

        .form-control {
            font-size: 14px;
            height: 35px;
        }

        textarea.form-control {
            height: 80px;
            resize: none;
        }

        .form-body {
            max-width: 700px;
            margin: 0 auto;
        }

        .btn-info {
            padding: 8px 20px;
            font-size: 14px;
        }

        .item-row {
            margin-bottom: 10px;
        }

        .item-row .form-control {
            margin-bottom: 5px;
        }

        .item-row .btn-danger {
            margin-top: 5px;
        }

        .item-row-template {
            display: none;
        }

        hr {
            margin-top: 30px;
        }
    </style>

    <script>
        function addItemRow() {
            const container = document.getElementById('items-container');
            const template = document.querySelector('.item-row-template');
            const newRow = template.cloneNode(true);
            newRow.classList.remove('item-row-template');
            newRow.style.display = 'block';
            container.appendChild(newRow);
        }

        function removeItemRow(btn) {
            btn.closest('.item-row').remove();
        }

        window.onload = addItemRow; 
    </script>
</head>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="inner-content">
                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb m-b-0">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Add Transaction</li>
                        </ol>
                    </div>

                    <div class="graph-visual tables-main">
                        <h2 class="inner-tittle">Add New Transaction</h2>
                        <div class="graph">
                            <div class="block-page">
                                <div class="form-body">
                                    <form class="form-horizontal" method="post" action="myphp.php">

                                        <div class="form-group">
                                            <label class="col-sm-2 control-label">Remarks</label>
                                            <div class="col-sm-10">
                                                <textarea name="remarks" class="form-control" placeholder="Enter any notes or remarks"></textarea>
                                            </div>
                                        </div>

                                        <hr>
                                        <h4>Items</h4>
                                        <div id="items-container"></div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button type="button" class="btn btn-default" onclick="addItemRow()">Add Item</button>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <input type="submit" class="btn btn-info" name="add_transaction" value="Submit Transaction">
                                            </div>
                                        </div>
                                    </form>

                                    <div class="form-group item-row item-row-template">
                                        <div class="col-sm-6">
                                            <select name="item_id[]" class="form-control" required>
                                                <option value="">Select Item</option>
                                                <?php

                                                $res = mysqli_query($conn, "
                                                    SELECT i.itemid, i.title, COALESCE(inv.quantity, 0) AS quantity
                                                    FROM items i
                                                    LEFT JOIN inventory inv ON i.itemid = inv.item_id
                                                ");

                                                while ($row = mysqli_fetch_assoc($res)) {
                                                    echo "<option value='{$row['itemid']}' data-stock='{$row['quantity']}'>
                                                        {$row['title']} ({$row['quantity']} in stock)
                                                    </option>";
                                                }
                                                ?>

                                            </select>
                                        </div>
                                        <div class="col-sm-4">
                                            <input type="number" name="quantity[]" class="form-control" placeholder="Quantity" min="1" required>
                                        </div>
                                        <div class="col-sm-2">
                                            <button type="button" class="btn btn-danger" onclick="removeItemRow(this)">Remove</button>
                                        </div>
                                    </div>
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