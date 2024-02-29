<?php


session_start();


?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>dashboard</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="dashboard">

   <h1 class="title">dashboard</h1>

   <div class="box-container">

      <div class="box">
         
         <!-- gawas diri tung mga pending money na orders na wa pa nabayaran -->
            
         <p>total pendings</p>
      </div>

      <div class="box">
        <!-- gawas diri kita -->
         <p>completed payments</p>
      </div>

      <div class="box">
      <!-- gawas diri pila nay na placed order -->
         <p>orders placed</p>
      </div>

      <div class="box">
        <!-- gawas diri dapat pila ka products naa add -->
         <p>products added</p>
      </div>

      <div class="box">
         <!-- gawas pila ka users naa -->
         <p>users</p>
      </div>


      <div class="box">
         <!-- gawas diri pila ka messages nadawat gikan didto sa contact -->
         <p>messages</p>
      </div>

   </div>

</section>


</body>
</html>