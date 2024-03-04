<?php

require_once  'database.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['pass'], PASSWORD_BCRYPT);
    $confirmPassword = password_hash($_POST['cpass'], PASSWORD_BCRYPT);

    // Check if user with the same email already exists in the database
    $checkUserQuery = "SELECT * FROM adminregistration WHERE email = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $message[] = 'User already exists!';
    } else {
        // Check if passwords match
        if (!password_verify($_POST['pass'], $confirmPassword)) {
            $message[] = 'Confirm password not matched!';
        } else {
            // Insert user into the database
            $insertUserQuery = "INSERT INTO adminregistration (username, email, password_hash) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($insertUserQuery);
            $stmt->bind_param('sss',$name, $email, $password);
            $stmt->execute();

            $message[] = 'Registered successfully!';
            // Redirect to login page with pre-filled email
            header('location: admin.php?email=' . urlencode($email));
            exit();
        }
    }

    // Close the prepared statement
    $stmt->close();
}

// Close the database connection
$conn->close();
?>

<!-- ... Rest of your HTML ... -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

    <script>
        function validateEmail() {
            var email = document.getElementById("email").value;
            var emailError = document.getElementById("emailError");

            var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

            if (!email.match(emailPattern)) {
                emailError.innerHTML = 'Invalid email format';
            } else {
                emailError.innerHTML = '';
            }
        }

        function validatePassword() {
            var password = document.getElementById("pass").value;
            var passwordError = document.getElementById("passwordError");

            var passwordPattern = /^(?=.*[0-9])(?=.*[a-zA-Z])(?=.*[!@#$%^&*()_+[\]{};':"\\|,.<>\/?]).{6,}$/;

            if (!password.match(passwordPattern)) {
                passwordError.innerHTML = 'Password must be at least 6 characters and include at least one letter, one numeric value, and one special character';
            } else {
                passwordError.innerHTML = '';
            }
        }
    </script>

</head>

<body>

    <?php
    if (isset($message)) {
        foreach ($message as $msg) {
            echo '
            <div class="message">
                <span>' . $msg . '</span>
                <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
            </div>
            ';
        }
    }
    ?>

    <section class="form-container">

    <form action="" method="post">
            <h3>Register now</h3>
            <input type="text" name="name" class="box" placeholder="Enter your username" required>
            <input type="email" name="email" id="email" class="box" placeholder="Enter your email" required
                oninput="validateEmail()"
                value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            <div id="emailError"></div>
            <input type="password" name="pass" id="pass" class="box" placeholder="Enter your password" required
                oninput="validatePassword()">
            <div id="passwordError"></div>
            <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
            <input type="submit" class="btn" name="submit" value="Register now">
            <p>Already have an account? <a href="login.php">Login now</a></p>
            <p><a href="home.php"> Proceed to Flora Homepage  </a></p>
        </form>

        

    </section>

</body>

</html>
