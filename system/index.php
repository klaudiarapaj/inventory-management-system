<?php
session_start();
require_once "../database/dbconfig.php";

if (!isset($_SESSION['login'])) {
    header("location:login.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include "head.php"; ?>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="inner-content">

                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Dashboard</li>
                        </ol>
                    </div>

                    <div class="graph-visual tables-main">
                        <h2 class="inner-tittle">
                            Hello,
                            <?php
                            if (isset($_SESSION['name'])) {
                                echo htmlspecialchars(ucwords($_SESSION['name']));
                            }
                            ?> 👋
                        </h2>

                        <div class="graph">
                            <div class="row" style="margin: 15px 0;">
                                <?php
                                $productCount = 0;
                                $res1 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM items");
                                if ($res1 && mysqli_num_rows($res1)) {
                                    $productCount = mysqli_fetch_assoc($res1)['total'];
                                }

                                $txnCount = 0;
                                $res2 = mysqli_query($conn, "SELECT COUNT(*) AS total FROM transactions");
                                if ($res2 && mysqli_num_rows($res2)) {
                                    $txnCount = mysqli_fetch_assoc($res2)['total'];
                                }

                                $lowStock = 0;
                                $res3 = mysqli_query($conn, "SELECT COUNT(*) AS low FROM inventory WHERE quantity < 20");
                                if ($res3 && mysqli_num_rows($res3)) {
                                    $lowStock = mysqli_fetch_assoc($res3)['low'];
                                }
                                ?>

                                <div class="col-md-4">
                                    <div class="dashboard-box" style="background:#f0f9ff;padding:15px;border-radius:6px;box-shadow:0 1px 5px rgba(0,0,0,0.1);">
                                        <h4>Total Products</h4>
                                        <p style="font-size: 24px;"><?php echo $productCount; ?></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="dashboard-box" style="background:#e7ffe7;padding:15px;border-radius:6px;box-shadow:0 1px 5px rgba(0,0,0,0.1);">
                                        <h4>Transactions</h4>
                                        <p style="font-size: 24px;"><?php echo $txnCount; ?></p>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="dashboard-box" style="background:#fff4f4;padding:15px;border-radius:6px;box-shadow:0 1px 5px rgba(0,0,0,0.1);">
                                        <h4>Low Stock Items</h4>
                                        <p style="font-size: 24px;"><?php echo $lowStock; ?></p>
                                    </div>
                                </div>
                            </div>

                            <div style="margin-top: 30px;">
                                <p style="font-size: 15px; line-height: 1.6;">
                                </p>
                            </div>

                        </div>
                    </div>
                </div>

                <?php include "footer.php"; ?>
            </div>
        </div>
        <?php include "side_bar.php"; ?>
    </div>
    <?php include "footer_script.php"; ?>
</body>

</html>