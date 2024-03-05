<?php
include 'database.php';
session_start();

// Initialize the messages array
$message = [];


if (isset($_POST['add_to_wishlist'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $user_id = $_SESSION['user_id'];

        // Check if the product is already in the wishlist or cart
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');
        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            $message[] = 'already added to wishlist';
        } elseif (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'already added to cart';
        } else {
            // Insert only UserID, ProductID, and DateAdded into the wishlist
            mysqli_query($conn, "INSERT INTO `wishlist` (UserID, ProductID, DateAdded) VALUES ('$user_id', '$product_id', NOW())") or die(mysqli_error($conn));
            $message[] = 'product added to wishlist';
        }
    } else {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }
}

if (isset($_POST['add_to_cart'])) {
    if (isset($_SESSION['user_id'])) {
        $product_id = $_POST['product_id'];
        $product_name = $_POST['product_name'];
        $product_price = $_POST['product_price'];
        $product_image = $_POST['product_image'];
        $product_quantity = $_POST['product_quantity'];
        $user_id = $_SESSION['user_id'];

        // Check if the product is already in the cart
        $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

        if (mysqli_num_rows($check_cart_numbers) > 0) {
            $message[] = 'already added to cart';
        } else {
            // Check if the product is in the wishlist and remove it
            $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');

            if (mysqli_num_rows($check_wishlist_numbers) > 0) {
                mysqli_query($conn, "DELETE FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('query failed');
            }

            // Add the product to the cart
            $sql = "INSERT INTO `cart` (UserID, ProductID, Quantity, DateAdded) VALUES ('$user_id', '$product_id', '$product_quantity', NOW())";
            mysqli_query($conn, $sql) or die(mysqli_error($conn));
            $message[] = 'product added to cart';
        }
    } else {
        // Redirect to login page
        header('Location: login.php');
        exit();
    }
}
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
    <a id="backButton" href="home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

</section>


<section class="products">
    <h1 class="title">latest products</h1>
    <div class="box-container">
        <?php
        $select_products = mysqli_query($conn, "SELECT * FROM `product` LIMIT 6") or die('query failed');
        if(mysqli_num_rows($select_products) > 0){
            while($fetch_products = mysqli_fetch_assoc($select_products)){
        ?>
        <form action="" method="POST" class="box <?php echo $userLoggedIn ? 'user-logged-in' : ''; ?>">
        <a href="view_page.php?pid=<?php echo $fetch_products['ProductID']; ?>" class="fas fa-eye"></a>
                <div class="price">₱<?php echo number_format($fetch_products['Price']); ?></div>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['ProductName']; ?></div>
                <input type="number" name="product_quantity" value="1" min="0" class="qty">
                <input type="hidden" name="product_id" value="<?php echo $fetch_products['ProductID']; ?>">
                <input type="hidden" name="product_name" value="<?php echo $fetch_products['ProductName']; ?>">
                <input type="hidden" name="product_price" value="₱<?php echo number_format($fetch_products['Price']); ?>">
                <input type="hidden" name="product_image" value="<?php echo $fetch_products['image']; ?>">
                <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                <input type="submit" value="add to cart" name="add_to_cart" class="btn">
        </form>
        <?php
            }
        } else {
            echo '<p class="empty">no products added yet!</p>';
        }        ?>
    </div>
</section>


<script>
    document.getElementById("backButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default behavior of anchor element
        window.location.href = this.href; // Navigate to the specified href
    });
</script>

<?php include 'footer.php'; ?>


</body>
</html>
