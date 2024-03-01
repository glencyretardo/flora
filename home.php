<?php


session_start();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="style.css">
</head>

<body>

    <?php include 'header.php'; ?>

    <section class="home">

        <div class="content">
            <h3>new collections</h3>
            <p>Unleash the magic of nature with flora. 
                From minimalist elegance to bursts of vibrant color. </p>
            <a href="about.php" class="btn">discover more</a>
        </div>

    </section>

    <section class="products">

        <h1 class="title">best sellers</h1>

        <div class="box-container">

           
                    <form action="" method="POST" class="box">
            
                        <input type="submit" value="add to wishlist" name="add_to_wishlist" class="option-btn">
                        <input type="submit" value="add to cart" name="add_to_cart" class="btn">
                    </form>
           

        </div>

        <div class="more-btn">
            <a href="shop.php" class="option-btn">more</a>
        </div>

    </section>

    <section class="home-contact">

        <div class="content">
            <h3>have any questions?</h3>
            <a href="contact.php" class="btn">contact us</a>
        </div>

    </section>

    <?php include 'footer.php'; ?>


</body>

</html>
