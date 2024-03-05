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


<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="style2.css">

</head>
<body>

<header class="header">
    <div class="flex">
    <div class="logo-container">
            <h1 class="logo">Flora</h1>
        </div>
        <div id="menu-btn" class="fas fa-bars"></div>
        <nav class="navbar">
            <ul class="menu">
                <li><a href="home.php">Home</a></li>
                <li><a href="#">Pages</a>
                    <ul>
                        <li><a href="about.php">About</a></li>
                        <li><a href="orders.php">Contact</a></li>
                    </ul>
                </li>
                <li><a href="shop.php">Shop</a></li>
                <li><a href="orders.php">Orders</a></li>
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
            <a href="search.php" class="fas fa-search"></a>
            <a href="wishlist.php" class="fas fa-heart"></a>
            <a href="cart.php" class="fas fa-shopping-cart"></a>
        </div>
    </div>
</header>


<?php if (isUserLoggedIn()) { ?>
    <div class="account-box">
        <p>Username: <span><?php echo $_SESSION['user_name']; ?></span></p>
        <p>Email: <span><?php echo $_SESSION['user_email']; ?></span></p>
        <a href="logout.php" class="delete-btn">Logout</a>
    </div>
<?php } ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var header = document.querySelector('.header');
    header.addEventListener('click', function() {
        header.classList.toggle('opaque-header');
    });
});

document.addEventListener('DOMContentLoaded', function() {
    var menuBtn = document.getElementById('menu-btn');
    var navbar = document.querySelector('.navbar');

    menuBtn.addEventListener('click', function() {
        navbar.classList.toggle('active');
    });
});
</script>

</body>
</html>

