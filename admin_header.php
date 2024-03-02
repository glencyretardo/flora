<?php
if (session_status() == PHP_SESSION_NONE) {
   session_start();
}
//var_dump($_SESSION);
if (isset($message)) {
    foreach ($message as $message) {
        echo '
        <div class="message">
            <span>' . $message . '</span>
            <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
        </div>
        ';
    }
}

if (isset($_GET['admin_logout'])) {
   // Unset all of the session variables
   $_SESSION = array();

   // Destroy the session
   session_destroy();

   // Redirect to the login page
   header("Location: admin.php");
   exit();
}
?>
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="admin_style.css"> <!-- Add the link to your CSS file here -->
    <title>Your Admin Page</title>
</head>
<body>

<header class="header">
    <div class="flex">
        <a href="admin_page.php" class="logo">flora.<span>Admin</span></a>
        <nav class="navbar">
            <a href="admin_dashboard.php">home</a>
            <a href="admin_products.php">products</a>
            <a href="admin_orders.php">orders</a>
            <a href="admin_users.php">users</a>
            <a href="admin_contacts.php">messages</a>
        </nav>
        <div class="icons">
            <div id="menu-btn" class="fas fa-bars"></div>
            <div id="user-btn" class="fas fa-user"></div>
        </div>
        <div class="account-box" id="account-box">
            <?php if (isset($_SESSION['admin_name'])) { ?>
                <p>username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
                <a href="?admin_logout" class="delete-btn">logout</a>
                <?php } else { ?>
                <div> | <a href="admin.php">logout</a></div>
            <?php } ?>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var userBtn = document.getElementById('user-btn');
        var accountBox = document.getElementById('account-box');

        userBtn.addEventListener('click', function () {
            accountBox.classList.toggle('visible');
        });

        function logout() {
            // Redirect to the login page
            window.location.href = "admin.php";
        }
    });
</script>

</body>
</html>
