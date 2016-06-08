<?php

//$stDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['sDate']));
//$enDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['eDate']));

$now = time();
$condition = "";
$page = 1;
if (empty($_REQUEST['page'])) {
    $page = 1;
} else {
    $page = $_REQUEST['page'];
}

if (empty($_REQUEST['outlet'])) {
    $outlet = 0;
} else {
    $outlet = $_REQUEST['outlet'];
	if($outlet != "All"){$condition .= " and OutletId=$outlet";}
	
}

if (empty($_REQUEST['active'])) {
    $active = 0;
} else {
    $active = $_REQUEST['active'];
	if($active == "true"){$condition .= " and EndTime > ".$now;}
	
}

if (!(empty($_REQUEST['sDate']) && empty($_REQUEST['eDate']))){
	$stDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['sDate']));
	$enDate = date("Y-m-d H:i:s",  strtotime($_REQUEST['eDate']));
	$condition .= " and CreatedOn between Date('".$stDate."') and Date('".$enDate."')";
}

include 'DBConfig.php';
$tbl_name = "coupons";
$query = "SELECT * FROM $tbl_name where MerchantId=$uid and IsDeleted=0".$condition;
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 5;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);
if($page > $lastpage){$page = $lastpage;}
$query1 = "SELECT * FROM $tbl_name where MerchantId=$uid and IsDeleted=0".$condition." order by CouponId desc LIMIT $start, $limit";
$result = mysqli_query($con, $query1);

while ($row = mysqli_fetch_array($result)) {

	$query1 = "SELECT * FROM outlets where OutletId=" . $row['OutletId'];
        $result1 = mysqli_query($con, $query1);
        $row1 = mysqli_fetch_array($result1);
        $outletName = $row1['OutletName'];
		$address = $row1['OutletAddress'];
	
    if($row['CouponImage'] == "" || $row['CouponImage'] == null){
        $image = "cache/noImage.jpg";
    }else{
        $image = $row['CouponImage'];
    }
	
    echo	"<div class='row'><div class='col-xs-2'><img src='".$image."' class='img-rounded logo'></div>  ";  
echo	"<div style='margin-left: 10px; width: 240px; float: left;'><h2 class='outlet-name'>".$outletName."</h2><p style='margin-top: 5px; margin-right: 15px;'>".$address."<p>";
echo	"<p style='font-size: 12px; margin-right: 15px;'><b>Offer:</b>".$row['DealStatement']."</p></div>";
echo	"<div style='margin-left: 0px; width: 150px; float: left;'><h2 class='coupon-count'>".$row['Pushed']."</h2><p>Coupons Pushed</p>";
echo	"<p style='font-size: 11px; padding-top: 5px;'><b>Start Time:</b><br><span style='font-size: 12px;'>" . date("F j, Y, g:i a",  $row['StartTime']) . "</span></p></div>";
echo	"<div style='margin-left: 10px; width: 150px; float: left;'><h2 class='coupon-count'>".$row['Availed']."</h2><p>Coupons Availed</p>";
echo	"<p style='font-size: 11px; padding-top: 5px;'><b>End Time:</b><br><span style='font-size: 12px;'>" . date("F j, Y, g:i a",  $row['EndTime']) . "</span></p></div>";

if ($now < $row['EndTime']){
echo	"<div style='margin-left: 0px; width: 130px; float: left;'><div class='btn-group'><button type='button' class='btn btn-primary btn-sm' onclick='editEntryModal(" . $row['CouponId'] . ",2)'>Edit</button>";
echo	"<button type='button' class='btn btn-default btn-sm' onclick='deleteEntryModal(" . $row['CouponId'] . ",2)'>Delete</button></div>";
echo	"<p style='font-size: 11px; padding-top: 26px;'><b>Status:</b><br><span style='font-size: 12px;' class='label label-success'>Active</span></p></div>";
}else{
echo	"<div style='margin-left: 0px; width: 130px; float: left;'><div class='btn-group'>";
echo	"<button type='button' class='btn btn-default btn-sm' onclick='deleteEntryModal(" . $row['CouponId'] . ",2)'>Delete</button></div>";
echo	"<p style='font-size: 11px; padding-top: 26px;'><b>Status:</b><br><span style='font-size: 12px;'>Completed</span></p></div>";
}

echo	"</div><hr class='hr-strike'>";


}
mysqli_close($con);
?>