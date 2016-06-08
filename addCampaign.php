<html>
    <?php
    session_start();
    if ($_SESSION['loggedIn'] != 1) {
        echo '<script language="javascript"> window.location = "';
        echo 'signup.php';
        echo '"; </script>';
        //header('Location: index.php');
    } else {
        $uid = $_SESSION['userId'];
    }
    ?>
    <?php
    include 'DBConfig.php';
    echo var_dump($_REQUEST);
    $couponType = "";
    $spendingBuyingSelect = "";
    $currency = "";
    $subType = "";
    $path = "";
    $Validflag = 0;
    $query1 = "SELECT * FROM merchants where MerchantId=$uid";
    $result = mysqli_query($con, $query1);
    $row = mysqli_fetch_array($result);
    $balance = $row['Balance'];
//currency
    if (empty($_REQUEST["deal"])) {
        $Validflag = 1;
    } else {
        $deal = $_REQUEST["deal"];
    }
    if (empty($_REQUEST["cost"])) {
        $Validflag = 1;
    } else {
        $cost = $_REQUEST["cost"];
    }
    if (empty($_REQUEST["outletsToken"])) {
        $Validflag = 1;
    } else {
        $outletsToken = $_REQUEST["outletsToken"];
    }
    if (empty($_REQUEST["couponType"])) {
        $Validflag = 1;
    } else {
        $couponType = $_REQUEST["couponType"];
    }
    if (empty($_REQUEST["spendingBuyingSelect"])) {
        $Validflag = 1;
    } else {
        $spendingBuyingSelect = $_REQUEST["spendingBuyingSelect"];
    }
    if (empty($_REQUEST["currency"])) {
        $Validflag = 1;
    } else {
        $currency = $_REQUEST["currency"];
    }

    if ($couponType == "discountOffer") {
        $subType = $couponType . ":" . $spendingBuyingSelect . ":" . $currency;
    } else {
        $subType = $couponType;
    }

    if ($Validflag == 1) {
        echo '<script language="javascript"> window.location = "';
        echo 'addCampaignForm.php?v=0';
        echo '"; </script>';
    } else {
        $values = explode(",", $outletsToken);
        foreach ($values as $value) {

            list($tempId, $sD, $eD, $tempToken) = explode(";", $value);
            $sDate = strtotime($sD);
            $eDate = strtotime($eD);

            $query = "INSERT INTO coupons (CouponImage,Pushed, Availed, OutletId, TypeId, SubType, EndTime, DealStatement, StartTime, MerchantId, CreatedOn, IsDeleted)";
            $query .= " values ('$path',$tempToken, 0,$tempId,42,'$subType',$eDate,'$deal',$sDate,$uid,now(),0)";
            mysqli_query($con, $query);

            $lastId = mysqli_insert_id($con);

            $balance = $balance - ($tempToken / 10);
            $query3 = "INSERT INTO balancesheet (Transaction, MerchantId, Time, MBTransactionId, OutletId, NewBalance)";
            $query3 .= " values (-($tempToken/10),$uid,now(),0,$tempId,$balance)";
            mysqli_query($con, $query3);
            echo $query;
        }

        $newAmount = $balance;
        $query2 = "update merchants set Balance=$newAmount where MerchantId=$uid";
        mysqli_query($con, $query2);

        echo '<script language="javascript"> window.location = "';
        echo 'campaigns.php';
        echo '"; </script>';
    }
    ?>
</html>