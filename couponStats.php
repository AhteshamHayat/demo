<?php

//header('Access-Control-Allow-Origin: *');
//header('Content-Type: application/json');
//$reply = array();
//$sDate = "09/18/2013 2:51 PM";
//$eDate = "09/25/2013 3:46 PM";
//$stDate = explode(" ", $sDate);
//list($stDate,, ) = explode(" ", $sDate);
//list($enDate,, ) = explode(" ", $eDate);
//$days = (strtotime($enDate) - strtotime($stDate)) / (24 * 60 * 60) + 1;
//
//for ($i = 1; $i <= $days; $i++) {
//    $reply[$i] = 0;
//}
//echo $stDate . " <:> " . $enDate . " <:> " . $days;
//echo json_encode($reply);

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

$reply = array();

$index = $_REQUEST["index"];
$condition = "";
include 'DBConfig.php';
$tbl_name = "transactions";

if (empty($_REQUEST['outlet'])) {
    $outlet = 0;
} else {
    $outlet = $_REQUEST['outlet'];
    if ($outlet != "All") {
        $condition .= " and t.OutletId=$outlet";
    }
}

if (empty($_REQUEST['campaign'])) {
    $campaign = 0;
} else {
    $campaign = $_REQUEST['campaign'];
    if ($campaign != "All") {
        $condition .= " and t.CouponId=$campaign";
    }
}

if (!empty($_REQUEST['sDate'])) {
    $stDate = strtotime($_REQUEST['sDate']);
    $condition .= " and TransationTime > " . $stDate;
}

if (!empty($_REQUEST['eDate'])) {
    $enDate = strtotime($_REQUEST['eDate']);
    $condition .= " and TransationTime < " . $enDate;
}

if (empty($_REQUEST['sDate']) && empty($_REQUEST['eDate'])) {
    $eres = mysqli_query($con, "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$index order by TransationTime desc LIMIT 1;");
    $erow = mysqli_fetch_array($eres);
    $stDate = ($erow['TransationTime'] - 2678400);
    $enDate = $erow['TransationTime'];
    // and TransationTime between " . $stDate . " and " . $enDate
    
    $condition .= "  and TransationTime between " . $stDate . " and " . $enDate;
}

//echo ' <:> ' . $condition;
?>

<?php

//$uid = 9;

$days = ($enDate - $stDate) / (24 * 60 * 60);
$days++;
for ($i = 1; $i <= $days; $i++) {
    $reply["data"][$i] = 0;
}

$query = "SELECT * FROM $tbl_name t JOIN outlets o on t.OutletId=o.OutletId where o.MechantId=$index".$condition;
$result = mysqli_query($con, $query);
$Stremainder = 86400 - fmod($stDate, 86400);
$StTime = $stDate + $Stremainder;
$Enremainder = fmod($enDate, 86400);
$EnTime = $enDate - $Enremainder;

while ($row = mysqli_fetch_array($result)) {


    $time = $row['TransationTime'];
    $count = 0;
//    echo date("Y-m-d H:i:s", $StTime);
    if ($time >= ($stDate) && $time < $StTime) {
        $reply["data"][$count + 1] += 1;
    }

    while ($count < $days - 2) {
//        echo date("Y-m-d H:i:s", ($StTime + (($count + 1) * 86400)));
        if ($time >= ($StTime + ($count * 86400)) && $time < ($StTime + (($count + 1) * 86400))) {
            $reply["data"][$count + 2] += 1;
            echo '';
            break;
        }
        $count++;
    }
//    echo date("Y-m-d H:i:s", $enDate);
    if ($time >= ($EnTime) && $time <= $enDate) {

        $reply["data"][$count + 2] += 1;
    }
}
$reply["count"] = $days;
$reply["date"] = $stDate;
echo json_encode($reply);
?>