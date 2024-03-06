<?php
require_once 'database.php';

session_start();

$user_id = $_SESSION['user_id'];

if (!isset($user_id)) {
    header('location:login.php');
}

$message = ''; // Variable to store error or success message

if (isset($_POST['send'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $select_message = mysqli_query($conn, "SELECT * FROM message WHERE Name = '$name' AND Email = '$email' AND ContactNumber = '$number' AND MessageContent = '$msg'") or die('query failed');

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Invalid email format';
    }
    
    if (mysqli_num_rows($select_message) > 0) {
        $message = 'Message has already been sent!';
    } else {

        $insert_query = "INSERT INTO `message` ( Name, Email, ContactNumber, MessageContent) VALUES ( '$name', '$email', '$number', '$msg')";
        if (mysqli_query($conn, $insert_query)) {
            $message = 'Message sent successfully!';
        } else {
            $message = 'Error: ' . mysqli_error($conn);
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
    <title>Contact</title>

    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="style.css">

    <style>
        .error-message {
            color: red; /* Set the color of the error message */
            font-size: 12px; /* Adjust font size if needed */
        }
    </style>
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>Contact Us</h3>
    <p><a href="home.php">Home</a> / Contact</p>
</section>

<section class="contact">
    <form action="" method="POST" onsubmit="return validateForm()" novalidate> <!-- Add novalidate attribute to disable browser validation -->
        <h3>Send us a message!</h3>
        <input type="text" name="name" id="name" placeholder="Enter your name" class="box" required> 
        <br>
        <input type="email" name="email" id="email" placeholder="Enter your email" class="box" required>
        <span id="email-error" class="error-message"></span> <!-- Error message for email -->
        <br>
        <input type="tel" name="number" id="number" placeholder="Enter your number" class="box" required>
        <span id="number-error" class="error-message"></span> <!-- Error message for number -->
        <br>
        <textarea name="message" class="box" placeholder="Enter your message" required cols="30" rows="10"></textarea>
        <br>
        <input type="submit" value="Send Message" name="send" class="btn">
        <!-- <div class="message"><?php echo $message; ?></div> -->
    </form>
</section>

<?php include 'footer.php'; ?>

<script>
    function validateForm() {
        var name = document.getElementById('name').value;
        var email = document.getElementById('email').value;
        var number = document.getElementById('number').value;

        // Validate email format
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            document.getElementById('email-error').innerText = 'Please enter a valid email address.'; // Show error message
            return false;
        } else {
            document.getElementById('email-error').innerText = ''; // Clear error message if valid
        }

        // Validate number format and length
        var numberPattern = /^\d{11}$/;
        if (!numberPattern.test(number)) {
            document.getElementById('number-error').innerText = 'Please enter a 11-digit contact number.'; // Show error message
            return false;
        } else {
            document.getElementById('number-error').innerText = ''; // Clear error message if valid
        }

        return true;
    }
</script>

</body>
</html>
