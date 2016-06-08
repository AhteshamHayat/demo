<?php
//
//$pushed = 14;
//$availed = 21;
//for ($i = 0; $i < 5; $i++) {
//    echo "<div class='row'><div class='col-xs-2'><img src='//placehold.it/100x100&text=100x100' class='img-rounded logo'></div>";
//    echo "<div class='col-xs-4' ><h2 class='outlet-name'>Chenone-" . $i . "</h2><p>Street 22, F5-1, Islamabad<br><b>Added on:</b>Nov 17, 2013 08:19 pm</p></div>";
//    echo "<div class='col-xs-2' ><h2 class='coupon-count'>" . $pushed . "</h2><p>Coupons Pushed</p></div>";
//    echo "<div class='col-xs-2' ><h2 class='coupon-count'>" . $availed . "</h2><p>Coupons Availed</p></div>";
//    echo "<div class='col-xs-2' ><div class='btn-group'>";
//    echo "<button type='button' class='btn btn-danger'>Action</button>";
//    echo "<button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'></span></button>";
//    echo "<ul class='dropdown-menu' role='menu'><li><a href='#'>View</a></li><li><a href='#'>Edit</a></li><li><a href='#'>Delete</a></li><li class='divider'></li><li><a href='#'>Create Campaign</a></li></ul></div></div>";
//    echo "</div><hr class='hr-strike'>";
//}
?>

<?php

$page = 1;
if (empty($_REQUEST['page'])) {
    $page = 1;
} else {
    $page = $_REQUEST['page'];
}

include 'DBConfig.php';

$tbl_name = "outlets";
$query = "SELECT * FROM $tbl_name where MechantId=$uid and IsDeleted=0";
$result = mysqli_query($con, $query);
$total_pages = mysqli_num_rows($result);

$limit = 5;
$start = ($page - 1) * $limit;
$lastpage = ceil($total_pages / $limit);

$query = "SELECT * FROM $tbl_name where MechantId=$uid and IsDeleted=0 order by OutletId desc LIMIT $start, $limit";
$result = mysqli_query($con, $query);

while ($row = mysqli_fetch_array($result)) {

    $query2 = "SELECT * FROM coupons c where OutletId=" . $row['OutletId'];
    $result2 = mysqli_query($con, $query2);

    $pushCount = 0;
    $availCount = 0;
    while ($row2 = mysqli_fetch_array($result2)) {
        $pushCount += $row2['Pushed'];
        $availCount += $row2['Availed'];
    }
    if($row['OutletThumbnail'] == ""){
        $image = "cache/noImage.jpg";
    }else{
        $image = $row['OutletThumbnail'];
    }
    echo "<div class='row'><div class='col-xs-2'><img src='".$row['OutletThumbnail']."' class='img-rounded logo'></div>";
    echo "<div class='col-xs-4' ><h2 class='outlet-name'>" . $row['OutletName'] . "</h2><p>".$row['OutletAddress']."<br><b>Added on:</b>".date("j F Y, g:i a",  strtotime($row['CreatedOn']))."</p></div>";
    echo "<div class='col-xs-2' ><h2 class='coupon-count'>" . $pushCount . "</h2><p>Coupons Pushed</p></div>";
    echo "<div class='col-xs-2' ><h2 class='coupon-count'>" . $availCount . "</h2><p>Coupons Availed</p></div>";
    echo "<div class='col-xs-2' ><div class='btn-group'>";
    echo "<button type='button' class='btn btn-danger'>Action</button>";
    echo "<button type='button' class='btn btn-danger dropdown-toggle' data-toggle='dropdown'><span class='caret'></span><span class='sr-only'></span></button>";
    echo "<ul class='dropdown-menu' role='menu'><li><a href='#'>View</a></li><li><a href='#' onclick='editEntry(" . $row['OutletId'] . ",1)'>Edit</a></li><li><a href='#' onclick='deleteEntryModal(" . $row['OutletId'] . ",1,\"".$row['OutletName']."\")'>Delete</a></li><li class='divider'></li><li><a href='#'>Create Campaign</a></li></ul></div></div>";
    echo "</div><hr class='hr-strike'>";
}
mysqli_close($con);
?>