<?php
session_start();
require_once "../database/dbconfig.php";

if (!isset($_SESSION['login']) || $_SESSION['role'] != 'admin') {
    header("location:login.php");
    exit;
}


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
</head>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="inner-content">
                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb m-b-0">
                            <li><a href="index.php">Home</a></li>
                            <li class="active">Manage Users</li>
                        </ol>
                    </div>
                    <div class="graph-visual tables-main">
                        <div class="graph">
                            <div class="block-page">
                                <p>
                                <h3 class="inner-tittle two">Users List</h3>

                                <!-- Add New User Button -->
                                <a href="add_user.php">
                                    <button class="btn btn-pill btn-primary btn-add-item">Add New User</button>
                                </a>

                                <div class="form-body">
                                    <table id="dtBasicExample" class="table table-striped table-bordered" cellspacing="0" width="100%">
                                        <thead>
                                            <tr>
                                                <th class="th-sm">S.no.</th>
                                                <th class="th-sm">Name</th>
                                                <th class="th-sm">Email</th>
                                                <th class="th-sm">Role</th>
                                                <th class="th-sm">Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = "SELECT * FROM users";
                                            $result = mysqli_query($conn, $query);
                                            $n = 1;
                                            while ($r = mysqli_fetch_array($result)) {
                                                $user_id = $r['userid'];
                                                $name = $r['name'];
                                                $email = $r['email'];
                                                $role = $r['role'];

                                                echo "<tr>";
                                                echo "<td>" . $n . "</td>";
                                                echo "<td>" . ucwords($name) . "</td>";
                                                echo "<td>" . $email . "</td>";
                                                echo "<td>" . ucwords($role) . "</td>";
                                                echo "<td>";
                                                echo "<a href='edit_user.php?id=" . $user_id . "' title='Edit'>
            <span class='glyphicon glyphicon-pencil'></span>
          </a>";
                                                if ($role !== 'admin') {
                                                    echo "&nbsp;&nbsp;&nbsp;
              <a href='javascript:void(0);' onclick='confirmDelete(" . $user_id . ")' title='Delete'>
                <span class='glyphicon glyphicon-remove'></span>
              </a>";
                                                }
                                                echo "</td>";
                                                echo "</tr>";
                                                $n++;
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

    <script type="text/javascript">
        function confirmDelete(user_id) {
            var result = confirm("Are you sure you want to delete this user?");
            if (result) {
                window.location.href = "myphp.php?delete_user=yes&id=" + user_id;
            } else {
              
                return false;
            }
        }
    </script>
</body>

</html>

<style>
    .btn-add-item {
        margin-bottom: 30px;
        margin-left: 0px;
    }


    .table-wrapper {
        margin-top: 20px;
    }
</style>