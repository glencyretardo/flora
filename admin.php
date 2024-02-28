<?php

session_start();

if (isset($_POST['submit'])) {
    $email = $_POST['email'];
    $password = md5($_POST['pass']);


    if (isset($_SESSION['users'][$email]) && $_SESSION['users'][$email]['password'] === $password) {
        $user = $_SESSION['users'][$email];

        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_id'] = uniqid(); 
        header('location: home.php');
    } else {
        $message[] = 'Incorrect email or password!';
    }
}

?>

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
