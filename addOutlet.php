<?php
session_start();
if ($_SESSION['loggedIn'] != 1) {
    session_destroy();
//echo 'here';
    echo '<script language="javascript"> window.location = "';
    echo 'signup.php';
    echo '"; </script>';
} else {
    $uid = $_SESSION['userId'];
}
?>
<html>
    <?php
//echo var_dump($_REQUEST);
    $path = "";
    $coverPath = "";
    $address = "";
    $country = "";
    $city = "";
    $name = "";
    $category = "";
    $sDate = "";
    $eDate = "";
    $days = "";
    $conatctNo = "";
    $services = "";
    $payment = "";
    $lat = "";
    $lon = "";
    $Validflag = 0;

    if (empty($_REQUEST["country"])) {
        $Validflag = 1;
    } else {
        $country = $_REQUEST["country"];
    }
    if (empty($_REQUEST["city_state"])) {
        $Validflag = 1;
    } else {
        $city = $_REQUEST["city_state"];
    }
    if (empty($_REQUEST["outletName"])) {
        $Validflag = 1;
    } else {
        $name = $_REQUEST["outletName"];
    }
    if (empty($_REQUEST["category"])) {
        $Validflag = 1;
    } else {
        $category = $_REQUEST["category"];
    }
    if (empty($_REQUEST["conatctNo"])) {
        $Validflag = 1;
    } else {
        $conatctNo = $_REQUEST["conatctNo"];
    }
    if (empty($_REQUEST["lat"])) {
        $Validflag = 1;
    } else {
        $lat = $_REQUEST["lat"];
    }
    if (empty($_REQUEST["lon"])) {
        $Validflag = 1;
    } else {
        $lon = $_REQUEST["lon"];
    }
    if (empty($_REQUEST["outletAdd"])) {
        $Validflag = 1;
    } else {
        $address = $_REQUEST["outletAdd"];
    }

    if ($Validflag == 1) {

        echo '<script language="javascript"> window.location = "';
        echo 'addOutletForm.php?v=0';
        echo '"; </script>';
    } else {

        include 'DBConfig.php';

        $query = "INSERT INTO outlets (OutletImage,OutletThumbnail,OutletAddress, OutletName, OutletCity, OutletCountry, TradingStartTime, TradingEndTime, TradingDays, OutletContactNo, MechantId, OutletLatitude, OutletLongitude, OutletRatingSum, OutletRatingCount, Services, TypeId, CreatedOn, IsDeleted)";
        $query .= " values ('$coverPath','$path','$address','$name','$city','$country','$sDate','$eDate','$days','$conatctNo',$uid,$lat,$lon,0,0,'$services',$category, now(),0)";
        mysqli_query($con, $query);
        $lastId = mysqli_insert_id($con);

        logoUpload();
        coverUpload();
        
        $queryUpdate = "UPDATE outlets set OutletImage='$coverPath',OutletThumbnail='$path' where OutletId=$lastId";
        mysqli_query($con, $queryUpdate);
        mysqli_close($con);

        echo '<script language="javascript"> window.location = "';
        echo 'Outlets.php';
        echo '"; </script>';
    }
    ?>

    <?php

    function logoUpload() { // Note: GD library is required for this function
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $iWidth = $iHeight = 500; // desired image result dimensions
            $iJpgQuality = 90;


                /*                 * ***************    Thumbnail  ******************** */
                // if no errors and size less than 250kb
                if (!$_FILES['inputLogo']['error'] && $_FILES['inputLogo']['size'] < 4 * 1024 * 1024) {
                    if (is_uploaded_file($_FILES['inputLogo']['tmp_name'])) {

                        // new unique filename
                        global $lastId;
                        global $path;
                        $sTempFileName = 'cache/' . md5(time() . rand());

                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['inputLogo']['tmp_name'], $sTempFileName);

                        // change file permission to 644
                        @chmod($sTempFileName, 0644);

                        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                            $aSize = getimagesize($sTempFileName); // try to obtain image info
                            if (!$aSize) {
                                @unlink($sTempFileName);
                                return;
                            }

                            // check for image type
                            switch ($aSize[2]) {
                                case IMAGETYPE_JPEG:
                                    $sExt = '.jpg';

                                    // create a new image from file 
                                    $vImg = @imagecreatefromjpeg($sTempFileName);
                                    break;
                                /* case IMAGETYPE_GIF:
                                  $sExt = '.gif';

                                  // create a new image from file
                                  $vImg = @imagecreatefromgif($sTempFileName);
                                  break; */
                                case IMAGETYPE_PNG:
                                    $sExt = '.png';

                                    // create a new image from file 
                                    $vImg = @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }

                            // create a new true color image
                            $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);

                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);

                            // define a result image filename
                            $sResultFileName = $sTempFileName . $sExt;
                            $path = 'cache/CouponThumbnail_' . $lastId . $sExt;
                            // output image to file
                            imagejpeg($vDstImg, $path, $iJpgQuality);
                            @unlink($sTempFileName);

                            return $path;
//                        return $sResultFileName;
                        }
                    }
                }
        }
    }
    ?>

    <?php

    function coverUpload() { // Note: GD library is required for this function
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $iWidth = 500;
            $iHeight = 250; // desired image result dimensions
            $iJpgQuality = 90;
            
                /*                 * ***************    Thumbnail  ******************** */
                // if no errors and size less than 250kb
                if (!$_FILES['inputCover']['error'] && $_FILES['inputCover']['size'] < 4 * 1024 * 1024) {
                    if (is_uploaded_file($_FILES['inputCover']['tmp_name'])) {

                        // new unique filename
                        global $lastId;
                        global $coverPath;
                        $sTempFileName = 'cache/' . md5(time() . rand());

                        // move uploaded file into cache folder
                        move_uploaded_file($_FILES['inputCover']['tmp_name'], $sTempFileName);

                        // change file permission to 644
                        @chmod($sTempFileName, 0644);

                        if (file_exists($sTempFileName) && filesize($sTempFileName) > 0) {
                            $aSize = getimagesize($sTempFileName); // try to obtain image info
                            if (!$aSize) {
                                @unlink($sTempFileName);
                                return;
                            }

                            // check for image type
                            switch ($aSize[2]) {
                                case IMAGETYPE_JPEG:
                                    $sExt = '.jpg';

                                    // create a new image from file 
                                    $vImg = @imagecreatefromjpeg($sTempFileName);
                                    break;
                                /* case IMAGETYPE_GIF:
                                  $sExt = '.gif';

                                  // create a new image from file
                                  $vImg = @imagecreatefromgif($sTempFileName);
                                  break; */
                                case IMAGETYPE_PNG:
                                    $sExt = '.png';

                                    // create a new image from file 
                                    $vImg = @imagecreatefrompng($sTempFileName);
                                    break;
                                default:
                                    @unlink($sTempFileName);
                                    return;
                            }

                            // create a new true color image
                            $vDstImg = @imagecreatetruecolor($iWidth, $iHeight);

                            // copy and resize part of an image with resampling
                            imagecopyresampled($vDstImg, $vImg, 0, 0, (int) $_POST['x1'], (int) $_POST['y1'], $iWidth, $iHeight, (int) $_POST['w'], (int) $_POST['h']);

                            // define a result image filename
                            $sResultFileName = $sTempFileName . $sExt;
                            $coverPath = 'cache/OutletCover_' . $lastId . $sExt;
                            // output image to file
                            imagejpeg($vDstImg, $coverPath, $iJpgQuality);
                            @unlink($sTempFileName);

                            return $coverPath;
//                        return $sResultFileName;
                        }
                    }
                }
        }
    }
    ?>

</html>