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
   



    // Retrieve cart data
    // Retrieve cart data
$cart_total = 0;
$cart_products = array();
$total_quantity = 0; // Variable to hold the total quantity

$cart_query = mysqli_query($conn, "SELECT c.*, p.ProductName, p.Price FROM cart c JOIN product p ON c.ProductID = p.ProductID WHERE c.UserID = '$user_id'") or die('Query failed');
if (mysqli_num_rows($cart_query) > 0) {
    while ($cart_item = mysqli_fetch_assoc($cart_query)) {
        $cart_products[] = $cart_item['ProductName'] . ' (' . $cart_item['Quantity'] . ') ';
        $sub_total = ($cart_item['Price'] * $cart_item['Quantity']);
        $cart_total += $sub_total;
        $total_quantity += intval($cart_item['Quantity']); // Add the quantity to the total
    }
}

$total_products = implode(', ', $cart_products);


    // Process order
    if ($cart_total == 0) {
        $message[] = 'Your cart is empty!';
    } else {
        // Validating email format before proceeding
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $message[] = 'Invalid email format!';
        } else {
            

            mysqli_query($conn, "INSERT INTO ordertable(UserID, Name, ContactNumber, Email, PaymentMethod, Address, TotalProducts, TotalAmount, OrderDate) VALUES('$user_id', '$name', '$number', '$email', '$method', '$address', '$total_quantity', '$cart_total', NOW())") or die('Query failed');

            mysqli_query($conn, "DELETE FROM cart WHERE UserID = '$user_id'") or die('Query failed');
            $message[] = 'Order placed successfully!';
        }
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
            <div class="grand-total">Grand Total: <span>₱<?php echo number_format ($grand_total); ?></span></div>

        </section>
    </div>
    <section class="checkout-container">
    <div class="left-box">
    <form action="" method="POST" onsubmit="return validateForm()" novalidate>


            <h3>Place Your Order</h3>
            <div class="flex">
                <div class="inputBox">
                    <span>Name:</span>
                    <input type="text" name="name" id="name">
                    <span id="nameError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>Contact Number:</span>
                    <input type="number" name="number" min="0" id="number">
                    <span id="numberError" style="color: red;"></span>
                </div>

                <div class="inputBox">
    <span>Email:</span>
    <input type="email" name="email" id="email" value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
    <span id="emailError" style="color: red;"></span>
</div>



                <div class="inputBox">
                    <span>Payment Method:</span>
                    <select name="method" id="method">
                        <option value="cash on delivery">Cash on Delivery</option>
                        <option value="credit card">Credit Card</option>
                        <option value="paypal">PayPal</option>
                        <option value="gcash">GCash</option>
                    </select>
                    <span id="methodError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>House No.:</span>
                    <input type="number" name="house" min="0" id="house">
                    <span id="houseError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>Street Name:</span>
                    <input type="text" name="street"  id="street">
                    <span id="streetError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>Barangay:</span>
                    <input type="text" name="barangay" id="barangay">
                    <span id="barangayError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>City:</span>
                    <input type="text" name="city" id="city">
                    <span id="cityError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>Country:</span>
                    <input type="text" name="country" id="country">
                    <span id="countryError" style="color: red;"></span>
                </div>

                <div class="inputBox">
                    <span>Zip Code:</span>
                    <input type="number" min="0" name="pin_code" id="pin_code">
                    <span id="pin_codeError" style="color: red;"></span>
                </div>
            </div>

            <input type="submit" name="order" value="Order Now" class="btn">
        </form>
    </div>
</section>
<script>
// Define email validation function outside of the validateForm function
function validateEmail(email) {
    // Regular expression for validating email format
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}

function validateForm() {
    var name = document.getElementById("name").value;
    var house = document.getElementById("house").value;
    var barangay = document.getElementById("barangay").value;
    var city = document.getElementById("city").value;
    var country = document.getElementById("country").value;
    var pin_code = document.getElementById("pin_code").value;
    var email = document.getElementById("email").value;
    var number = document.getElementById("number").value;
    var street = document.getElementById("street").value;

    var isValid = true;

if (name == "") {
    document.getElementById("nameError").innerText = "Name is required";
    isValid = false;
} else if (name.length < 2) {
    document.getElementById("nameError").innerText = "Name must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("nameError").innerText = "";
}

if (house == "") {
    document.getElementById("houseError").innerText = "House number is required";
    isValid = false;
} else if (isNaN(house)) {
    document.getElementById("houseError").innerText = "House number must be a number";
    isValid = false;
} else if (house.length < 2) {
    document.getElementById("houseError").innerText = "House number must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("houseError").innerText = "";
}

if (street == "") {
    document.getElementById("streetError").innerText = "Street name is required";
    isValid = false;
} else if (street.length < 2) {
    document.getElementById("streetError").innerText = "Street name must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("streetError").innerText = "";
}

if (barangay == "") {
    document.getElementById("barangayError").innerText = "Barangay is required";
    isValid = false;
} else if (barangay.length < 2) {
    document.getElementById("barangayError").innerText = "Barangay must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("barangayError").innerText = "";
}

if (city == "") {
    document.getElementById("cityError").innerText = "City is required";
    isValid = false;
} else if (city.length < 2) {
    document.getElementById("cityError").innerText = "City must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("cityError").innerText = "";
}

if (country == "") {
    document.getElementById("countryError").innerText = "Country is required";
    isValid = false;
} else if (country.length < 2) {
    document.getElementById("countryError").innerText = "Country must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("countryError").innerText = "";
}
if (email == "") {
    document.getElementById("emailError").innerText = "Email is required";
    isValid = false;
} else if (!validateEmail(email)) {
    document.getElementById("emailError").innerText = "Enter a valid email";
    document.getElementById("email").focus(); // Set focus to the email input field
    isValid = false;
} else {
    document.getElementById("emailError").innerText = "";
}

if (number == "") {
    document.getElementById("numberError").innerText = "Contact number is required";
    isValid = false;
} else if (isNaN(number)) {
    document.getElementById("numberError").innerText = "Contact number must be a number";
    isValid = false;
} else if (number.length < 2) {
    document.getElementById("numberError").innerText = "Contact number must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("numberError").innerText = "";
}

if (pin_code == "") {
    document.getElementById("pin_codeError").innerText = "ZIP code is required";
    isValid = false;
} else if (isNaN(pin_code)) {
    document.getElementById("pin_codeError").innerText = "ZIP code must be a number";
    isValid = false;
} else if (pin_code.length < 2) {
    document.getElementById("pin_codeError").innerText = "ZIP code must be at least 2 characters long";
    isValid = false;
} else {
    document.getElementById("pin_codeError").innerText = "";
}

return isValid;
}
</script>

<?php include 'footer.php'; ?>
</body>
</html>
