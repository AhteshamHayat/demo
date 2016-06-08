<?php
//session_start();
//if ($_SESSION['loggedIn'] != 1) {
//    echo '<script language="javascript"> window.location = "';
//    echo 'signup.php';
//    echo '"; </script>';
//} else {
//    $uid = $_SESSION['userId'];
//}
?>
<html>
    <?php
//echo var_dump($_REQUEST);
    $OutletId;
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

    if (empty($_REQUEST["outletId"])) {
        $Validflag = 1;
    } else {
        $OutletId = $_REQUEST["outletId"];
    }
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
        echo 'editOutletForm.php?v=0&index=' . $OutletId;
        echo '"; </script>';
    } else {

        include 'DBConfig.php';
        $query = "update outlets set OutletAddress='$address',OutletName='$name',OutletCity='$city',OutletCountry='$country',OutletContactNo='$conatctNo',";
        $query .= "OutletLatitude=$lat,OutletLongitude=$lon,TypeId=$category where OutletId=$OutletId";

        mysqli_query($con, $query);

        $lastId = $OutletId;

        if ($_FILES['inputLogo']['size'] == 0) {
//        echo 'no thumbnail image is present';
        } else {
            logoUpload();
            $queryUpdate = "UPDATE outlets set OutletThumbnail='$path' where OutletId=$lastId";
            mysqli_query($con, $queryUpdate);
        }
        if ($_FILES['inputCover']['size'] == 0) {
//        echo 'no cover image is present';
        } else {
            coverUpload();
            $queryUpdate = "UPDATE outlets set OutletImage='$coverPath' where OutletId=$lastId";
            mysqli_query($con, $queryUpdate);
        }
//        mysqli_query($con, $queryUpdate);
        mysqli_close($con);
        
//        echo $query;
//        sleep(3);
//        
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


            /*             * ***************    Thumbnail  ******************** */
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
                        $path = 'cache/OutletThumbnail_' . $lastId . $sExt;
                        echo $path;
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

            /*             * ***************    Thumbnail  ******************** */
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