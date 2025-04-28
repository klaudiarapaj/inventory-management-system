<?php
session_start();  
require_once "../database/dbconfig.php";
if (isset($_SESSION['login'])) {

    header("location:index.php");
}

?>

<!DOCTYPE HTML>
<html>
<?php include "head.php"; ?>

<body>
    <div class="page-container">
        <div class="left-content">
            <div class="inner-content">
                <div class="outter-wp">
                    <div class="sub-heard-part">
                        <ol class="breadcrumb m-b-0">
                            <li><a href="index.html">Home</a></li>
                            <li class="active">Login</li>
                        </ol>
                    </div>

                    <div class="graph-visual tables-main">
                        <h2 class="inner-tittle">Login</h2>
                        <div class="graph">
                            <div class="block-page">
                                <div class="form-body">
                                    <form class="form-horizontal" action="myphp.php" method="post">
                                        <div class="form-group">
                                            <label for="email" id="emailerror" class="col-sm-2 control-label">Email</label>
                                            <div class="col-sm-9">
                                                <input type="text" class="form-control" id="email" name="email" placeholder="Email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="password" id="passworderror" class="col-sm-2 control-label">Password</label>
                                            <div class="col-sm-9">
                                                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-offset-2 col-sm-9">
                                                <input type="submit" class="btn btn-btn-info" style="margin-left:0px" name="login" id="login" value="Login">

                                            </div>
                                        </div>
                                    </form>
                                </div>
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
    <script>
        $(document).ready(function() {
            $("#login").click(function(e) {
                e.preventDefault(); 

                let valid = true;
                let email = $.trim($("#email").val());
                let password = $.trim($("#password").val());
                let emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i;

                // Validation checks
                if (!emailPattern.test(email)) {
                    $("#emailerror").text('Invalid Email').css("color", "red");
                    $("#email").css("border-color", "red");
                    valid = false;
                } else {
                    $("#emailerror").text('Email').css("color", "black");
                    $("#email").css("border-color", "#ddd");
                }

                if (password.length < 6) {
                    $("#passworderror").text('Invalid Password').css("color", "red");
                    $("#password").css("border-color", "red");
                    valid = false;
                } else {
                    $("#passworderror").text('Password').css("color", "black");
                    $("#password").css("border-color", "#ddd");
                }

                if (!valid) return false;

                $.ajax({
                    method: "POST",
                    url: "myphp.php", 
                    data: {
                        email: email,
                        password: password,
                        login: "yes"
                    },
                    success: function(result) {
                        if (result == "1" || result == "2") {
                            window.location = "index.php";
                        } else {
                            alert(result); 
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>