<?php
require_once 'database.php';
session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
    exit(); // Add exit to stop script execution after header redirect
}

if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `cart` WHERE CartID = '$delete_id'") or die('query failed');
    header('location:cart.php');
    exit(); // Add exit to stop script execution after header redirect
}

if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `cart` WHERE UserID = '$user_id'") or die('query failed');
    header('location:cart.php');
    exit(); // Add exit to stop script execution after header redirect
}

if (isset($_POST['update_quantity'])) {
    $cart_id = $_POST['cart_id'];
    $cart_quantity = $_POST['cart_quantity'];
    mysqli_query($conn, "UPDATE `cart` SET Quantity = '$cart_quantity' WHERE CartID = '$cart_id'") or die('query failed');
    $message[] = 'cart quantity updated!';
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>shopping cart</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="style.css">

</head>

<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>shopping cart</h3>
    <p> <a href="home.php">home</a> / cart </p>
</section>


<section class="shopping-cart">

    <h1 class="title">products added</h1>

    <div class="box-container">

        <?php
        $grand_total = 0;
        $select_cart = mysqli_query($conn, "SELECT cart.CartID, cart.Quantity, cart.DateAdded, product.ProductID, product.ProductName, product.Price, product.Image FROM `cart` JOIN `product` ON cart.ProductID = product.ProductID WHERE cart.UserID = '$user_id'") or die('query failed');
        if (mysqli_num_rows($select_cart) > 0) {
            while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                ?>
                <div class="box">
                    <a href="cart.php?delete=<?php echo $fetch_cart['CartID']; ?>" class="fas fa-times" onclick="return confirm('delete this from cart?');"></a>
                    <a href="view_page.php?pid=<?php echo $fetch_cart['ProductID']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?php echo $fetch_cart['Image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_cart['ProductName']; ?></div>
                    <div class="price">$<?php echo $fetch_cart['Price']; ?>/-</div>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
    <input type="hidden" value="<?php echo $fetch_cart['CartID']; ?>" name="cart_id">
    <input type="number" min="1" value="<?php echo $fetch_cart['Quantity']; ?>" name="cart_quantity" class="qty">
    <input type="submit" value="update" class="option-btn" name="update_quantity">
</form>

                    <div class="sub-total"> sub-total : <span>$<?php echo $sub_total = ($fetch_cart['Price'] * $fetch_cart['Quantity']); ?>/-</span> </div>
                </div>
                <?php
                $grand_total += $sub_total;
            }
        } else {
            echo '<p class="empty">your cart is empty</p>';
        }
        ?>
    </div>

    <div class="more-btn">
        <a href="cart.php?delete_all" class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>"
           onclick="return confirm('delete all from cart?');">delete all</a>
    </div>

    <div class="cart-total">
        <p>grand total : <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">continue shopping</a>
        <a href="checkout.php" class="btn  <?php echo ($grand_total > 1) ? '' : 'disabled' ?>">proceed to checkout</a>
    </div>

</section>

<?php include 'footer.php'; ?>

</body>
</html>