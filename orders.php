<?php


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
    <p> <a href="home.php">home</a> / orders </p>
</section>

<section class="placed-orders">

    <h1 class="title">placed orders</h1>

    <div class="box-container">

 
    <div class="box">
        <p> placed on : <span><?php echo $fetch_orders['OrderDate']; ?></span> </p>
        <p> name : <span><?php echo $fetch_orders['Name']; ?></span> </p>
        <p> number : <span><?php echo $fetch_orders['number']; ?></span> </p>
        <p> email : <span><?php echo $fetch_orders['Email']; ?></span> </p>
        <p> address : <span><?php echo $fetch_orders['Address']; ?></span> </p>
        <p> payment method : <span><?php echo $fetch_orders['PaymentMethod']; ?></span> </p>
        <p> your orders : <span><?php echo $fetch_orders['TotalProducts']; ?></span> </p>
        <p> total price : <span>$<?php echo $fetch_orders['TotalAmount']; ?>/-</span> </p>
        <p> payment status : <span style="color:<?php if($fetch_orders['payment_status'] == 'pending'){echo 'tomato'; }else{echo 'green';} ?>"><?php echo $fetch_orders['payment_status']; ?></span> </p>
    </div>
    </div>

</section>


<?php include 'footer.php'; ?>

</body>
</html>