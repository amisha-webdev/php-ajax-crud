<?php
include('db.php');

$sql = "SELECT * FROM state";
$query = mysqli_query($conn, $sql) or die('query unsuccessful');
$str = "";

while ($row = mysqli_fetch_assoc($query)) {
  $str .= "<option value='{$row['id']}'>{$row['state_name']}</option>";
}
echo $str;
