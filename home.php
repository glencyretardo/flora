<?php
include 'database.php';
session_start();

// Ensure that user_id is set before using it
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $userLoggedIn = true;
} else {
    // Handle the case where the user is not logged in
    $userLoggedIn = false;
}

$message = [];

if (isset($_POST['add_to_wishlist'])) {
    if ($userLoggedIn) {
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
    if ($userLoggedIn) {
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
    <!-- ... (your existing head content) ... -->
    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- custom admin css file link  -->
    <link rel="stylesheet" href="style.css">
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="home">
    <img src="images/ehe.jpg" alt="Basket Flowers" class="background-image">
    <div class="content">
       <h3>new collections</h3>
       <p>Welcome to Flora shop! Browse our new collections for you to check-out. These collections will make your loved ones heart flutter. </p>
       <a href="about.php" class="btn">discover more</a>
    </div>


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
                <div class="price">₱<?php echo $fetch_products['Price']; ?></div>
                <img src="uploaded_img/<?php echo $fetch_products['image']; ?>" alt="" class="image">
                <div class="name"><?php echo $fetch_products['ProductName']; ?></div>
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
            echo '<p class="empty">no products added yet!</p>';
        }
        ?>
    </div>
    <div class="more-btn">
        <a href="shop.php" class="option-btn">load more</a>
    </div>
</section>

<section class="home-contact">

<div class="content">
    <h3>have any questions?</h3>
    <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Distinctio officia aliquam quis saepe? Quia, libero.</p>
    <a href="contact.php" class="btn">contact us</a>
</div>
</section>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var forms = document.querySelectorAll('.box.user-logged-in');

        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Redirect to login page
                window.location.href = 'login.php';
            });
        });
    });

    // Function to update header transparency based on scroll position
    function updateHeaderTransparency() {
        var header = document.querySelector('.header');
        var homeSection = document.querySelector('.home');
        var scrollPosition = window.scrollY;
        var homeSectionHeight = homeSection.offsetHeight;

        if (scrollPosition <= homeSectionHeight) {
            header.classList.add('transparent');
        } else {
            header.classList.remove('transparent');
        }
    }

    // Event listener for scroll events
    window.addEventListener('scroll', updateHeaderTransparency);

    // Call the function on page load to set initial transparency
    document.addEventListener('DOMContentLoaded', updateHeaderTransparency);
</script>

<?php include 'footer.php'; ?>
</body>
</html>
