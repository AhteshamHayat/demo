<?php
if (empty($_REQUEST['v'])) {
    $valid = "101";
} else {
    $valid = $_REQUEST['v'];
}
?>
<?php
session_start();
include("simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();
?>
<?php
$_SESSION['captcha'] = simple_php_captcha(array(
    'min_font_size' => 28,
    'max_font_size' => 28,
    'backgrounds' => array('backgrounds/polyester-lite.png')
        ));
?>
<!DOCTYPE html>
<html>
    <head>
        <title>City Deals - Signup as Seller</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/jqBootstrapValidation.js"></script>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>

        <style>
            h1, h2, h3, h4, h5 {
                font-family: 'Sintony', sans-serif;
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

        <script>
            $(function(){
                
        $( "#forgotPasswordModalbtn" ).click(function(){
            var email = $("#forgotEmail").val();
            
            $.post("forgotPassword.php",
            {
                email:email
            },
            function(data,status){
//                alert("Data: " + data + "\nStatus: " + status);
                if(data == '1'){
                    $("#forgotPasswordModal").modal('hide');
                    $("#signUpMsg").html('<p class="alert alert-success" style="margin-bottom: 0px;">A verification link has been sent at your email address. Kindly check your inbox to activate the account.</p>');
                    $("#signupSuccessModal").modal('show');
                }else{
                    $("#forgotPasswordModal").modal('hide');
                    $("#signUpMsg").html('<p class="alert alert-danger" style="margin-bottom: 0px;">The email address provided is not correct. Please  provide a valid email address.</p>');
                    $("#signupSuccessModal").modal('show');
                }
            });
            
        });
                
                $("#signUp").click(function(){
                    var regEmail = $("#regEmail").val();
                    var regPassword = $("#regPassword").val();
                    var regCPassword = $("#regCPassword").val();
                    var regMobileno = $("#regMobileno").val();
                    var captcha = $("#captcha").val();
                    
                    $.post("signupValidation.php",
                    {
                        regEmail: regEmail,
                        regPassword: regPassword,
                        regCPassword: regCPassword,
                        regMobileno: regMobileno,
                        captcha: captcha
                    },
                    function(dataArray,status){
                        var data = dataArray['status'];
                        if(data == "incomplete"){
                            $("#signUpMsg").html('<p class="alert alert-danger" style="margin-bottom: 0px;">All fields are not provided. Kindly provide a value for every field.</p>');
                        }else if(data == "password"){
                            $("#signUpMsg").html('<p class="alert alert-danger" style="margin-bottom: 0px;">The passwords given donot match.</p>');
                        }else if(data == "captcha"){
                            $("#signUpMsg").html('<p class="alert alert-danger" style="margin-bottom: 0px;">You could not verify that you are a human.</p>');
                        }else if(data == "signup0"){
                            $("#signUpMsg").html('<p class="alert alert-danger" style="margin-bottom: 0px;">This given email is already registered with CityDeals. Kindly provide a new email address.</p>');
                        }else if(data == "signup1"){
                            $("#signUpMsg").html('<p class="alert alert-success" style="margin-bottom: 0px;">A verification link has been sent at your email address. Kindly check your inbox to activate the account.</p>');
                        }
                        
                        $("#signupSuccessModal").modal('show');
                    });

                });
            });
        </script>
    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">

        <?php
        if ($valid == "1") {
            echo '<div class="alert alert-danger">';
            echo '<strong>Validation Error:</strong>&nbsp;Either email or password is incorrect!';
            echo '</div>';
        }
        ?>

        <div id='header' style="height: 100px; width: 100% !important; background: url(img/bg_black.png) repeat-x; ">
            <div class='container-non-responsive'>
                <div class='row'>
                    <div id="logo" class="col-sm-6" style="padding-top: 15px; font-size: 32px; color: #FFFFFF; font-family: 'Euphoria Script', sans-serif;">
                        City Deals

                    </div>

                    <div class="col-sm-6" style="padding-top: 1px; color: #FFFFFF">
                        Already a member?
                        <form class="form-inline" role="form" action="signinValidation.php" method="post">
                            <div class="form-group">
                                <label class="sr-only" for="inputUsername">Email address</label>
                                <input name="inputEmail" type="email" class="form-control input-sm" data-validation-matches-match="email" id="inputUsername" placeholder="Username">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="inputPassword">Password</label>
                                <input name="inputPassword" type="password" class="form-control input-sm" id="inputPassword" placeholder="Password">
                            </div>

                            <div class="checkbox">

                            </div>
                            <button type="submit" class="btn btn-default btn-sm">Sign in</button>
                        </form>
                        <a href="#forgotPasswordModal" data-toggle="modal" style="text-decoration: none;color: white;margin-left: 170px">Forgot Password?</a>
                    </div>



                </div>

            </div>
        </div>

        <div id='Content' class='container-non-responsive'>
            <div class='row'>
                <div class="col-xs-6" style="padding-right: 10px; padding-bottom: 3px; margin-top: 10px; background: rgba(255,255,255,0);">
                    <div class="row">
                        <div class="col-sm-12"><h3 style="font-weight: bold; "><p>Looking to promote your brand?</p><p>Signup and start pushing coupons</p></h3></div>
                    </div>
                    <div class="row" style="padding-top: 20px;">
                        <div class="col-sm-1 col-sm-offset-1"><h3><span class="glyphicon glyphicon-map-marker"></span></h3></div> 
                        <div class="col-sm-10"><h3>Add your outlets</h3></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-1"><h3><span class="glyphicon glyphicon-qrcode"></span></h3></div> 
                        <div class="col-sm-10"><h3>Push the discount coupons</h3></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-1 col-sm-offset-1"><h3><span class="glyphicon glyphicon-usd"></span></h3></div> 
                        <div class="col-sm-10"><h3>Boost your sales</h3></div>
                    </div>

                    <div class="row" style="padding-top: 10px">
                        <div class="col-sm-12"><h3 style="font-weight: bold;"><p>Sign up now and get $100 credit for free.</p></h3></div>
                    </div>


                </div>
                <div class="col-xs-6" style="padding: 10px">

                    <div style="background: #FFF;border-top: dashed 1px #AAA;border-bottom: dashed 1px #AAA;">
                        <h3 style='text-align: center; font-weight: bold;'>Signup as Seller</h3>
                    </div>
                    <div style='padding: 5px; background: #FFFFFF; margin-top: 15px; border-top: dashed 1px #AAA;border-bottom: dashed 1px #AAA;'>
                        <div style="margin: 10px">
                            Kindly fill the form below to register as seller
                        </div>

                        <div class="row">
                            <div class="col-sm-11">
                                <form class="form-horizontal" role="form">
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                                        <div class="col-sm-7">
                                            <input type="email" class="form-control" id="regEmail" placeholder="abc@xyz.com">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Password</label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" id="regPassword" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputPassword3" class="col-sm-4 control-label">Confirm password</label>
                                        <div class="col-sm-7">
                                            <input type="password" class="form-control" id="regCPassword" placeholder="Password">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Mobile number</label>
                                        <div class="col-sm-7">
                                            <input type="tel" class="form-control" id="regMobileno" placeholder="e.g +92 321 XXXX XXX">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="inputEmail3" class="col-sm-4 control-label">Captcha</label>
                                        <div class="col-sm-7">
                                            <img style="width: 100px;height: 50px" src="<?php echo $_SESSION['captcha']['image_src']; ?>" alt="CAPTCHA code">
                                            <input style="width: 80px; text-align: center" id="captcha" type="text" id="captcha" name="captcha" maxlength="5" />
                                            <?php //echo $_SESSION['captcha']['code']; ?>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-sm-offset-4 col-sm-7">
                                            <a id="signUp" class="btn btn-success btn-toolbar">Register</a>
                                        </div>
                                    </div>



                                </form>
                            </div>
                        </div>

                    </div>



                </div>
            </div>

        </div>


        <div id='footer' style="height: 50px; background: #FFF;width: 100% !important; border-top: solid 2px #285e8e;" class="nav navbar-fixed-bottom">

            <div class='container-non-responsive' style="margin-top: 15px;">
                <div class="row">
                    <div class="col-xs-4"> </div>
                    <div class="col-xs-4">All rights reserved. 2013 (c) City Deals.</div>
                    <div class="col-xs-4"> </div>
                </div>
            </div>
        </div>




        <div class="modal fade" id="signupSuccessModal" style="margin-top: 10%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Confirm Registration</h4>
                    </div>
                    <div id="signUpMsg" class="modal-body">
                        <p class="alert alert-success" style="margin-bottom: 0px;">A verification link has been sent at your email address. Kindly check your inbox to activate the account.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">OK</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="forgotPasswordModal" style="margin-top: 10%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Kindly provide the email address you signed up with</h4>
                    </div>
                    <div id="signUpMsg" class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Email</label>
                                <div class="col-sm-7">
                                    <input type="email" class="form-control" id="forgotEmail" placeholder="abc@xyz.com">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="forgotPasswordModalbtn">OK</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </body>
</html>