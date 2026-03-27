<?php
include('db.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone_no = $_POST['phone_no'];
    $address = $_POST['address'];
    $state_id = $_POST['state'];
    $district_id = $_POST['district'];

    $sql = "INSERT INTO student (name, email, phone_no, address, state_id, district_id) VALUES
     ('$name','$email','$phone_no','$address','$state_id','$district_id')";

    if (mysqli_query($conn, $sql)) {
        echo "data inserted succesfully";
    } else {
        echo "insertion failed";
    }
}
mysqli_close($conn);
