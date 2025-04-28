<div class="sidebar-menu">
    <header class="logo">
        <a href="#" class="sidebar-icon"> <span class="fa fa-bars"></span> </a> <a href="index.html"> <span id="logo">
                <h1>Inventory Management System</h1>
            </span>
        </a>
    </header>
    <div style="border-top:1px solid rgba(69, 74, 84, 0.7)"></div>
    <!--/down-->
    <div class="down">
        <img style='height:70px;width:70px;' src="images/admin3.jpg">
        <a href="index.php"><span class=" name-caret">
                <?php
                if (isset($_SESSION['name'])) {
                    $name = $_SESSION['name'];
                    echo ucwords($name);
                }
                ?>
            </span></a>
        <p>
        <?php
        if (isset($_SESSION['role'])) {
            echo ucwords($_SESSION['role']); 
        } else {
            echo "User";
        }
        ?>
        </p>
        <ul>
            <li><a class="tooltips" href="profile.php"><span>Profile</span><i class="lnr lnr-user"></i></a></li>
            <li><a class="tooltips" href="logout.php"><span>Log out</span><i class="lnr lnr-power-switch"></i></a></li>
        </ul>
    </div>
    <div class="menu">
        <ul id="menu">
            <?php
            if (isset($_SESSION['login'])) {
            ?>
                <li><a href="index.php"><i class="fa fa-home"></i> <span>Home</span></a></li>
                <li><a href="view_products.php"><i class="fa fa-list"></i> <span>Products</span></a></li>
                <li><a href="view_transactions.php"><i class="fa fa-refresh"></i> <span>Transactions</span></a></li>

               
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li><a href="view_users.php"><i class="fa fa-user"></i> <span>Users</span></a></li>
                <?php } ?>
            <?php } else { ?>
                <li><a href="login.php"><i class="fa fa-tachometer"></i> <span>Login</span></a></li>
            <?php } ?>
        </ul>
    </div>
</div>
