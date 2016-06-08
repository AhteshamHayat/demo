<?php
session_start();
if ($_SESSION['loggedIn'] != 1) {
    header('Location: signup.php');
} else {
    include 'DBConfig.php';
    $uid = $_SESSION['userId'];
    $balanceQuery = "select * from merchants where MerchantId=$uid";
    $balanceResult = mysqli_query($con, $balanceQuery);
    $balanceRow = mysqli_fetch_array($balanceResult);
    $Currentbalance = $balanceRow['Balance'];
}

function customError($errno, $errstr) {
    
}

set_error_handler("customError");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>City Deals - Signup as Seller</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">        

        <style>
            h1, h2, h3, h4, h5 {
                font-family: 'Sintony', sans-serif;
            }

            .ring35 {
                height: 54px;
                width: 54px;
                -moz-border-radius: 27px;
                border-radius: 27px;
                background: #d43f3a;
                text-align: center;
                font-size: 24px;
                color: #FFF;
                margin-right: 5px;
                padding-top: 10px;
            }

            .social-icon{
                text-align: center;
                color: #333; 
                font-family: socialico, sans-serif;
                font-size: 32px;
            }
            .social-icon:hover{
                color: #d43f3a;
                padding-top: 1px;
            }


            .hr-strike {
                width: 30px; 
                float: left;
                height: 2px;
                color: #3c3c3c;
                background-color: #3c3c3c;
            }

            .container-non-responsive {
                /* Margin/padding copied from Bootstrap */
                margin-left: auto;
                margin-right: auto;
                padding-left: 15px;
                padding-right: 15px;

                /* Set width to your desired site width */
                width: 1170px;
            }



        </style>

    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">
        <?php include 'header.php' ?>

        <div id='content' class='container-non-responsive'>
            <div class='row'>
                
                <?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("outlets").className = "active";
                </script>
                
                <div class="col-xs-9">
                    <div class='row'>
                        <div class='col-xs-12'>
                            <div class="jumbotron" style="background: #FFF;color: #555555">
                                <div class='row'>

                                    <div class='col-xs-12'>
                                        <p class='ring35' style='background: #4cae4c; float: left;'>1</p>
                                        <div style="float: left; margin-top: 10px;">
                                            <hr class='hr-strike' style='background: #777;'>
                                            <div style='font-size: 16px;float: left; margin-left: 5px; margin-right: 5px; margin-top: 5px;'>Add Outlet</div>
                                            <hr class='hr-strike' style="background: #777c;">
                                        </div>                                       
                                        <p class='ring35' style='background: #AAA; color: #EEE;float: left; margin-left: 12px;'>2</p>
                                        <div style="float: left; margin-top: 10px;">
                                            <hr class='hr-strike' style="background-color: #AAA;">
                                            <div style='font-size: 16px;color:#AAA; float: left; margin-left: 5px; margin-right: 5px;margin-top: 5px;'>Push Coupons</div>
                                            <hr class='hr-strike' style='background-color:#AAA;'>
                                        </div>                                       
                                        <p class='ring35' style='background: #AAA; color: #EEE;float: left; margin-left: 12px;'>3</p>
                                        <div style="float: left; margin-top: 10px;">
                                            <hr class='hr-strike' style="background-color: #AAA;">
                                            <div style='font-size: 16px;color:#AAA; float: left; margin-left: 5px; margin-right: 5px;margin-top: 5px;'>Print QR Code</div>
                                            <hr class='hr-strike' style='background-color:#AAA;'>
                                        </div>                                       
                                    </div>


                                </div>
                                <div class='row'>
                                    <div class='col-xs-12'>
                                        <h1 style='font-size: 54px;'>Dang! you've no outlets.</h1>
                                        <h2>Start by adding one!</h2>
                                        <p><a class="btn btn-primary btn-lg btn-block" style="margin-top: 50px;" role="button">Add an Outlet</a></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div id='footer' style="height: 50px; background: #FFF;width: 100% !important; border-top: solid 2px #285e8e;" class="nav navbar-fixed-bottom">

            <div class='container-non-responsive' style="margin-top: -2px;">
                <div class="row">
                    <div class="col-xs-5"> </div>
                    <div class="col-xs-2">
                        <div class='row'>
                            <div class='col-xs-4 social-icon' ><i class="fa fa-facebook-square"></i> fa-camera-retro</div>
                            <div class='col-xs-4 social-icon' ><i class="fa fa-twitter-square"></i> fa-camera-retro</div>
                            <div class='col-xs-4 social-icon' ><i class="fa fa-google-plus-square"></i> fa-camera-retro</div>
                        </div>

                    </div>
                    <div class="col-xs-5"> </div>
                </div>
            </div>
        </div>


        <?php include 'rechargeModal.php' ?>        
        <?php include 'QRCodeModal.php' ?>        
    </body>
</html>