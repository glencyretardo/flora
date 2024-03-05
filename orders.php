<?php

require_once  'database.php';
session_start();

?>



<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>orders</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>your orders</h3>
    <a id="backButton" href="home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

</section>



<section class="placed-orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">
        <?php
        $user_id = $_SESSION['user_id'] ?? null;

        $select_orders = mysqli_query($conn, "SELECT * FROM `ordertable` WHERE UserID = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_orders) > 0) {
            while ($fetch_orders = mysqli_fetch_assoc($select_orders)) {
            ?>
                <div class="box">
                    <p> placed on : <span><?php echo $fetch_orders['OrderDate']; ?></span> </p>
                    <p> name : <span><?php echo $fetch_orders['Name']; ?></span> </p>
                    <p> number : <span><?php echo $fetch_orders['ContactNumber']; ?></span> </p>
                    <p> email : <span><?php echo $fetch_orders['Email']; ?></span> </p>
                    <p> address : <span><?php echo $fetch_orders['Address']; ?></span> </p>
                    <p> payment method : <span><?php echo $fetch_orders['PaymentMethod']; ?></span> </p>
                    <p> your orders : <span><?php echo $fetch_orders['TotalProducts']; ?></span> </p>
                    <p> total price : <span>₱<?php echo $fetch_orders['TotalAmount']; ?></span> </p>
                    <p> Order status : <span style="color:<?php echo ($fetch_orders['payment_status'] == 'pending') ? 'tomato' : 'green'; ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
                </div>
            <?php
            }
        } else {
            echo "No orders found.";
        }
        ?>
    </div>
</section>

<?php include 'footer.php'; ?>

<script>
    document.getElementById("backButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default behavior of anchor element
        window.location.href = this.href; // Navigate to the specified href
    });
</script>

</body>
</html>