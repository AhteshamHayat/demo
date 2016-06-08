<?php
session_start();
if ($_SESSION['loggedIn'] != 1) {
    header('Location: signup.php');
} else {
    include 'DBConfig.php';
    $uid = $_SESSION['userId'];
    
    $result1 = mysqli_query($con, "select * from outlets where MechantId=".$uid);
    $count = mysqli_num_rows($result1);
    if($count == 0){
        header('Location: outlets0.php');
    }
    
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
        <title>Outlets - City Deals</title>
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

            .logo{
                width: 100px;
                height: 100px;
                box-shadow: 5px 5px 5px #888;
                border: 1px solid #39B3D7;
                border-radius: 5px;

            }


            .hr-strike {
                height: 1px;
                background-color: #e0e0e0;
                margin-top: 10px;
                margin-bottom: 10px;
            }

            .outlet-name {
                margin-top: 0px;
                color:#2c9ab7;
                font-size: 24px;
            }

            .coupon-count{
                margin-top: 0px;
                color:#666;
                font-weight: bold;
                font-size: 24px;
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
            var gindex;
            var gid;
            function deleteEntryModal(index,id,name){
                
                gindex = index;
                gid = id;
                $("#outletName").text(name);
                $("#deleteOutletModal").modal('show');
            }
            
            function deleteEntry(){
                // > index 1: outlets
                // > index 2: coupons
                $.post("DeleteEntries.php",
                {
                    index:gindex,
                    id:gid
                },
                function(data,status){
                    var pageNo = Number($("#pageNo").val());
                    window.location.replace("outlets.php?page="+pageNo);
                });

            }
            
            function viewEntry(index,id){
                $.post("ViewOutlet.php",
                {
                    index:index
                },
                function(data,status){
                    $("#ViewModalDiv").html(data);
                    $("#ViewModal").modal('show');
                });
            }
            
            function editEntry(index,id){
                window.location.replace("editOutletForm.php?index="+index);
            }
            
            $(function(){
                var lastPage = Number($("#lastPage").val());
                $("#paginationGo").click(function(){
                    var pageNo = Number($("#pageNo").val());
                    if(pageNo > lastPage){pageNo=lastPage;}
                    window.location.replace("outlets.php?page="+pageNo);
                });
            });
        </script>
    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">
        <?php include 'header.php' ?>

        <div id='content' class='container-non-responsive'>
            <div class='row'>
                
                <?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("outlets").className = "active";
                </script>

                <div class="col-xs-9" >

                    <div class='row'>
                        <div class='panel panel-primary' style='color:#444 ;background: #FFF; padding-left: 20px;padding-right: 20px; border-color: #FFF;border-radius: 4px; min-height: 350px;'>
                            <h2 class="panel-heading" style='margin-top: 10px;margin-bottom: 30px;'>
                                Outlets <a type="button" class="btn btn-default" style="float: right" href="addOutletForm.php">Add New Outlet</a>
                            </h2>

                            <hr class='hr-strike'>

                            <?php include 'listOutlets.php'; ?>

                            <!-- Pagination Stuff -->
                            <div class='row' style='margin-top: 30px; margin-bottom: 10px;'>
                                <div class='col-xs-4 col-xs-offset-4'>
                                    <span class='pull-left' style='margin-top: 5px;'>Page </span>
                                    <input type="text" maxlength="3" style='text-align: center;width: 60px; margin-left: 5px; margin-right: 10px;' class="form-control pull-left input-sm" id="pageNo" value="<?php echo $page; ?>">
                                    <span class='pull-left' style='margin-top: 5px; margin-right: 10px;'> of <?php echo $lastpage; ?></span>
                                    <button id="paginationGo" class='btn btn-sm btn-default'>Go</button>
                                    <input id="lastPage" type="hidden" value="<?php echo $lastpage; ?>"/>
                                </div>
                            </div>                                
                            <!-- Pagination over -->


                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div style='padding-top: 60px;'>
            <div id='footer' style="height: 50px; background: #FFF;width: 100% !important; border-top: solid 2px #285e8e;" class="nav navbar-fixed-bottom">

                <div class='container-non-responsive' style="margin-top: -2px;">
                    <div class="row">
                        <div class="col-xs-5"> </div>
                        <div class="col-xs-2">
                            <div class='row'>
                                <div class='col-xs-4 social-icon' ><i class="fa fa-facebook-square"></i></div>
                                <div class='col-xs-4 social-icon' ><i class="fa fa-twitter-square"></i> </div>
                                <div class='col-xs-4 social-icon' ><i class="fa fa-google-plus-square"></i> </div>
                            </div>

                        </div>
                        <div class="col-xs-5"> </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal fade" id="deleteOutletModal" style='margin-top: 10%;'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #d43f3a; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Outlet?</h4>
                    </div>
                    <div class="modal-body">
                        <h3>Are you sure you want to delete "<strong id="outletName">123</strong>"?</h3>
                        <h4>You will not be able to undo this action.</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteEntry()">Delete Outlet</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <?php include 'rechargeModal.php' ?>        
        <?php include 'QRCodeModal.php' ?>

    </body>
</html>
<?php
mysqli_close($con);
?>