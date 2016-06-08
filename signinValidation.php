<?php

include 'DBConfig.php';
$uname = $_POST["inputEmail"];
$pword = $_POST["inputPassword"];

$result = mysqli_query($con, "SELECT * FROM merchants where Email='" . $uname . "' and Password='" . $pword . "' and Status=1 limit 1");

if (null == mysqli_fetch_array($result)) {
    header('Location: signup.php?v=1');
} else {

    $result = mysqli_query($con, "SELECT * FROM merchants where Email='" . $uname . "' and Password='" . $pword . "' and Status=1 limit 1");
    while ($row = mysqli_fetch_array($result)) {
        $uid = $row['MerchantId'];
        $code = $row['ActivationCode'];
        $email = $row['Email'];
    }
    session_start();
    $_SESSION['username'] = $uname;
    $_SESSION['userId'] = $uid;
    $_SESSION['code'] = $code;
    $_SESSION['email'] = $email;
    $_SESSION['loggedIn'] = 1;
    header('Location: outlets.php');

    $result1 = mysqli_query($con, "select * from outlets where MechantId=".$uid);
    $count = mysqli_num_rows($result1);
    if($count == 0){
        header('Location: outlets0.php');
    }else{
        header('Location: outlets.php');
    }
}
mysqli_close($con);
?>