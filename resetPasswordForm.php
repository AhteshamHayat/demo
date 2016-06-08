<?php
$email = $_REQUEST['email'];
$code = $_REQUEST['code'];
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

        <script>
            
            $(function(){
                    
        $("#forgotPasswordModalbtn").click(function(){
            var email = $("#email").val();
            var code = $("#code").val();
            var password = $("#regPassword").val();
            
            $.post("resetPassword.php",
            {
                email:email,
                code: code,
                password: password
            },
            function(data,status){
                
                if(data == "0"){
                    window.location.replace('outlets0.php');
                }else{
                    window.location.replace('outlets.php');
                }
                
            });
            
        });

                $("#forgotPasswordModal").modal('show');
            });
        </script>


    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">

        <div id='header' style="height: 100px; width: 100%; background: url(img/bg_black.png) repeat-x; ">
            <div class='container-non-responsive'>
                <div class='row'>
                    <div id="logo" class="col-xs-4" style="padding-top: 15px; font-size: 32px; color: #FFFFFF; font-family: 'Euphoria Script', sans-serif;">
                        City Deals

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

        <input type="hidden" id="email" value="<?php echo $email;?>">
        <input type="hidden" id="code" value="<?php echo $code;?>">
        <div class="modal fade in" id="forgotPasswordModal" style="margin-top: 10%">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <!--<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>-->
                        <h4 class="modal-title">Reset Password</h4>
                    </div>
                    <div id="signUpMsg" class="modal-body">
                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="regPassword" class="col-sm-4 control-label">New Password</label>
                                <div class="col-sm-7">
                                    <input type="password" id="regPassword" name="regPassword" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="regCPassword" class="col-sm-4 control-label">Confirm Password</label>
                                <div class="col-sm-7">
                                    <input type="password" id="regCPassword" name="regCPassword" class="form-control">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" id="forgotPasswordModalbtn">Reset</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

    </body>
</html>