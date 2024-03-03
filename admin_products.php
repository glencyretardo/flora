<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

require_once 'database.php';
session_start();

// Assuming $conn is your database connection, ensure it is established before using it.

if(isset($_POST['add_product'])){
   $name = mysqli_real_escape_string($conn, $_POST['ProductName']);
   $price = mysqli_real_escape_string($conn, $_POST['Price']);
   $details = mysqli_real_escape_string($conn, $_POST['Description']);
   $image = $_FILES['image']['name'];
   $image_size = $_FILES['image']['size'];
   $image_tmp_name = $_FILES['image']['tmp_name'];
   $image_folder = __DIR__ . '/uploaded_img/' . $image;

   $select_product_name = mysqli_query($conn, "SELECT ProductName FROM `product` WHERE ProductName = '$name'") or die('query failed');

   if(mysqli_num_rows($select_product_name) > 0){
      $message[] = 'Product name already exists!';
   } else {
      $insert_product = mysqli_query($conn, "INSERT INTO `product`(ProductName, Description, Price, image) VALUES('$name', '$details', '$price', '$image')") or die('query failed');

      if($insert_product){
         if($image_size > 2000000){
            $message[] = 'Image size is too large!';
         } else {
            error_log("Image Folder: " . $image_folder);
            move_uploaded_file($image_tmp_name, $image_folder);
            $message[] = 'Product added successfully!';
         }
      }
   }
}

// The rest of your code remains unchanged.

if(isset($_GET['delete'])){
   $delete_id = $_GET['delete'];
   $select_delete_image = mysqli_query($conn, "SELECT image FROM `product` WHERE ProductID = '$delete_id'") or die('query failed');
   $fetch_delete_image = mysqli_fetch_assoc($select_delete_image);
   unlink('uploaded_img/'.$fetch_delete_image['image']);
   mysqli_query($conn, "DELETE FROM `cart` WHERE ProductID = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `product` WHERE ProductID = '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `wishlist` WHERE wishlistID= '$delete_id'") or die('query failed');
   mysqli_query($conn, "DELETE FROM `cart` WHERE cartID= '$delete_id'") or die('query failed');
   header('location:admin_products.php');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>products</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

   <!-- custom admin css file link  -->
   <link rel="stylesheet" href="admin_style.css">

</head>
<body>
   
<?php include 'admin_header.php'; ?>

<section class="add-products">
   <form action="" method="POST" enctype="multipart/form-data">
      <h3>add new product</h3>
      <input type="text" class="box" required placeholder="enter product name" name="name">
      <input type="number" min="0" class="box" required placeholder="enter product price" name="price">
      <textarea name="details" class="box" required placeholder="enter product details" cols="30" rows="10"></textarea>
      <input type="file" accept="image/jpg, image/jpeg, image/png" required class="box" name="image">
      <input type="submit" value="add product" name="add_product" class="btn">
   </form>
</section>

<section class="show-products">
   <div class="box-container">
      <?php
         $select_product = mysqli_query($conn, "SELECT * FROM `product`") or die('query failed');
         if(mysqli_num_rows($select_product) > 0){
            while($fetch_product = mysqli_fetch_assoc($select_product)){
      ?>
      <div class="box">
         <div class="price">₱<?php echo number_format($fetch_product['Price'], 2); ?> </div>

         <img class="image" src="uploaded_img/<?php echo $fetch_product['image']; ?>" alt="">

         <div class="name"><?php echo $fetch_product['ProductName']; ?></div>
         <div class="details"><?php echo $fetch_product['Description']; ?></div>
         <a href="admin_update_product.php?update=<?php echo $fetch_product['ProductID']; ?>" class="option-btn">update</a>
         <a href="admin_products.php?delete=<?php echo $fetch_product['ProductID']; ?>" class="delete-btn" onclick="return confirm('delete this product?');">delete</a>


      </div>
      <?php
         }
      }else{
         echo '<p class="empty">no products added yet!</p>';
      }
      ?>
   </div>
</section>
</body>
</html>