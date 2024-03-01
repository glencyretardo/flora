<?php
session_start();
require_once 'database.php';

$success_message = ''; // Variable to store success message
$error_message = ''; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format';
    } else {
        // Phone number validation
        $number = preg_replace('/[^0-9]/', '', $number); // Remove non-numeric characters
        if (strlen($number) !== 12) {
            $error_message = 'Phone number must be exactly 12 digits';
        } else {
            // Using prepared statements to prevent SQL injection
            $insert_query = "INSERT INTO message (Name, Email, ContactNumber, MessageContent) VALUES (?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $insert_query);

            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $number, $message);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $success_message = "Data inserted successfully!";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<?php
session_start();
require_once 'database.php';

$success_message = ''; // Variable to store success message
$error_message = ''; // Variable to store error message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = 'Invalid email format';
    } else {
        // Phone number validation
        $number = preg_replace('/[^0-9]/', '', $number); // Remove non-numeric characters
        if (strlen($number) !== 12) {
            $error_message = 'Phone number must be exactly 12 digits';
        } else {
            // Using prepared statements to prevent SQL injection
            $insert_query = "INSERT INTO message (Name, Email, ContactNumber, MessageContent) VALUES (?, ?, ?, ?)";

            // Prepare the statement
            $stmt = mysqli_prepare($conn, $insert_query);

            // Bind parameters to the statement
            mysqli_stmt_bind_param($stmt, "ssss", $name, $email, $number, $message);

            // Execute the statement
            $result = mysqli_stmt_execute($stmt);

            if ($result) {
                $success_message = "Data inserted successfully!";
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        }
    }
}
?>
<!-- ... (rest of your HTML code remains unchanged) ... -->

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   
</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>contact us</h3>
    <p> <a href="home.php">home</a> / contact </p>
</section>

<section class="contact">
    <form action="" method="POST" id="contactForm">
        <h3>send us a message!</h3>
        <input type="text" name="name" placeholder="enter your name" class="box" required> 
        <input type="email" name="email" id="email" placeholder="enter your email" class="box" required>
        <span id="email-error" class="error-message"></span>
        <input type="tel" name="number" id="number" placeholder="Contact Number" class="box" required>
        <span id="number-error" class="error-message"></span>
        <textarea name="message" class="box" placeholder="enter your message" required cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn" id="sendBtn" disabled>
        <div id="success-message" class="success-message"></div>
    </form>
</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var contactForm = document.getElementById('contactForm');
        var successMessage = document.getElementById('success-message');
        var emailInput = document.getElementById('email');
        var emailError = document.getElementById('email-error');
        var numberInput = document.getElementById('number');
        var numberError = document.getElementById('number-error');
        var sendBtn = document.getElementById('sendBtn');

        contactForm.addEventListener('submit', function (event) {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Your AJAX or form submission logic here

            // Check for validation errors
            if (emailInput.validity.valid && numberInput.value.length === 12) {
                // Display success message
                successMessage.innerText = 'Message Sent!';
                successMessage.style.display = 'block';

                // Reset form fields after 5 seconds
                setTimeout(function () {
                    successMessage.style.display = 'none';
                    contactForm.reset();
                }, 900);
            } else {
                // Display email and/or phone number error
                emailError.innerText = emailInput.validity.valid ? '' : 'Enter a valid email address';
                numberError.innerText = validatePhoneNumber(numberInput.value);
            }
        });

        // Event listener for the email input
        emailInput.addEventListener('input', function () {
            var isValid = emailInput.validity.valid;
            emailError.innerText = isValid ? '' : 'Enter a valid email address';
            updateSendButton();
        });

        // Event listener for the number input
        numberInput.addEventListener('input', function () {
            var isValidNumber = /^\d+$/.test(numberInput.value);
            numberError.innerText = isValidNumber ? validatePhoneNumber(numberInput.value) : 'Phone number must contain only numeric characters';
            updateSendButton();
        });

        // Function to update the state of the "send message" button
        function updateSendButton() {
            sendBtn.disabled = !(emailInput.validity.valid && numberInput.value.length === 12);
        }

        // Function to validate the phone number
        function validatePhoneNumber(phoneNumber) {
            return phoneNumber.length === 12 ? '' : 'Phone number must be exactly 12 digits';
        }
    });
</script>
</body>
</html>