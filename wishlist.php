<?php
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    // Redirect to the login page or handle the case where the user is not logged in
    header('Location: login.php');
    exit();
}

// Include your database connection file
include 'database.php';

// Check if the database connection is established
if (!isset($conn)) {
    // Handle the case where $conn is not defined
    die('Database connection error');
}

// Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;

    $check_cart_numbers = mysqli_query($conn, "SELECT * FROM `cart` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('Query failed');

    if (mysqli_num_rows($check_cart_numbers) > 0) {
        $message[] = 'Already added to cart';
    } else {
        $check_wishlist_numbers = mysqli_query($conn, "SELECT * FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('Query failed');

        if (mysqli_num_rows($check_wishlist_numbers) > 0) {
            mysqli_query($conn, "DELETE FROM `wishlist` WHERE ProductID = '$product_id' AND UserID = '$user_id'") or die('Query failed');
        }

        mysqli_query($conn, "INSERT INTO `cart` (UserID, ProductID, Quantity) VALUES ('$user_id', '$product_id', '$product_quantity')") or die('Query failed');

        $message[] = 'Product added to cart';
    }
}

// Delete from Wishlist functionality
if (isset($_GET['delete'])) {
    $delete_id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE id = '$delete_id'") or die('Query failed');
    header('Location: wishlist.php');
}

// Delete all from Wishlist functionality
if (isset($_GET['delete_all'])) {
    mysqli_query($conn, "DELETE FROM `wishlist` WHERE UserID = '$user_id'") or die('Query failed');
    header('Location: wishlist.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wishlist</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom admin CSS file link -->
    <link rel="stylesheet" href="style.css">
</head>
<body>

<?php include 'header.php'; ?>

<section class="heading">
    <h3>Your Wishlist</h3>
    <a id="backButton" href="home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

</section>

<section class="wishlist">
    <h1 class="title">Products Added</h1>
    <div class="box-container">
        <?php
        $grand_total = 0;
        $select_wishlist = mysqli_query($conn, "SELECT w.*, p.image, p.ProductName AS product_name, p.price FROM `wishlist` w
                                                INNER JOIN `product` p ON w.ProductID = p.ProductID
                                                WHERE w.UserID = '$user_id'") or die('Query failed');
        if (mysqli_num_rows($select_wishlist) > 0) {
            while ($fetch_wishlist = mysqli_fetch_assoc($select_wishlist)) {
                ?>
                <form action="" method="POST" class="box">
                    <a href="wishlist.php?delete=<?php echo $fetch_wishlist['WishlistID']; ?>" class="fas fa-times"
                       onclick="return confirm('Delete this from wishlist?');"></a>
                    <a href="view_page.php?pid=<?php echo $fetch_wishlist['ProductID']; ?>" class="fas fa-eye"></a>
                    <img src="uploaded_img/<?php echo $fetch_wishlist['image']; ?>" alt="" class="image">
                    <div class="name"><?php echo $fetch_wishlist['product_name']; ?></div>
                    <div class="price">₱<?php echo $fetch_wishlist['price']; ?></div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_wishlist['ProductID']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_wishlist['product_name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_wishlist['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_wishlist['image']; ?>">
                    <input type="submit" value="Add to Cart" name="add_to_cart" class="btn">
                </form>
                <?php
                $grand_total += $fetch_wishlist['price'];
            }
        } else {
            echo '<p class="empty">Your wishlist is empty</p>';
        }
        ?>
    </div>
    <div class="wishlist-total">
        <p>Grand Total: <span>$<?php echo $grand_total; ?>/-</span></p>
        <a href="shop.php" class="option-btn">Continue Shopping</a>
        <a href="wishlist.php?delete_all"
           class="delete-btn <?php echo ($grand_total > 1) ? '' : 'disabled' ?>"
           onclick="return confirm('Delete all from wishlist?');">Delete All</a>
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
