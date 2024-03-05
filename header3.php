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
   <link rel="stylesheet" href="style3.css">

</head>
<body>

<header class="header">
    <div class="flex">
        <div class="logo">Flora.</div>
        <div id="menu-btn" class="fas fa-bars"></div>
        <nav class="navbar">
            <ul>
                <li><a href="#">Home</a></li>
                <li>
                    <a href="#">Pages</a>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                    </ul>
                </li>
                <li><a href="#">Shop</a></li>
                <li><a href="#">Orders</a></li>
                <li>
                    <a href="#">Account</a>
                    <ul>
                        <?php if (isUserLoggedIn()) { ?>
                            <li><a href="#"><?php echo $_SESSION['user_name']; ?></a></li>
                            <li><a href="logout.php">logout</a></li>
                        <?php } else { ?>
                            <li><a href="login.php">login</a></li>
                            <li><a href="register.php">register</a></li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <a href="#" class="fas fa-search"></a>
            <a href="#" class="fas fa-heart"></a>
            <a href="#" class="fas fa-shopping-cart"></a>
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
</script>

</body>
</html>

