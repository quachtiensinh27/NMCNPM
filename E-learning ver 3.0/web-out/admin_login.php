<?php

include '../web-in/components/connect.php';

if(isset($_POST['submit'])){

   $email = $_POST['email'];
   $email = filter_var($email, FILTER_SANITIZE_STRING);
   $pass = $_POST['pass'];
   $pass = filter_var($pass, FILTER_SANITIZE_STRING);

   $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE email = ? AND password = ? LIMIT 1");
   $select_tutor->execute([$email, $pass]);
   $row = $select_tutor->fetch(PDO::FETCH_ASSOC);
   
   if($select_tutor->rowCount() > 0){
     setcookie('tutor_id', $row['id'], time() + 60*60*24*30, '/');
     header('location:../web-in/admin/dashboard.php');
   }else{
    $error_message = 'Sai tài khoản hoặc mật khẩu!';
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


<h1 class="heading"> Welcom Admin</h1>   

<section class="login-register">

    <div class="form-container">
        <!-- Login Form -->
        <form action="" method="POST" id="login-form" autocomplete="off">
            <h1>Admin đăng nhập </h1>
            <input type="email" name="email" placeholder="Enter your email"
            autocomplete="off" readonly onfocus="this.removeAttribute('readonly');">
            <input type="password" name="pass" placeholder="Enter your password"
            autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly'); this.type='password';">    
            <!-- Hiển thị thông báo lỗi -->
            <input type="submit" name="submit" class="btn" value="Login">
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
<script>
   window.onload = function() {
      document.getElementById("email").value = "";
      document.getElementById("pass").value = "";
   };
</script>
</body>
</html>