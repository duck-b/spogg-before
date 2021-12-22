<?php
$name = $_POST['name'];
$phone = $_POST['phone'];

include "dbconn.php";
$result = mysqli_query($conn,"SELECT * FROM user WHERE name='$name' AND phone = '$phone'");
$row = mysqli_fetch_array($result);
mysqli_close($conn);

echo substr_replace($row['email'],"***",2,4);
?>