<?php

include 'database.php';

session_start();

$user_id = $_SESSION['user_id'];

if (isset($_POST['order'])) {
    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $method = mysqli_real_escape_string($conn, $_POST['method']);
    $address = mysqli_real_escape_string($conn, 'house no. ' . $_POST['house'] . ', ' . $_POST['street'] . ', ' . $_POST['barangay'] . ', ' . $_POST['city'] . ', ' . $_POST['country'] . ' - ' . $_POST['pin_code']);
    $placed_on = date('d-M-Y');

    // Retrieve cart data
    $cart_total = 0;
    $cart_products = array();

    $cart_query = mysqli_query($conn, "SELECT c.*, p.ProductName, p.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE c.UserID = '$user_id'") or die('Query failed');
    if (mysqli_num_rows($cart_query) > 0) {
        while ($cart_item = mysqli_fetch_assoc($cart_query)) {
            $cart_products[] = $cart_item['ProductName'] . ' (' . $cart_item['Quantity'] . ') ';
            $sub_total = ($cart_item['Price'] * $cart_item['Quantity']);
            $cart_total += $sub_total;
        }
    }

    $total_products = implode(', ', $cart_products);

    // Check if order already exists
    $order_query = mysqli_query($conn, "SELECT * FROM ordertable WHERE Name = '$name' AND ContactNumber = '$number' AND Email = '$email' AND PaymentMethod = '$method' AND Address = '$address' AND TotalProducts = '$total_products' AND TotalAmount = '$cart_total'") or die('Query failed');

    // Process order
    if ($cart_total == 0) {
        $message[] = 'Your cart is empty!';
    } elseif (mysqli_num_rows($order_query) > 0) {
        $message[] = 'Order placed already!';
    } else {
        mysqli_query($conn, "INSERT INTO ordertable(UserID, Name, ContactNumber, Email, PaymentMethod, Address, TotalProducts, TotalAmount, DateAdded) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_products', '$cart_total', '$placed_on')") or die('Query failed');
        mysqli_query($conn, "DELETE FROM cart WHERE UserID = '$user_id'") or die('Query failed');
        $message[] = 'Order placed successfully!';
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Custom admin CSS file link -->
    <link rel="stylesheet" href="style.css">

</head>
<body>

    <?php include 'header.php'; ?>

    <section class="heading">
        <h3>Checkout Order</h3>
        <p><a href="home.php">Home</a> / Checkout</p>
    </section>

    <div class="right-box">
        <section class="display-order">
            <?php
            $grand_total = 0;
            $select_cart = mysqli_query($conn, "SELECT c.*, p.ProductName, p.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE c.UserID = '$user_id'") or die('Query failed');
            if (mysqli_num_rows($select_cart) > 0) {
                while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
                    $total_price = ($fetch_cart['Price'] * $fetch_cart['Quantity']);
                    $grand_total += $total_price;
            ?>
                    <p><?php echo $fetch_cart['ProductName'] ?> <span><?php echo '₱' . $fetch_cart['Price'] . ' x ' . $fetch_cart['Quantity'] ?></span> </p>
            <?php
                }
            } else {
                echo '<p class="empty">Your cart is empty</p>';
            }
            ?>
            <div class="grand-total">Grand Total: <span>₱<?php echo $grand_total; ?></span></div>
        </section>
    </div>
</section>

    <section class="checkout-container">
    <div class="left-box">
        <form action="" method="POST">

            <h3>Place Your Order</h3>

            <div class="flex">
                <div class="inputBox">
                    <span>Name:</span>
                    <input type="text" name="name">
                </div>

                <div class="inputBox">
                    <span>Contact Number:</span>
                    <input type="number" name="number" min="0">
                </div>

                <div class="inputBox">
                    <span>Email:</span>
                    <input type="email" name="email">
                </div>

                <div class="inputBox">
                    <span>Payment Method:</span>
                    <select name="method">
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="gcash">GCash</option>
                    </select>
                </div>

                <div class="inputBox">
                    <span>House No.:</span>
                    <input type="text" name="house">
                </div>

                <div class="inputBox">
                    <span>Street Name:</span>
                    <input type="text" name="street">
                </div>

                <div class="inputBox">
                    <span>Barangay:</span>
                    <input type="text" name="barangay">
                </div>

                <div class="inputBox">
                    <span>City:</span>
                    <input type="text" name="city">
                </div>

                <div class="inputBox">
                    <span>Country:</span>
                    <input type="text" name="country">
                </div>

                <div class="inputBox">
                    <span>Zip Code:</span>
                    <input type="number" min="0" name="pin_code">
                </div>
            </div>

            <input type="submit" name="order" value="Order Now" class="btn">
        </form>
    </div>
</section>

    <?php include 'footer.php'; ?>

</body>

</html>
