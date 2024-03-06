<?php

include 'database.php';

session_start();

// Function to redirect to the login page
function redirectToLogin() {
    header("Location: login.php");
    exit();
}

if (isset($_POST['add_to_wishlist'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        redirectToLogin();
    }

    $user_id = $_SESSION['user_id'];

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');
    
    
    if(mysqli_num_rows($check_wishlist_numbers) > 0){
        $message[] = 'already added to wishlist';
    } elseif(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    } else {
        mysqli_query($conn, "INSERT INTO `wishlist`(UserID, ProductID, ProductName, Price, image) VALUES('$user_id', '$product_id', '$product_name', '$product_price', '$product_image')") or die('query failed');
        $message[] = 'product added to wishlist';
    }

} elseif (isset($_POST['add_to_cart'])) {
    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login page if not logged in
        redirectToLogin();
    }

    $user_id = $_SESSION['user_id'];

    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = $_POST['product_quantity'];

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');
    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

    if(mysqli_num_rows($check_cart_numbers) > 0){
        $message[] = 'already added to cart';
    } else {

        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

        if(mysqli_num_rows($check_wishlist_numbers) > 0){
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

        }

        mysqli_query($conn, "INSERT INTO `cart`(UserID, ProductID, Quantity, DateAdded) VALUES('$user_id', '$product_id', '$product_quantity', NOW())") or die('query failed');
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
   <title>search page</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>search page</h3>
    <a id="backButton" href="home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

</section>

<section class="search-form">
    <form action="" method="POST">
        <input type="text" class="box" placeholder="search products..." name="search_box">
        <input type="submit" class="btn" value="search" name="search_btn">
    </form>
</section>

<section class="products" style="padding-top: 0;">

   <div class="box-container">

   <?php
if (isset($_POST['search_btn'])) {
    $search_box = mysqli_real_escape_string($conn, $_POST['search_box']);
    $select_products = mysqli_query($conn, "SELECT * FROM `product` WHERE ProductName LIKE '%{$search_box}%' OR Description LIKE '%{$search_box}%'") or die('query failed');
    if (mysqli_num_rows($select_products) > 0) {
        while ($fetch_products = mysqli_fetch_assoc($select_products)) {
?>
            <form action="" method="POST" class="box">
                <a href="view_page.php?pid=<?php echo $fetch_products['ProductID']; ?>" class="fas fa-eye"></a>
                <div class="price">₱<?php echo number_format($fetch_products['Price']); ?></div>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['ProductName']; ?></div>
                <div class="description"><?php echo $fetch_products['Description']; ?></div>
                <input type="number" name="product_quantity" value="1" min="0" class="qty">
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['ProductID']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['ProductName']; ?>">
                <input type="hidden" name="product_price" value="<?php echo number_format($fetch_products['Price']); ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
            </form>
<?php
        }
    } else {
        echo '<p class="empty">no result found!</p>';
    }
} else {
    echo '<p class="empty">search something!</p>';
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
