<?php

include '../web-in/components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $id = unique_id();
   $name = $_POST['name'];
   $name = filter_var($name, FILTER_SANITIZE_STRING);
   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);
   $cpass = sha1($_POST['cpass']);
   $cpass = filter_var($cpass, FILTER_SANITIZE_STRING);

   $rename = '../web-in/images/pic-2';
   $image_folder = 'uploaded_files/'.$rename;

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ?");
   $select_user->execute([$email]);
   
   if($select_user->rowCount() > 0){
    $error_message = 'email already taken!';
   }else{
      if($pass != $cpass){
        $error_message = 'confirm passowrd not matched!';
      }else{
         // Thêm giá trị mặc định 'unpaid' vào cột state
         $insert_user = $conn->prepare("INSERT INTO `users`(id, name, email, password, image, state) VALUES(?,?,?,?,?,?)");
         $insert_user->execute([$id, $name, $email, $cpass, $rename, 'unpaid']);
         move_uploaded_file($image_tmp_name, $image_folder);
         
         $verify_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
         $verify_user->execute([$email, $pass]);
         $row = $verify_user->fetch(PDO::FETCH_ASSOC);
         
         if($verify_user->rowCount() > 0){
            setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
            header('location:price.html');
         }
      }
   }

}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <!-- font awesome cdn link  -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">

    <!-- custom css file link  -->
    <link rel="stylesheet" href="css/style-out.css">

</head>
<body>

<div class="container">

    <header>
    
        <a href="#" class="logo">Quach<span>Edu.</span></a>
    
        <div id="menu" class="fas fa-bars"></div>
    
        <nav class="navbar">
            <a href="home.html">Trang chủ</a>
            <a href="course.php">Khóa học</a>
            <a href="teacher.php">Giáo viên</a>
            <a href="review.html">Đánh giá</a>
            <a href="contact.html">Liên hệ</a>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
        </nav>
    
    </header>


<h1 class="heading"> Đăng Ký</h1>   

<section class="login-register">

    <div class="image">
        <img src="images/register.png" alt="Login / Register Image">
    </div>

    <div class="form-container">
        <!-- register Form -->
        <form action="" method="POST" id="register-form" autocomplete="off">
            <h2>Register</h2>
            <input type="text" name="name" placeholder="Enter your name" required>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="pass" placeholder="Create a password" 
            autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly'); this.type='password';">
            <input type="password" name="cpass" placeholder="Confirm your password" required>
            <input type="submit" name="submit" class="btn" value="Register"> 
            <p>Already have an account? <a href="login.php">Login Here</a></p>
            <?php if (!empty($error_message)) { ?>
                <p class="error-message"><?= $error_message; ?></p>
            <?php } ?> 
        </form>
    </div>
</section>

<!-- footer section  -->

<section class="footer">
    <hr class="section-footer">
    <div class="box-container">

        <div class="box">
            <h3>về chúng tôi</h3>
            <p>trung tâm giáo dục QuachEdu.</p>
        </div>

        <div class="box">
            <h3>liên kết</h3>
            <a href="home.html">Trang chủ</a>
            <a href="course.php">Khóa học</a>
            <a href="teacher.php">Giáo viên</a>
            <a href="review.html">Đánh giá</a>
            <a href="contact.html">Liên hệ</a>
            <a href="login.php">Đăng nhập</a>
            <a href="register.php">Đăng ký</a>
        </div>

        <div class="box">
            <h3>theo dõi</h3>
            <a href="https://www.facebook.com/profile.php?id=61575079702285">facebook</a>
            <a href="#">twitter</a>
            <a href="#">instagram</a>
            <a href="#">linkedin</a>
        </div>

        <div class="box">
            <h3>liên hệ</h3>
           <p> <i class="sđt"></i> 098-686-4461 </p>
           <p> <i class="email"></i> quachEdu@gmail.com </p>
           <p> <i class="địa chỉ"></i> Hanoi, Vietnam </p>
        </div>

    </div>

    <div class="credit"> created by <span> team 2 </span> | all rights reserved </div>

</section>
<style>
    .section-footer{
        width: 100%;
        margin: 2rem auto;
        border: .1rem solid rgba(0,0,0,.1);
    }
</style>

<style>
    .error-message {
        color: red; /* Màu chữ đỏ để nổi bật */
        font-size: 1rem; /* Kích thước chữ vừa phải */
        margin: 0.5rem 0; /* Khoảng cách trên và dưới */
        text-align: left; /* Căn giữa thông báo */
    }
</style>
</div>















<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>