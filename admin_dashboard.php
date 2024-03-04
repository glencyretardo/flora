<?php
session_start();

if (!isset($_SESSION['admin_name'])) {
   header("Location: admin.php");
   exit();
}
require_once 'database.php';
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
    <link rel="stylesheet" href="admin_style.css">

</head>

<body>

    <?php include 'admin_header.php'; ?>

    <section class="dashboard">

        <h1 class="title">dashboard</h1>

        <div class="box-container">

        <div class="box">
                <?php
                $select_pendings = mysqli_query($conn, "SELECT COUNT(*) AS total_pendings FROM `ordertable` WHERE payment_status = 'pending'") or die('query failed');
                $fetch_pendings = mysqli_fetch_assoc($select_pendings);
                $total_pendings = $fetch_pendings['total_pendings'];
                ?>
                <h3><?php echo $total_pendings; ?></h3>
                <p>total pendings</p>
            </div>


            <div class="box">
                <?php
                $select_completes = mysqli_query($conn, "SELECT COUNT(*) AS total_completes FROM `ordertable` WHERE payment_status = 'completed'") or die('query failed');
                $fetch_completes = mysqli_fetch_assoc($select_completes);
                $total_completes = $fetch_completes['total_completes'];
                ?>
                <h3><?php echo $total_completes; ?></h3>
                <p>completed orders</p>
            </div>


            <div class="box">
                <?php
                $select_orders = mysqli_query($conn, "SELECT * FROM `ordertable`") or die('query failed');
                $number_of_orders = mysqli_num_rows($select_orders);
                ?>
                <h3><?php echo $number_of_orders; ?></h3>
                <p>orders placed</p>
            </div>

            <div class="box">
                <?php
                $select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
                $number_of_products = mysqli_num_rows($select_products);
                ?>
                <h3><?php echo $number_of_products; ?></h3>
                <p>products added</p>
            </div>

            <div class="box">
                <?php
                $select_users = mysqli_query($conn, "SELECT * FROM `users`") or die('query failed');
                $number_of_users = mysqli_num_rows($select_users);
                ?>
                <h3><?php echo $number_of_users; ?></h3>
                <p>users</p>
            </div>

            <div class="box">
                <?php
                $select_messages = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
                $number_of_messages = mysqli_num_rows($select_messages);
                ?>
                <h3><?php echo $number_of_messages; ?></h3>
                <p>messages</p>
            </div>

        </div>

    </section>

</body>

</html>
