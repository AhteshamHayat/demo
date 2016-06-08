<?php
$page = 1;
if (empty($_REQUEST['page'])) {
    $page = 1;
} else {
    $page = $_REQUEST['page'];
}

if (empty($_REQUEST['sDate']) || empty($_REQUEST['eDate'])){
include 'DBConfig.php';

$tbl_name = "transactions";
$query = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$uid";
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 10;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);

$sql = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$uid order by TransationTime desc LIMIT $start, $limit";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $query1 = "SELECT * from coupons where CouponId=" . $row['CouponId'];
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_array($result1);

    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);

    echo "<tr>";
    echo "<td>" . $row['TransactionId'] . "</td>";
    echo "<td>" . $row2['OutletName'] . "</td>";
    echo "<td>" . $row1['DealStatement'] . "</td>";
//    echo "<td>" . '<a href="#" onclick="viewEntryOutlet(' . $row['OutletId'] . ',1)">' . $row2['OutletName'] . "</a></td>";
//    echo "<td>" . '<a href="#" onclick="viewEntryCampaign(' . $row['CouponId'] . ',1)">' . $row1['DealStatement'] . "</a></td>";
//    echo "<td>" . $row['TransactionId'] . "</td>";
    echo "<td>" . date("F j, Y, g:i a", strtotime($row['TransationTime'])) . "</td>";
    echo "</tr>";
}
}else{

include 'DBConfig.php';

$stDate = strtotime($_REQUEST['sDate']);
$enDate = strtotime($_REQUEST['eDate']);

$tbl_name = "transactions";
$query = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$uid and TransationTime between ".$stDate." and ".$enDate;
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 10;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);

$sql = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$uid  and TransationTime between ".$stDate." and ".$enDate." order by TransationTime desc LIMIT $start, $limit";
$result = mysqli_query($con, $sql);

while ($row = mysqli_fetch_array($result)) {
    $query1 = "SELECT * from coupons where CouponId=" . $row['CouponId'];
    $result1 = mysqli_query($con, $query1);
    $row1 = mysqli_fetch_array($result1);

    $query2 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);
    $row2 = mysqli_fetch_array($result2);

    echo "<tr>";
    echo "<td>" . $row['TransactionId'] . "</td>";
    echo "<td>" . $row2['OutletName'] . "</td>";
    echo "<td>" . $row1['DealStatement'] . "</td>";
//    echo "<td>" . '<a href="#" onclick="viewEntryOutlet(' . $row['OutletId'] . ',1)">' . $row2['OutletName'] . "</a></td>";
//    echo "<td>" . '<a href="#" onclick="viewEntryCampaign(' . $row['CouponId'] . ',1)">' . $row1['DealStatement'] . "</a></td>";
//    echo "<td>" . $row['TransactionId'] . "</td>";
    echo "<td>" . date("F j, Y, g:i a", $row['TransationTime']) . "</td>";
    echo "</tr>";
}

}

?>