<?php

$page = 1;
if (empty($_REQUEST['page'])) {
    $page = 1;
} else {
    $page = $_REQUEST['page'];
}

if (empty($_REQUEST['sDate']) || empty($_REQUEST['eDate'])){

include 'DBConfig.php';

$tbl_name = "balancesheet";
$query = "SELECT * FROM $tbl_name where MerchantId=$uid";
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 10;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);

$sql = "SELECT * FROM $tbl_name where MerchantId=$uid order by Time desc LIMIT $start, $limit";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);

    echo "<tr>";
    echo "<td>".$row2['OutletName']."</td>";
    
    if ($row['Transaction'] < 0) {
        echo "<td>" . '-' . "</td>"; //Debit
        echo "<td>" . -1 * $row['Transaction'] . "</td>"; //Credit
        echo "<td>" . $row['NewBalance'] . "</td>";
//        echo "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <a href="#" onclick="viewEntry(' . $row['OutletId'] . ',1)">' . $row2['OutletName'] . "</a></td>";
        echo "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <b>' . $row2['OutletName'] . "</b></td>";
    } else {
        
        echo "<td>" . $row['Transaction'] . "</td>"; //Debit
        echo "<td>" . '-' . "</td>"; //Credit
        echo "<td>" . $row['NewBalance'] . "</td>";
        echo "<td>" . 'MoneyBookers recharge. Transaction Id <b>' . $row['MBTransactionId'] . "</b></td>";
    }
    
    echo "<td>" . date("F j, Y, g:i a", strtotime($row['Time'])) . "</td>";
    echo "</tr>";
}

}else {
$uid = 9;
//date_format($_REQUEST['sDate'], 'Y-m-d H:i:s');
$stDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['sDate']));
$enDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['eDate']));

include 'DBConfig.php';

$tbl_name = "balancesheet";
$query = "SELECT * FROM $tbl_name where MerchantId=$uid and Time between Date('".$stDate."') and Date('".$enDate."') order by Time desc";
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 10;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);

$sql = "SELECT * FROM $tbl_name where MerchantId=$uid and Time between Date('".$stDate."') and Date('".$enDate."') order by Time desc LIMIT $start, $limit";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);

    echo "<tr>";
    echo "<td>".$row2['OutletName']."</td>";
    
    if ($row['Transaction'] < 0) {
        echo "<td>" . '-' . "</td>"; //Debit
        echo "<td>" . -1 * $row['Transaction'] . "</td>"; //Credit
        echo "<td>" . $row['NewBalance'] . "</td>";
//        echo "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <a href="#" onclick="viewEntry(' . $row['OutletId'] . ',1)">' . $row2['OutletName'] . "</a></td>";
        echo "<td>" . -10 * $row['Transaction'] . ' Coupons pushed at <b>' . $row2['OutletName'] . "</b></td>";
    } else {
        
        echo "<td>" . $row['Transaction'] . "</td>"; //Debit
        echo "<td>" . '-' . "</td>"; //Credit
        echo "<td>" . $row['NewBalance'] . "</td>";
        echo "<td>" . 'MoneyBookers recharge. Transaction Id <b>' . $row['MBTransactionId'] . "</b></td>";
    }
    
    echo "<td>" . date("F j, Y, g:i a", strtotime($row['Time'])) . "</td>";
    echo "</tr>";
}

}
	

?>

