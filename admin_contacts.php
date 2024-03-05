<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'database.php';
session_start();

if (!isset($_SESSION['admin_name'])) {
   header("Location: admin.php");
   exit();
}



if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   mysqli_query($conn, "DELETE FROM `message` WHERE id = '$delete_id'") or die('query failed');
   header('location:admin_contacts.php');
}

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

<section class="messages">

   <h1 class="title">messages</h1>

   <div class="box-container">

      <?php
       $select_message = mysqli_query($conn, "SELECT * FROM `message`") or die('query failed');
       if(mysqli_num_rows($select_message) > 0){
          while($fetch_message = mysqli_fetch_assoc($select_message)){
      ?>
      <div class="box">
         <p>message id : <span><?php echo $fetch_message['MessageID']; ?></span> </p>
         <p>name : <span><?php echo $fetch_message['Name']; ?></span> </p>
         <p>number : <span><?php echo $fetch_message['ContactNumber']; ?></span> </p>
         <p>email : <span><?php echo $fetch_message['Email']; ?></span> </p>
         <p>message : <span><?php echo $fetch_message['MessageContent']; ?></span> </p>
         <p>timestamp : <span><?php echo $fetch_message['Timestamp']; ?></span> </p>
         <a href="admin_contacts.php?delete=<?php echo $fetch_message['MessageID']; ?>" onclick="return confirm('delete this message?');" class="delete-btn">delete</a>
      </div>
      <?php
         }
      }else{
         echo '<p class="empty">you have no messages!</p>';
      }
      ?>
   </div>

</section>













<script src="js/admin_script.js"></script>

</body>
</html>