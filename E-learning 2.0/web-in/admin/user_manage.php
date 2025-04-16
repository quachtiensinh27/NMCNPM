<?php

include '../components/connect.php';

if (isset($_COOKIE['tutor_id'])) {
    $tutor_id = $_COOKIE['tutor_id'];
} else {
    $tutor_id = '';
    header('location:login.php');
    exit;
}

// Xử lý tìm kiếm
$search_email = '';
if (isset($_POST['search'])) {
    $search_email = $_POST['search_email'];
    $search_email = filter_var($search_email, FILTER_SANITIZE_STRING);

    // Truy vấn tìm kiếm user theo email
    $select_users = $conn->prepare("SELECT * FROM `users` WHERE `email` = ?");
    $select_users->execute([$search_email]);
} else {
    // Lấy danh sách user theo bộ lọc
    $filter = '';
    if (isset($_GET['filter'])) {
        $filter = $_GET['filter'];
    }

    if ($filter === 'paid') {
        $select_users = $conn->prepare("SELECT * FROM `users` WHERE `state` = 'paid'");
    } elseif ($filter === 'unpaid') {
        $select_users = $conn->prepare("SELECT * FROM `users` WHERE `state` = 'unpaid'");
    } else {
        $select_users = $conn->prepare("SELECT * FROM `users`");
    }

    $select_users->execute();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Playlists</title>

   <!-- font awesome cdn link  -->
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
   <link href="https://fonts.googleapis.com/css2?family=Roboto&display=swap" rel="stylesheet">
   <!-- custom css file link  -->
   <link rel="stylesheet" href="../css/admin_style.css">

</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="user-management">

    <h1 class="heading">Student Management</h1>

    <!-- Thanh tìm kiếm -->
    <form action="" method="post" class="search-form">
        <input type="text" name="search_email" placeholder="Enter user email" value="<?= $search_email; ?>" required>
        <button type="submit" name="search" class="btn">Search</button>
    </form>

    <!-- Bộ lọc -->
    <div class="filter-buttons">
        <a href="user_manage.php" class="btn">All Users</a>
        <a href="user_manage.php?filter=paid" class="btn">Paid Users</a>
        <a href="user_manage.php?filter=unpaid" class="btn">Unpaid Users</a>
    </div>

    <!-- Bảng hiển thị user -->
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($select_users->rowCount() > 0) {
                    while ($fetch_user = $select_users->fetch(PDO::FETCH_ASSOC)) {
                        ?>
                        <tr>
                            <td><?= $fetch_user['name']; ?></td>
                            <td><?= $fetch_user['email']; ?></td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="<?= $fetch_user['id']; ?>">
                                    <input type="checkbox" <?= $fetch_user['state'] === 'paid' ? 'checked' : ''; ?> onclick="return confirm('Change status to paid?');" <?= $fetch_user['state'] === 'paid' ? 'disabled' : ''; ?>>
                                    <?php if ($fetch_user['state'] !== 'paid') { ?>
                                        <button type="submit" name="update_status" class="btn">Update</button>
                                    <?php } ?>
                                </form>
                            </td>
                            <td>
                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="<?= $fetch_user['id']; ?>">
                                    <button type="submit" name="delete_user" class="delete-btn" onclick="return confirm('Are you sure you want to delete this user?');">Delete</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    echo '<tr><td colspan="4" class="empty">No users found!</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

</section>

<?php include '../components/footer.php'; ?>

<script src="../js/admin_script.js"></script>

</body>
</html>