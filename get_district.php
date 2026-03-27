<?php
include('db.php');

if (isset($_GET['state_id'])) {
  $state_id =  $_GET['state_id'];

  $sql = "SELECT * FROM district WHERE state_id ='$state_id'";

  $query = mysqli_query($conn, $sql) or die("query unsuccessful");
  $str = "";

  while ($row = mysqli_fetch_assoc($query)) {
    $str .= "<option value='{$row['id']}'>{$row['district_name']}</option>";
  }
  echo $str;
}
