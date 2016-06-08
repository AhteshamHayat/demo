<?php

//$uid = $_REQUEST["uid"];
//$sDate = strtotime($_REQUEST["sDate"]);
//$eDate = strtotime($_REQUEST["eDate"]);

$uid = 9;
$sDate = '2013-09-18 14:51:21';
$eDate = '2013-10-25 15:46:39';

$reply = "";
include 'DBConfig.php';
$tbl_name = "balancesheet";

$sql = "SELECT * FROM balancesheet b where MerchantId=$uid and Time between Date('".$sDate."') and Date('".$eDate."') order by Time desc;";
//echo $sql;
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);

    $reply .= "<tr>";
    $reply .= "<td>".$row2['OutletName']."</td>";
    
    if ($row['Transaction'] < 0) {
        $reply .= "<td>" . '-' . "</td>"; //Debit
        $reply .= "<td>" . -1 * $row['Transaction'] . "</td>"; //Credit
        $reply .= "<td>" . $row['NewBalance'] . "</td>";
        //        echo "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <a href="#" onclick="viewEntry(' . $row['OutletId'] . ',1)">' . $row2['OutletName'] . "</a></td>";
        $reply .= "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <b>' . $row2['OutletName'] . "</b></td>";
    } else {
        
        $reply .= "<td>" . $row['Transaction'] . "</td>"; //Debit
        $reply .= "<td>" . '-' . "</td>"; //Credit
        $reply .= "<td>" . $row['NewBalance'] . "</td>";
        $reply .= "<td>" . 'MoneyBookers recharge. Transaction Id <b>' . $row['MBTransactionId'] . "</b></td>";
    }
    
    $reply .= "<td>" . date("F j, Y, g:i a", strtotime($row['Time'])) . "</td>";
    $reply .= "</tr>";
}

//for ($i=0;$i<5;$i++){
//        $reply .= "<tr>";
//    $reply .= "<td>" . $i . "</td>";
//    $reply .= "<td>" . "DummyName".$i . "</td>";
//    $reply .= "<td>" .  "DummyStatement".$i. "</td>";
//    $reply .= "<td>" . "DummyDate".$i . "</td>";
//    $reply .= "<td>" .  "DummyStatement".$i. "</td>";
//    $reply .= "<td>" . "DummyDate".$i . "</td>";
//    $reply .= "</tr>";
//}

echo $reply;
?>
