<?php

include 'components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $name = $_POST['name']; 
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email']; 
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $msg = $_POST['msg']; 
   $msg = filter_var($msg, FILTER_SANITIZE_STRING);

   $select_contact = $conn->prepare("SELECT * FROM `contact` WHERE name = ? AND email = ? AND message = ?");
   $select_contact->execute([$name, $email, $msg]);

   if($select_contact->rowCount() > 0){
      $message[] = 'Phản hồi đã được gửi!';
   }else{
      // Thêm dữ liệu mới với ngày hiện tại
      $today = date('Y-m-d');
      $insert_message = $conn->prepare("INSERT INTO `contact` (name, email, message, date) VALUES (?, ?, ?, ?)");
      $insert_message->execute([$name, $email, $msg, $today]);
      $message[] = 'Gửi phản hồi thành công!';
      
      // Xóa dữ liệu cũ hơn 100 ngày
      $delete_old = $conn->prepare("DELETE FROM contact WHERE date < CURDATE() - INTERVAL 100 DAY");
      $delete_old->execute();
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>QuachEdu</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   <!-- custom css file link  -->
   <link rel="stylesheet" href="css/style.css">

</head>
<body>

<?php include 'components/user_header.php'; ?>

<!-- contact section starts  -->

<section class="contact">

   <div class="row">

      <div class="image">
         <img src="images/contact-img.svg" alt="">
      </div>

      <form action="" method="post">
         <h3></h3>
         <input type="text" placeholder="Nhập tên" required maxlength="100" name="name" class="box">
         <input type="email" placeholder="Nhập email" required maxlength="100" name="email" class="box">
         <textarea name="msg" class="box" placeholder="Nhập nội dung" required cols="30" rows="10" maxlength="1000"></textarea>
         <input type="submit" value="Gửi" class="inline-btn" name="submit">
      </form>

   </div>

   <div class="box-container">

      <div class="box">
         <i class="fas fa-phone"></i>
         <h3>Số điện thoại</h3>
         <a href="tel:0986864461">098-686-4461</a>
      </div>

      <div class="box">
         <i class="fas fa-envelope"></i>
         <h3>Địa chỉ email</h3>
         <a href="mailto:quachedu@gmail.com">quachedu@gmail.come</a>
      </div>

      <div class="box">
         <i class="fas fa-map-marker-alt"></i>
         <h3>Địa chỉ</h3>
         <a href="#">144 Xuân Thủy, Cầu Giấy, Hà Nội</a>
      </div>


   </div>

</section>

<!-- contact section ends -->




<style>
      .inline-btn {
      background-color:rgb(142, 107, 255);
   }
</style>






<?php include 'components/footer.php'; ?>  

<!-- custom js file link  -->
<script src="js/script.js"></script>
   
</body>
</html>