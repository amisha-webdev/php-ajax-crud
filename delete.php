<?php
include('db.php');

if (isset($_POST['id'])) {
    $id = $_POST['id'];
    $sql = "DELETE FROM student WHERE id = '$id'";
    $query = mysqli_query($conn, $sql);
    if ($query) {
        echo "Record deleted successfully";
    } else {
        echo "failed to delete" . mysqli_error($conn);
    }
} else {
    echo "no id provided";
}
