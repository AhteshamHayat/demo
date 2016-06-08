<?php

$reply = "";
//$uid = $_REQUEST["uid"];
//$sDate = strtotime($_REQUEST["sDate"]);
//$eDate = strtotime($_REQUEST["eDate"]);
//
//include 'DBConfig.php';
//
//$tbl_name = "transactions";
//
//$sql = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$uid where TransationTime between $sDate and $eDate";
//$result = mysqli_query($con, $sql);
//
//while ($row = mysqli_fetch_array($result)) {
//    $query1 = "SELECT * from coupons where CouponId=" . $row['CouponId'];
//    $result1 = mysqli_query($con, $query1);
//    $row1 = mysqli_fetch_array($result1);
//
//    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
//    $result2 = mysqli_query($con, $query2);
//    $row2 = mysqli_fetch_array($result2);
//
//    $reply .= "<tr>";
//    $reply .= "<td>" . $row['TransactionId'] . "</td>";
//    $reply .= "<td>" . $row2['OutletName'] . "</td>";
//    $reply .= "<td>" . $row1['DealStatement'] . "</td>";
//    $reply .= "<td>" . date("F j, Y, g:i a", strtotime($row['TransationTime'])) . "</td>";
//    $reply .= "</tr>";
//}


for ($i=0;$i<5;$i++){
        $reply .= "<tr>";
    $reply .= "<td>" . $i . "</td>";
    $reply .= "<td>" . "DummyName".$i . "</td>";
    $reply .= "<td>" .  "DummyStatement".$i. "</td>";
    $reply .= "<td>" . "DummyDate".$i . "</td>";
    $reply .= "</tr>";
}
echo $reply;
?>