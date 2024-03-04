<?php
include 'database.php';

session_start();


$user_id = null; // Initialize $user_id variable

// Check if user is logged in and retrieve user ID
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
}

if (isset($_POST['add_to_wishlist'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_wishlist_numbers) > 0) {
        $message[] = 'already added to wishlist';
    } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(UserID, ProductID, Name, Price, image, DateAdded) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image', NOW())") or die('query failed');
        $message[] = 'product added to wishlist';
    }
}

if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'already added to cart';
    } else {
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart`(UserID, ProductID, Name, Price, Quantity, image, DateAdded) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_quantity', '$product_image', NOW())") or die('query failed');
        $message[] = 'product added to cart';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>quick view</title>

   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>

    <?php include 'header.php'; ?>

    <section class="quick-view">

        <h1 class="title">product details</h1>

        <?php
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
            $select_products = mysqli_query($conn, "SELECT * FROM `product` WHERE ProductID = '$pid'") or die('query failed');
            if (mysqli_num_rows($select_products) > 0) {
                while ($fetch_products = mysqli_fetch_assoc($select_products)) {
        ?>
                    <form action="" method="POST">
                        <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                        <div class="name"><?php echo $fetch_products['ProductName']; ?></div>
                        <div class="price">₱<?php echo $fetch_products['Price']; ?></div>
                        <div class="details"><?php echo $fetch_products['Description']; ?></div>
                        <input type="number" name="product_quantity" value="1" min="0" class="qty">
                        <input type="hidden" name="product_id" value="<?php echo $fetch_products['ProductID']; ?>">
                        <input type="hidden" name="product_name" value="<?php echo $fetch_products['ProductName']; ?>">
                        <input type="hidden" name="product_price" value="<?php echo $fetch_products['Price']; ?>">
                        <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                        <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
        <?php
                }
            } else {
                echo '<p class="empty">no products details available!</p>';
            }
        }
        ?>

        <div class="more-btn">
            <a href="home.php" class="option-btn">go to home page</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>

</body>

</html>