<?php
include('db.php');

if (isset($_POST['email'])) {
    $email = $_POST['email'];
    $user_id = $_POST['user_id'] ?? 0;

    $query = "SELECT id FROM student 
              WHERE email = '$email' 
              AND id != $user_id";

    $result = mysqli_query($conn, $query);

    echo (mysqli_num_rows($result) > 0) ? "exists" : "available";
}
