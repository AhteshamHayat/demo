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
	
	if (empty($_REQUEST['sDate'])) {
		// sDate
		$sres = mysqli_query($con,"SELECT * FROM balancesheet where MerchantId=$uid order by Time asc limit 1;");
		$srow = mysqli_fetch_array($sres);
		$sDate = $srow['Time'];
	} else {
		$sDate = $_REQUEST['sDate'];
	}

	if (empty($_REQUEST['eDate'])) {
		// eDate
		$eres = mysqli_query($con,"SELECT * FROM balancesheet where MerchantId=$uid order by Time desc limit 1;");
		$erow = mysqli_fetch_array($eres);
		$eDate = $erow['Time'];
	} else {
		$eDate = $_REQUEST['eDate'];
	}
	
}

function customError($errno, $errstr) {
    
}

set_error_handler("customError");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Payments - City Deals</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">       
        <script src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/moment.js"></script>
        <link href="http://eonasdan.github.io/bootstrap-datetimepicker/styles/bootstrap-datetimepicker.min.css" rel="stylesheet">
        <script src="http://eonasdan.github.io/bootstrap-datetimepicker/scripts/bootstrap-datetimepicker.js"></script>


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
            var today = new Date();
            $(document).ready(function() {
			
				var sDate = "<?php echo $sDate;?>";
                var eDate = "<?php echo $eDate;?>";
					
                $('#datetimepickerSt').datetimepicker({
                    defaultDate: sDate,
                    pick12HourFormat: false
                });

                $('#datetimepickerEd').datetimepicker({
                    defaultDate: eDate,
                    pick12HourFormat: false
                });
            });
        </script>
		
		<script>
            $(function(){
                var lastPage = Number($("#lastPage").val());
				var sDate = $("#sDate").val();
				var eDate = $("#eDate").val();
                $("#paginationGo").click(function(){
                    var pageNo = Number($("#pageNo").val());
                    if(pageNo > lastPage){pageNo=lastPage;}
                    window.location.replace("payments.php?page="+pageNo+"&sDate="+sDate+"&eDate="+eDate);
                });
                
                $("#dateSubmit").click(function(){
                    var sDate = $("#sDate").val();
					var eDate = $("#eDate").val();
					window.location.replace("payments.php?page="+1+"&sDate="+sDate+"&eDate="+eDate);
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
                    document.getElementById("payments").className = "active";
                </script>

                <div class="col-xs-9" >
                    <!--<input id="datetimepicker" style="width:200px;" />-->

                    <div class='row'>
                        <div class='panel panel-primary' style='color:#444 ;background: #FFF; padding-left: 20px;padding-right: 20px; border-color: #FFF;border-radius: 4px;
                             min-height: 350px;margin-bottom: 80px;'>
                            
                            
                            <h2 class="panel-heading" style='height: 65px;'><span style="top: 10px;">Payment History</span>

                                <form class="form-inline" role="form" style="width:500px;display: table; float: right;" >

                                    <div style="font-size: 10pt;width: 200px;display: table-cell;position: absolute;float: left; ">
                                        <!--<input type="datetime-local" id="datetimepickerSt" style="width:190px; font-size: 10pt" />-->

                                        <span>Start Time:</span>
                                        <div class='input-group date' id='datetimepickerSt' style="margin-left: 3px ">
                                            <input type='text' id="sDate" class="form-control" style="width: 160px;font-size: 10pt" />
                                            <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar" ></span>
                                            </span>
                                        </div>
                                    </div>

                                    <div style="font-size: 10pt;display: table-cell;position: static;width: 290px;float: right;">   
                                        <!--<div style="display: table; float: left;background-color: yellow">-->

                                        <div style="font-size: 10pt;width: 200px;display: table-cell;position: relative;float: left; ">
                                            <span>End Time:</span>
                                            <div class='input-group date' id='datetimepickerEd' style="margin-left: 3px ">
                                                <input type='text' id="eDate" class="form-control" style="width: 160px;font-size: 10pt" />
                                                <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar" ></span>
                                                </span>
                                                <a id="dateSubmit" type="button" class="btn btn-default input-sm" style="margin-left: 5px;">Submit</a> 
                                            </div>
                                            
                                        </div>
                                    </div>

                                </form>
                               </h2>

                            
                            <table class="table table-hover">
                                <thead style="background-color: #f5f5f5">
                                    <tr>
                                        <th>Outlet&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</th>
                                        <th>Debit&nbsp;($)</th>
                                        <th>Credit&nbsp;($)</th>
                                        <th>Balance&nbsp;($)</th>
                                        <th>Description</th>
                                        <th>Time&nbsp;&nbsp;&nbsp;</th>
                                    </tr>
                                </thead>
                                <tbody id="dataTable">
                                    <?php
                                    include 'ListPayments.php';
                                    ?>
                                </tbody>
                            </table>
                            
							<!-- Pagination Stuff -->
                            <div id="pagination" class='row' style='margin-top: 30px; margin-bottom: 10px;'>
                                <div class='col-xs-4 col-xs-offset-4'>
                                    <span class='pull-left' style='margin-top: 5px;'>Page </span>
                                    <input type="text" maxlength="3" style='text-align: center;width: 60px; margin-left: 5px; margin-right: 10px;' class="form-control pull-left input-sm" id="pageNo" value="<?php if($lastpage == 0){$page=0;} echo $page; ?>">
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
		
		<?php include 'rechargeModal.php' ?>        
        <?php include 'QRCodeModal.php' ?> 


    </body>
</html>

<?php
mysqli_close($con);
?>