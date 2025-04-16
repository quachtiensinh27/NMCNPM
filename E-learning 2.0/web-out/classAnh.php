<?php
include '../web-in/components/connect.php';

$select_playlists = $conn->prepare("SELECT * FROM `playlist` WHERE `status` = 'active' ORDER BY date DESC");
$select_playlists->execute();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>home</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
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

<section class="playlist-container">
   <h1 class="heading">All Playlists</h1>

   <div class="box-container">
   <?php
   if ($select_playlists->rowCount() > 0) {
      while ($fetch_playlist = $select_playlists->fetch(PDO::FETCH_ASSOC)) {
         $course_id = $fetch_playlist['id'];

         // Truy vấn thông tin giáo viên
         $select_tutor = $conn->prepare("SELECT * FROM `tutors` WHERE id = ?");
         $select_tutor->execute([$fetch_playlist['tutor_id']]);
         $fetch_tutor = $select_tutor->fetch(PDO::FETCH_ASSOC);
   ?>
      <div class="playlist-box">
         <div class="tutor">
            <img src="../web-in/uploaded_files/<?= $fetch_tutor['image']; ?>" alt="Tutor Image">
            <div>
               <h3><?= $fetch_tutor['name']; ?></h3>
               <span><?= $fetch_playlist['date']; ?></span>
            </div>
         </div>
         <img src="../web-in/uploaded_files/<?= $fetch_playlist['thumb']; ?>" class="thumb" alt="Playlist Thumbnail">
         <h3 class="title"><?= $fetch_playlist['title']; ?></h3>
         <p><?= $fetch_playlist['description']; ?></p>
         <a href="playlist.php?get_id=<?= $course_id; ?>" class="inline-btn">Xem playlist</a>
      </div>
   <?php
      }
   } else {
      echo '<p class="empty">Không tìm thấy playlist nào!</p>';
   }
   ?>
   </div>
</section>

<section class="footer">
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
    <div class="credit"> created by <span>team 2</span> | all rights reserved </div>
</section>

<script src="js/script.js"></script>
</div>

</body>
</html>
