<?php
include 'DBConfig.php';
$reply = "";
$outletId = $_REQUEST['outletId'];
$query = "SELECT * FROM coupons c where OutletId=$outletId and IsDeleted=0;";
$result = mysqli_query($con, $query);
while($row = mysqli_fetch_array($result)){
    $reply .= $row['CouponId'] . "^" . $row['DealStatement'] . ";";
}

echo $reply;
?>
