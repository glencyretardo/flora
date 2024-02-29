<?php

session_start();

require_once  'database.php';

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = $_POST['pass'];

   

    // Prepare and execute the query to fetch user data based on email
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 1) {
        // User found, fetch user data
        $row = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $row['password_hash'])) {
            // Password matches, set session variables
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_id'] = uniqid(); // You can generate a unique user id here
            header('location: home.php'); // Redirect to home page after successful login
            exit();
        } else {
            $message[] = 'Incorrect email or password!';
        }
    } else {
        $message[] = 'Incorrect email or password!';
    }

    // Close database connection
    $stmt->close();
    $conn->close();
}

?>

<!-- Your HTML form -->


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            <h3>Login now</h3>
            <input type="email" name="email" class="box" placeholder="Enter your email" required
                value="<?php echo isset($_GET['email']) ? htmlspecialchars($_GET['email']) : ''; ?>">
            <input type="password" name="pass" class="box" placeholder="Enter your password" required>
            <input type="submit" class="btn" name="submit" value=" Admin Login">
            <p> add new admin? <a href="adminregister.php">Register now</a></p>
        </form>

    </section>

</body>

</html>
