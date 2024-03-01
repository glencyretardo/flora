<?php
session_start();
require_once 'database.php';

$success_message = ''; // Variable to store success message

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $number = isset($_POST['number']) ? $_POST['number'] : '';
    $message = isset($_POST['message']) ? $_POST['message'] : '';

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
        echo "Error: " . mysqli_error($conn);
    }

    // Close the statement
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>contact</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">
   <style>
      .success-message {
          display: none;
          color: green; /* You can customize the color */
      }
   </style>
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
        <input type="email" name="email" placeholder="enter your email" class="box" required>
        <input type="tel" name="number" placeholder="Contact Number"  class="box" required>
        <textarea name="message" class="box" placeholder="enter your message" required cols="30" rows="10"></textarea>
        <input type="submit" value="send message" name="send" class="btn">
        <div id="success-message" class="success-message"></div>
    </form>
</section>


<?php include 'footer.php'; ?>

<script src="js/script.js"></script>
<script>
    // Add this JavaScript code to handle the success message and form reset
    document.addEventListener('DOMContentLoaded', function () {
        var contactForm = document.getElementById('contactForm');
        var successMessage = document.getElementById('success-message');

        contactForm.addEventListener('submit', function (event) {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Your AJAX or form submission logic here

            // Display success message
            successMessage.innerText = 'Data inserted successfully!';
            successMessage.style.display = 'block';

            // Reset form fields after 5 seconds
            setTimeout(function () {
                successMessage.style.display = 'none';
                contactForm.reset();
            }, 900);
        });
    });
</script>
</body>
</html>


