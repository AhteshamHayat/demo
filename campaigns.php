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
	
	if (empty($_REQUEST['outlet'])) {
        $outlet = 0;
    } else {
        $outlet = $_REQUEST['outlet'];
    }

    if (empty($_REQUEST['active'])) {
        $active = "flase";
    } else {
        $active = $_REQUEST['active'];
    }

}

if (empty($_REQUEST['sDate'])) {
    $sDate = "";
} else {
    $sDate = $_REQUEST['sDate'];
}


if (empty($_REQUEST['eDate'])) {
    $eDate = "";
} else {
    $eDate = $_REQUEST['eDate'];
}


function customError($errno, $errstr) {
    
}

set_error_handler("customError");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Campaigns - City Deals</title>
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
                margin-bottom: 0px;
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
                border: 1px solid #39b3b7;
                border-radius: 5px;
                box-shadow: 5px 5px 5px #999;
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
            var eindex;
			function deleteEntryModal(index,id){
                
                gindex = index;
                gid = id;
                $("#deleteCampaignModal").modal('show');
            }
            
			function editEntryModal(index,id){
				eindex = index;
				$("#editCampaignModal").modal('show');
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
                    window.location.replace("campaigns.php?page="+pageNo);
                });

            }
            
            function editEntry(){
				
				var campaignEDate = $("#campaignEDate").val();
				var campaignSDate = $("#campaignSDate").val();
				var coupons = $("#coupons").val();
				var pageNo = Number($("#pageNo").val());
				//alert(eindex + " : " + campaignEDate + " : " + campaignSDate + " : " + coupons);
				
				$.post("editCampaign.php",
                {
                    id : eindex,
                    sDate : campaignSDate,
					eDate : campaignEDate,
					coupons : coupons
                },
                function(data,status){
                    if (data == 1){
						window.location.replace("campaigns.php?page="+pageNo);
					}
                });
            }
            
            $(function(){
                var lastPage = Number($("#lastPage").val());
                $("#paginationGo").click(function(){
					
                    var pageNo = Number($("#pageNo").val());
                    var outlet = $("#outlet").val();
					var sDate = $("#sDate").val();
					var eDate = $("#eDate").val();
					var active = $("#activeCbox").is(":checked");
					if(pageNo > lastPage){pageNo=lastPage;}
                    window.location.replace("campaigns.php?page="+pageNo+"&outlet="+outlet+"&sDate="+sDate+"&eDate="+eDate+"&active="+active);
                });
            });
			
			function filterResults(){
				var pageNo = Number($("#pageNo").val());
				var outlet = $("#outlet").val();
				var sDate = $("#sDate").val();
				var eDate = $("#eDate").val();
				var active = $("#activeCbox").is(":checked");
				//alert(outlet + " : " + sDate + " : " + eDate + " : " + active);
				window.location.replace("campaigns.php?page="+pageNo+"&outlet="+outlet+"&sDate="+sDate+"&eDate="+eDate+"&active="+active);
				
			}
			
			function clearFilter(){
				window.location.replace("campaigns.php?page="+1);
			}
        </script>
		
        <script>
            $(function(){
                $('.datetimepicker').datetimepicker();

            });
            
            
        </script>
        

    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">
        
		<?php include 'header.php' ?>

        <div id='content' class='container-non-responsive'>
            <div class='row'>
                
				<?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("campaigns").className = "active";
                </script>

                <div class="col-xs-9" >

                    <div class='row'>
                        <div class='panel panel-primary' style='color:#444 ;background: #FFF; padding-left: 20px;padding-right: 20px; border-color: #FFF;border-radius: 4px; min-height: 350px;'>
                            <h2 class="panel-heading" style='margin-top: 10px;margin-bottom: 5px;height: 50px;'>
                                Campaigns
                            </h2>
                            
                            <div class='row' style="margin-bottom: 20px;">
                                <span style="float: left;margin-left: 20px; margin-top: 5px;">Filter Campaigns:</span>
                                <select id="outlet" class="form-control input-sm" style="width: 170px; margin-left: 20px; float: left;">
                                    <?php
                                    if ($outlet == "All") {
                                        echo '<option value="All" selected="true">All Outlets</option>';
                                    } else {
                                        echo '<option value="All">All Outlets</option>';
                                    }
                                    ?>
                                                                            
                                    <?php
                                    $tbl_name = "outlets";
                                    $query = "SELECT * FROM $tbl_name where MechantId=$uid and IsDeleted=0 order by OutletName";
                                    $result = mysqli_query($con, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        if ($outlet == $row['OutletId']) {
                                            echo '<OPTION VALUE="' . $row['OutletId'] . '" selected="true">' . $row['OutletName'] . ' , ' . $row['OutletAddress'] . '</OPTION>';
                                        } else {
                                            echo '<OPTION VALUE="' . $row['OutletId'] . '" >' . $row['OutletName'] . ' , ' . $row['OutletAddress'] . '</OPTION>';
                                        }
                                    }
                                    ?>
                                </select>
                                <input id="sDate" type="text" class="form-control input-sm datetimepicker" style="width: 150px; float: left;" placeholder="Start Time" value="<?php echo $sDate;?>">
                                <input id="eDate" type="text" class="form-control input-sm datetimepicker" style="width: 150px; float: left;" placeholder="End Time" value="<?php echo $eDate;?>">
                                <div style="width: 90px; height: 30px; float: left;margin-top: 3px;margin-left: 5px; font-size: 12px;" >
								<?php
									if($active == "true"){
										echo '<input id="activeCbox" type="checkbox" checked="true"> Active Only </div>';
									}else{
										echo '<input id="activeCbox" type="checkbox" > Active Only </div>';
									}
								?>
								
                                <button type="button" class="btn btn-info btn-sm" style="float: left; margin-left: 10px;" onclick="filterResults()">Filter</button>
                                <button type="button" class="btn btn-default btn-sm" style="float: left; margin-left: 5px;" onclick="clearFilter()">Clear</button>
                            </div>
                            <hr class='hr-strike'>
                            
							<?php include 'listCampaigns.php';?>
							
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
		
		<?php include 'rechargeModal.php' ?>        
        <?php include 'QRCodeModal.php' ?>
		
        <div class="modal fade" id="deleteCampaignModal" style='margin-top: 10%;'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #d43f3a; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Delete Outlet?</h4>
                    </div>
                    <div class="modal-body">
                        <h3>Are you sure you want to delete this campaign?</h3>
                        <h4>You will not be able to undo this action.</h4>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-danger" onclick="deleteEntry()">Delete Campaign</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        
        <div class="modal fade" id="editCampaignModal" style='margin-top: 10%;'>
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Campaign</h4>
                    </div>
                    <div class="modal-body">

                        <form class="form-horizontal" role="form">
                            <div class="form-group">
                                <label for="campaignSDate" class="col-sm-4 control-label">Start Time</label>
                                <div class="col-sm-5">
                                    <div class="input-group date datetimepicker"> 
                                        <input type="text" id="campaignSDate" name="campaignSDate" class="form-control dtformat" /> 
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>                                
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="campaignEDate" class="col-sm-4 control-label">End Time</label>
                                <div class="col-sm-5">
                                    <div class="input-group date datetimepicker"> 
                                        <input type="text" id="campaignEDate" name="campaignEDate" class="form-control dtformat" /> 
                                        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar"></span></span>
                                    </div>                                
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="coupons" class="col-sm-4 control-label">Number of Coupons</label>
                                <div class="col-sm-5">
                                        <input type="number" id="coupons" name="coupons" class="form-control" /> 
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-4 control-label">Change in bill: </label>
                                <div class="col-sm-5">
                                    <input style="background: #2c9ab7; color: #fff;" type="text" class="form-control" value=" + $ 0.00"  disabled/> 
                                </div>
                            </div>
                            
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                                <a type="submit" class="btn btn-success" onclick="editEntry()">Commit Changes</a>
                            </div>
                </form>

                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </body>
</html>