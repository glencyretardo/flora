<?php
session_start();

function isUserLoggedIn() {
    return isset($_SESSION['admin_id']);
}

function logout() {
    session_unset();
    session_destroy();
    header('Location: admin.php');
    exit();
}
?>

<?php
if(isset($message)){
   foreach($message as $message){
      echo '
      <div class="message">
         <span>'.$message.'</span>
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
   <!-- No CSS links included -->

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
         <div id="user-btn" class="fas fa-user" onclick="toggleAccountBox()"></div>
      </div>
      <div class="account-box" id="account-box">
         <?php if (isUserLoggedIn()) { ?>
            <p>username: <span><?php echo $_SESSION['admin_name']; ?></span></p>
            <p>email: <span><?php echo $_SESSION['admin_email']; ?></span></p>
            <a href="logout.php" class="delete-btn">logout</a>
         <?php } else { ?>
            <div>new <a href="admin.php">login</a> | <a href="adminregister.php">register</a></div>
         <?php } ?>

         <<script>
           function toggleAccountBox() {
        var accountBox = document.getElementById("account-box");
        accountBox.classList.toggle("visible");
    }
</script>

>
      </div>
   </div>
</header>
