<?php
$index = $_REQUEST["index"];
//$con = mysqli_connect("localhost", "hums", "hums", "citydeals");
//if (mysqli_connect_errno()) {
//    echo "Failed to connect to MySQL: " . mysqli_connect_error();
//}

include 'DBConfig.php';
$Outletquery = "select * from outlets where OutletId=$index";
$Outletresult = mysqli_query($con, $Outletquery);
$Outletrow = mysqli_fetch_array($Outletresult);
//OutletId, OutletThumbnail, OutletImage, OutletAddress, OutletName, OutletCity, OutletCountry, TradingStartTime, TradingEndTime, TradingDays, OutletContactNo, MechantId, OutletLatitude, OutletLongitude, OutletRatingSum, OutletRatingCount, Services, TypeId
$reply = $Outletrow['OutletId'] . "^" . $Outletrow['OutletName'] . "^" . $Outletrow['OutletCity'] . "^" . $Outletrow['OutletCountry'] . "^" ;
$reply .= $Outletrow['TradingStartTime'] . "^" . $Outletrow['TradingEndTime'] . "^" . $Outletrow['TradingDays'] . "^" . $Outletrow['OutletContactNo'] . "^" ;
$reply .= $Outletrow['OutletLatitude'] . "^" . $Outletrow['OutletLongitude'] . "^" . $Outletrow['Services'] ;

echo $reply;
mysqli_close($con);
//echo $Outletrow["OutletName"];
?>
