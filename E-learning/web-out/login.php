<?php

include '../web-in/components/connect.php';

if(isset($_COOKIE['user_id'])){
   $user_id = $_COOKIE['user_id'];
}else{
   $user_id = '';
}

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = sha1($_POST['pass']);
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_user = $conn->prepare("SELECT * FROM `users` WHERE email = ? AND password = ? LIMIT 1");
   $select_user->execute([$email, $pass]);
   $row = $select_user->fetch(PDO::FETCH_ASSOC);
   
   if($select_user->rowCount() > 0){
     setcookie('user_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:../web-in/home.php');
   }else{
      $message[] = 'incorrect email or password!';
   }

}

?>

<?php
if (isset($message)) {
    foreach ($message as $msg) {
        echo '<div class="message">' . $msg . '</div>';
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
            <a href="course.html">Khóa học</a>
            <a href="teacher.html">Giáo viên</a>
            <a href="review.html">Đánh giá</a>
            <a href="contact.html">Liên hệ</a>
            <a href="login.php">Đăng nhập</a>
        </nav>
    
    </header>


<h1 class="heading"> Đăng nhập</h1>   

<section class="login-register">

    <div class="image">
        <img src="images/login.png" alt="Login / Register Image">
    </div>

    <div class="form-container">
        <!-- Login Form -->
        <form action="" method="POST" id="login-form">
            <h1>Đăng nhập </h1>
            <input type="email" name="email" placeholder="Enter your email" required>
            <input type="password" name="pass" placeholder="Enter your password" required>     
            <input type="submit" name="submit" class="btn" value="Login">
            <p>Don't have an account? <a href="register.php">Register Here</a></p>
            <p>I'm an admin <a href="admin_login.php">admin login here</a></p> 
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
            <a href="course.html">Khóa học</a>
            <a href="teacher.html">Giáo viên</a>
            <a href="review.html">Đánh giá</a>
            <a href="contact.html">Liên hệ</a>
            <a href="login.php">Đăng nhập</a>
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
</div>















<!-- custom js file link -->
<script src="js/script.js"></script>

</body>
</html>