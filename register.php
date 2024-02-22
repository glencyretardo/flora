<?php

session_start();

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = md5($_POST['pass']);
    $confirmPassword = md5($_POST['cpass']);

    // Check if user with the same email already exists
    if (isset($_SESSION['users'][$email])) {
        $message[] = 'User already exists!';
    } else {
        // Check if passwords match
        if ($password != $confirmPassword) {
            $message[] = 'Confirm password not matched!';
        } else {
            // Add user to the session
            $_SESSION['users'][$email] = [
                'name' => $name,
                'password' => $password,
            ];
            $message[] = 'Registered successfully!';
            // Redirect to login page with pre-filled email
            header('location: login.php?email=' . urlencode($email));
            exit();
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
    <title>Register</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="style.css">

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
            <input type="email" name="email" class="box" placeholder="Enter your email" required
                value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            <input type="password" name="pass" class="box" placeholder="Enter your password" required>
            <input type="password" name="cpass" class="box" placeholder="Confirm your password" required>
            <input type="submit" class="btn" name="submit" value="Register now">
        </form>

        <p>Already have an account? <a href="login.php">Login now</a></p>

    </section>

</body>

</html>
