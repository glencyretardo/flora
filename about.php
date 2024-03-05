<?php


session_start();

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>about</title>
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
   <link rel="stylesheet" href="style.css">

</head>
<body>
   
<?php include 'header.php'; ?>

<section class="heading">
    <h3>about us</h3>
    <a id="backButton" href="home.php"><i class="fa fa-arrow-left" aria-hidden="true"></i></a>

    
</section>

<section class="about">

    <div class="flex">

        <div class="image">
            <img src="images/img1.jpg" alt="">
        </div>

        <div class="content">
            <h3>why choose us?</h3>
            <p>We offer a vast and diverse collection of flower arrangements that captivate the senses and elevate every occasion. As you explore the pages of our digital flowers, you'll quickly discover why choosing us is an remarkable experience in the world of botanical beauty.</p>
            <a href="shop.php" class="btn">shop now</a>
        </div>

    </div>

    <div class="flex">

        <div class="content">
            <h3>what we provide?</h3>
            <p>Flora provides a quality and affordable flowers for your loved ones. We will craft your memories with every bouquet.</p>
            <a href="contact.php" class="btn">contact us</a>
        </div>

        <div class="image">
            <img src="images/yo.png" alt="">
        </div>

    </div>

    <div class="flex">

        <div class="image">
            <img src="images/img3.jpg" alt="">
        </div>

        <div class="content">
            <h3>who we are?</h3>
            <p>Flora means 'flowers' in latin and flora was the Roman goddess of spring & flowering plants. We are from davao city that offers a blooming flower bouquet in every occasion.</p>
            <a href="#reviews" class="btn">clients reviews</a>
        </div>

    </div>

</section>

<section class="reviews" id="reviews">

    <h1 class="title">client's reviews</h1>

    <div class="box-container">

        <div class="box">
            <img src="images/img_jyp.jpg" alt="">
            <p>I love the flowers! Naguxtuhan ng asawa q. Wala aq masabi... kundi ang ganda at mabango...</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

        <div class="box">
            <img src="images/img_hyunjin.jpg" alt="">
            <p>AAAACCCK. Ang gondo!! I like the way the flowers shine. My heart melts when my jowa gave it to me xoxo.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

        <div class="box">
            <img src="images/img_jungwon.jpg" alt="">
            <p>Nawala galit ni misis nong binigyan ku cya ng bulaklak. Palalayasin na xana aku sa bahay namen.. buti nalang sakto dumating yong bulaklak kaya d natuloy paglayas nya sa aken.. haha. ayos na ayos. 10/10 kayu sa aken.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

        <div class="box">
            <img src="images/img_momo.jpg" alt="">
            <p>Nagulat ako kasi akala ko may patay sa amin kasi may nagpa-deliver ng bulaklak yon pala surprise delivery sa akin ng asawa ko kasi anniversary pala namin. Bakit ba kasi pampatay binili niyang bulaklak. Mukha ba akong patay???</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

        <div class="box">
            <img src="images/img_jk.jpg" alt="">
            <p>Dito ulit ako o-order kapag may ocassion. Hindi niyo man lang sa akin sinabi na mapaparami halik ng girlfriend ko kapag bibili ako sainyo. Bulaklak niyo lang pala ang solusyon para may extrang halik ako sa kanya ehehehe... salamat mga lodz..</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star-half-alt"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

        <div class="box">
            <img src="images/img_jihyo.jpg" alt="">
            <p>HUWAG KAYONG BIBILI SA SHOP NILA! BAKIT? KASI ANG GANDA! MABANGO PA! FEEL KO PINABANGUHAN NILA E2. PERO EME LANG. WORTH IT PERA NIYO MGA BEHHH.</p>
            <div class="stars">
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
                <i class="fas fa-star"></i>
            </div>
            <!-- <h3>n/a</h3> -->
        </div>

    </div>

</section>

<script>
    document.getElementById("backButton").addEventListener("click", function(event) {
        event.preventDefault(); // Prevent default behavior of anchor element
        window.location.href = this.href; // Navigate to the specified href
    });
</script>

<?php include 'footer.php'; ?>


</body>
</html>