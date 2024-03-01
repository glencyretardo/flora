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
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>contact us</h3>
    <p> <a href="home.php">home</a> / contact </p>
</section>

<section class="contact">
    <form action="" method="POST" id="contactForm">
        <h3>send us a message!</h3>
        <input type="text" name="name" placeholder="enter your name" class="box" required> 
        <input type="email" name="email" placeholder="enter your email" class="box" required>
        <input type="tel" name="number" id="number" placeholder="Contact Number" class="box" required>
        <span id="number-error"></span>
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
        var numberInput = document.getElementById('number');
        var numberError = document.getElementById('number-error');
        var sendBtn = document.getElementById('sendBtn');

        contactForm.addEventListener('submit', function (event) {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Your AJAX or form submission logic here

            // Check for validation errors
            if (numberInput.value.length === 12) {
                // Display success message
                successMessage.innerText = 'Message Sent!';
                successMessage.style.display = 'block';

                // Reset form fields after 5 seconds
                setTimeout(function () {
                    successMessage.style.display = 'none';
                    contactForm.reset();
                }, 900);
            } else {
                // Display phone number error
                numberError.innerText = 'Phone number must be exactly 12 digits';
            }
        });

        // Event listener for the number input
        numberInput.addEventListener('input', function () {
            var isValid = numberInput.value.length === 12 && /^\d+$/.test(numberInput.value);
            numberError.innerText = isValid ? '' : 'Phone number must be exactly 12 digits';
            sendBtn.disabled = !isValid;
        });
    });
</script>
</body>
</html>
