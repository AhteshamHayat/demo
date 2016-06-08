<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
$index = $_REQUEST["index"];
$condition = "";

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

//if ((empty($_REQUEST['sDate']) && empty($_REQUEST['eDate']))) {
//    $stDate = strtotime($_REQUEST['sDate']);
//    $enDate = strtotime($_REQUEST['eDate']);
//    $condition .= " and TransationTime between ".$stDate." and ".$enDate;
//} else {
//    if(!empty($_REQUEST['sDate'])){
//        $stDate = strtotime($_REQUEST['sDate']);
//        $condition .= " and TransationTime > ".$stDate;
//    }
//    
//    if(!empty($_REQUEST['eDate'])){
//        $enDate = strtotime($_REQUEST['eDate']);
//        $condition .= " and TransationTime < ".$enDate;
//    }
//}
//echo $condition;
include 'DBConfig.php';
$pushed = "";
$availed = "";
$pushedAvailed = "";
$reply = array();
$year;
$gender;
$m1 = $m2 = $m3 = $m4 = $m5 = $m6 = $m7 = 0;
$f1 = $f2 = $f3 = $f4 = $f5 = $f6 = $f7 = 0;
$reply['m']['1'] = $reply['m']['2'] = $reply['m']['3'] = $reply['m']['4'] = $reply['m']['5'] = $reply['m']['6'] = $reply['m']['7'] = 0;
$reply['f']['1'] = $reply['f']['2'] = $reply['f']['3'] = $reply['f']['4'] = $reply['f']['5'] = $reply['f']['6'] = $reply['f']['7'] = 0;
$usersQuery = "select * from users u join transactions t on t.UserId=u.UserId join outlets o on o.OutletId=t.OutletId where o.MechantId=$index".$condition;
$result = mysqli_query($con, $usersQuery);

$now = new DateTime(Date('m/d/Y'));

while ($row = mysqli_fetch_array($result)) {

    $gender = $row['Gender'];
    $bday = new DateTime($row['Birthday']);
    $diff = $now->diff($bday);
    $year = $diff->y;

    switch ($gender) {
        case "m":
            if ($year >= 13 && $year <= 17) {
                $m1++;
                $reply['m']['1'] = $m1;
            } else if ($year >= 18 && $year <= 24) {
                $m2++;
                $reply['m']['2'] = $m2;
            } else if ($year >= 25 && $year <= 34) {
                $m3++;
                $reply['m']['3'] = $m3;
            } else if ($year >= 35 && $year <= 44) {
                $m4++;
                $reply['m']['4'] = $m4;
            } else if ($year >= 45 && $year <= 54) {
                $m5++;
                $reply['m']['5'] = $m5;
            } else if ($year >= 55 && $year <= 60) {
                $m6++;
                $reply['m']['6'] = $m6;
            } else if ($year > 60) {
                $m7++;
                $reply['m']['7'] = $m7;
            }
            break;
        case "f";
            if ($year >= 13 && $year <= 17) {
                $f1++;
                $reply['f']['1'] = $f1;
            } else if ($year >= 18 && $year <= 24) {
                $f2++;
                $reply['f']['2'] = $f2;
            } else if ($year >= 25 && $year <= 34) {
                $f3++;
                $reply['f']['3'] = $f3;
            } else if ($year >= 35 && $year <= 44) {
                $f4++;
                $reply['f']['4'] = $f4;
            } else if ($year >= 45 && $year <= 54) {
                $f5++;
                $reply['f']['5'] = $f5;
            } else if ($year >= 55 && $year <= 60) {
                $f6++;
                $reply['f']['6'] = $f6;
            } else if ($year > 60) {
                $f7++;
                $reply['f']['7'] = $f7;
            }
            break;
    }
}
echo json_encode($reply);
//echo $reply;
//while($Outletrow = mysqli_fetch_array($Outletresult)){
//    $pushed .= $Outletrow['Pushed'] . "^" . $Outletrow['CreatedOn'] . ",";
//    $availed .= $Outletrow['Availed'] . "^" . $Outletrow['CreatedOn'] . ",";
//    $pushedAvailed .= $Outletrow['Pushed'] . "^" . $Outletrow['Availed'] . "^" . $Outletrow['CreatedOn'] . ",";
//}
//
//$reply = $pushed . "@" . $availed . "@" . $pushedAvailed;
//mysqli_close($con);
//echo $reply;
//$bday = new DateTime('05/05/1987');
//$now = new DateTime(Date('m/d/Y'));
//$diff = $now->diff($bday);
//echo $diff->y;
?>