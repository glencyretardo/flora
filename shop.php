<?php

require_once 'database.php';
session_start();


if(isset($_POST['add_to_wishlist'])){

    $product_id = $_POST['ProductID'];
    $product_name = $_POST['ProductName'];
    $product_price = $_POST['Price'];
    $product_image = $_POST['product_image'];



}

if(isset($_POST['add_to_cart'])){

    $product_id = $_POST['ProductID'];
    $product_name = $_POST['ProductName'];
    $product_price = $_POST['Price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];



}

$select_products = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shop</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>our shop</h3>
    <p> <a href="home.php">home</a> / shop </p>
</section>

<section class="products">

   <?php while ($fetch_products = mysqli_fetch_assoc($select_products)) { ?>
      <div class="box-container">
         <form action="" method="POST" class="box">
            <a href="view_page.php?pid=<?php echo $fetch_products['ProductID']; ?>" class="fas fa-eye"></a>
            <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
            <div class="name"><?php echo $fetch_products['ProductName']; ?></div>
            <div class="price">$<?php echo $fetch_products['Price']; ?>/-</div>
            <input type="number" name="product_quantity" value="1" min="0" class="qty">
            <input type="hidden" name="product_id" value="<?php echo $fetch_products['ProductID']; ?>">
            <input type="hidden" name="product_name" value="<?php echo $fetch_products['ProductName']; ?>">
            <input type="hidden" name="product_price" value="<?php echo $fetch_products['Price']; ?>">
            <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
            <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
            <input type="submit" value="add to cart" name="add_to_cart" class="btn">
         </form>
      </div>
   <?php } ?>

</section>

<?php include 'footer.php'; ?>

</body>
</html>