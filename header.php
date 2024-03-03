<?php


function isUserLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: login.php');
    exit();
}
?>

<?php
if (isset($message)) {
    if (is_array($message) || is_object($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
               <span>' . $msg . '</span>
               <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    } else {
        // $message is a string, not an array
        echo '
        <div class="message">
           <span>' . $message . '</span>
           <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}
?>


<header class="header">

    <div class="flex">

        <a href="home.php" class="logo">flora.</a>

        <nav class="navbar">
            <ul>
                <li><a href="home.php">home</a></li>
                <li><a href="#">pages +</a>
                    <ul>
                        <li><a href="about.php">about</a></li>
                        <li><a href="contact.php">contact</a></li>
                    </ul>
                </li>
                <li><a href="shop.php">shop</a></li>
                <li><a href="orders.php">orders</a></li>
                <li>
                    <?php if (isUserLoggedIn()) { ?>
                        <a href="#">account +</a>
                        <ul>
                            <li><a href="#"><?php echo $_SESSION['user_name']; ?></a></li>
                            <li><a href="logout.php">logout</a></li>
                        </ul>
                    <?php } else { ?>
                        <a href="#">account +</a>
                        <ul>
                            <li><a href="login.php">login</a></li>
                            <li><a href="register.php">register</a></li>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </nav>

        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="search.php" class="fas fa-search"></a>
            <div id="user-btn" class="fas fa-user"></div>
            <a href="wishlist.php"><i class="fas fa-heart"></i><span></span></a>
            <a href="cart.php"><i class="fas fa-shopping-cart"></i><span></span></a>
        </div>

        <?php if (isUserLoggedIn()) { ?>
            <div class="account-box">
                <p>username : <span><?php echo $_SESSION['user_name']; ?></span></p>
                <p>email : <span><?php echo $_SESSION['user_email']; ?></span></p>
                <a href="logout.php" class="delete-btn">logout</a>
            </div>
        <?php } ?>

    </div>

</header>
