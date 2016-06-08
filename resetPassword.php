<?php

$email = $_REQUEST['email'];
$code = $_REQUEST['code'];
$password = $_REQUEST['password'];

include 'DBConfig.php';
mysqli_query($con, "update merchants set Password='$password',Status=1 where Email='$email' and ActivationCode='$code'");
//mysqli_close($con);

$result = mysqli_query($con, "SELECT * FROM merchants where Email='" . $email . "' and Password='" . $password . "' limit 1");
$row = mysqli_fetch_array($result);
$uid = $row['MerchantId'];

session_start();
$_SESSION['username'] = $email;
$_SESSION['userId'] = $uid;
$_SESSION['code'] = $code;
$_SESSION['email'] = $email;
$_SESSION['loggedIn'] = 1;

$result1 = mysqli_query($con, "select * from outlets where MechantId=" . $uid);
$count = mysqli_num_rows($result1);
mysqli_close($con);
//if ($count == 0) {
//    header('Location: outlets0.php');
//} else {
//    header('Location: outlets.php');
//}

echo $count;

//header('Location: outlets.php');
?>
