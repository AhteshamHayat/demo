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

    if (empty($_REQUEST['outlet'])) {
        $outlet = 0;
    } else {
        $outlet = $_REQUEST['outlet'];
    }
}

function customError($errno, $errstr) {
    
}

set_error_handler("customError");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Stats - City Deals</title>
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
        <script src="js/highStockJS/highstock.js"></script>
        <script src="js/highStockJS/modules/exporting.js"></script>

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

            hr {

                border-width: 3px 0;
                margin: 18px 0;
            }

        </style>
        <script>

            var categories = ['13-17', '18-24',
                '25-34', '35-44', '45-54', '55-60', '60+'];
            
            function init(){
                var uid = <?php echo $uid; ?>;
                var outlet = $("#outlet").val();
                var campaign = $("#campaign").val();
                var sDate = $("#sDate").val();
                var eDate = $("#eDate").val();
                
                $.post("genderStats.php", {
                    index:uid,
                    outlet:outlet,
                    campaign:campaign,
                    sDate:sDate,
                    eDate:eDate
                }, function(data,status){
                    genderChart(data);
                    //timeChart();
                });
                $.post("couponStats.php", {
                    index:uid,
                    outlet:outlet,
                    campaign:campaign,
                    sDate:sDate,
                    eDate:eDate
                }, function(data,status){
                    //genderChart(data);
                    //                    alert(data);
                    timeChart(data);
                });
            }
                
            function genderChart(genderResults){
                
                var male = genderResults['m'];
                var female = genderResults['f'];
                $('#container2').highcharts({
                    chart: {
                        type: 'bar'
                    },
                    title: {
                        text: 'Coupon Transactions'
                    },
                    subtitle: {
                        text: 'Customer Based'
                    },
                    xAxis: [{
                            categories: categories,
                            reversed: false
                        }, {// mirror axis on right side
                            opposite: true,
                            reversed: false,
                            categories: categories,
                            linkedTo: 0
                        }],
                    yAxis: {
                        title: {
                            text: null
                        },
                        labels: {
                            formatter: function() {
                                return (Math.abs(this.value));
                            }
                        }
                        //min: -50000,
                        //max: 50000
                    },
                    plotOptions: {
                        series: {
                            stacking: 'normal'
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>' + this.series.name + ', Age ' + this.point.category + '</b><br/>' +
                                'Coupons Availed: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                        }
                    },
                    series: [{
                            name: 'Male',
                            data: [male['1']*(-1), male['2']*(-1), male['3']*(-1), male['4']*(-1), male['5']*(-1), male['6']*(-1), male['7']*(-1)]
                            //                 color: '#228b22'

                        }, {
                            name: 'Female',
                            data: [female['1']*1, female['2']*1, female['3']*1, female['4']*1, female['5']*1, female['6']*1, female['7']*1]
                            //                color:'#182828'
                        }]
                });
            }
            
            function timeChart(availedResults){
                var data = availedResults["data"];
                var count = availedResults["count"];
                var date = availedResults["date"];
                var dataArray = new Array();
                //                alert(availedResults["31"]);
                for(var i=0;i<count;i++){
                    dataArray[i] = data[(i+1)+""];
                }
                $('#container').highcharts({
                    chart: {
                        //                        type: 'column'
                        type: 'area'
                    },
                    title: {
                        text: 'Coupon Transactions'
                    },
                    subtitle: {
                        text: 'Time Based'
                    },
                    xAxis: {
                        type: 'datetime',
                        tickInterval: 24 * 3600 * 1000
                    },
                    yAxis: {
                        title: {
                            text: null
                        }
                    },
                    tooltip: {
                        formatter: function() {
                            return '<b>' + this.series.name + '</b><br/>' + Highcharts.dateFormat('%e. %b', this.x) + ': ' + this.y;
                        }
                    },
                    series: [{
                            name: 'Coupons Availed',
                            pointInterval: 24 * 3600 * 1000,
                            pointStart: date*1000,
                            data: dataArray//[1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758]
                        }]

                });
            }
            
            var today = new Date();
            $(document).ready(function() {

                $('#datetimepickerSt').datetimepicker({
                    //                    defaultDate: new Date(today.getTime() - 30 * 24 * 60 * 60 * 1000),
                    pick12HourFormat: false
                });

                $('#datetimepickerEd').datetimepicker({
                    //                    defaultDate: new Date(),
                    pick12HourFormat: false
                });
                
                $('#outlet').change(function(){
                    //                    alert($('#outlet').val());
                    var outletId = $('#outlet').val();
                    $.post("FindCampaignsByOutletId.php", {outletId:outletId}, function(data,status){
                        var campaign = document.getElementById("campaign");
                        campaign.length = 0;
                        var outlets = data.split(";");
                        if(outlets.length == 0){
                            campaign.options[0] = new Option("No Campaigns","nill");
                        }else{
                            var values;
                            campaign.options[0] = new Option("All Campaigns","All");
                            for(var i=1;i<outlets.length;i++){
                                values = outlets[i-1].split("^");
                                campaign.options[i] = new Option(values[1],values[0]);
                            }
                            campaign.disabled = false;
                        }
                        
                    });
                });
                
                $("#submitBtn").click(function(){
                    
//                    var parameters="";
//                    var outlet = $("#outlet").val();
//                    var campaign = $("#campaign").val();
//                    var sDate = $("#sDate").val();
//                    var eDate = $("#eDate").val();
                    
//                    if(outlet != "All"){parameters += "outlet="+outlet+"&";}
//                    if(campaign != "All"){parameters += "campaign="+campaign+"&";}
//                    if(sDate != ""){parameters += "sDate="+sDate+"&";}
//                    if(eDate != ""){parameters += "eDate="+eDate+"&";}
                    
//                    console.log(parameters);
                    init();
//                    alert(parameters);
                    
                    //                    window.location.replace("stats.php?"+parameters);
                    
                });
            });

            function check() {
                document.getElementById("btnCampaign").className =
                    document.getElementById("btnCampaign").className.replace
                (/(?:^|\s)disabled(?!\S)/g, '');
                document.getElementById("btnCampaign2").className =
                    document.getElementById("btnCampaign2").className.replace
                (/(?:^|\s)disabled(?!\S)/g, '');
            }
        </script>

    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;" onload="init()">

        <?php include 'header.php' ?>

        <div id='content' class='container-non-responsive'>
            <div class='row'>

                <?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("stats").className = "active";
                </script>

                <div class="col-xs-9" >

                    <div class='row'>
                        <div class='panel panel-primary' style='color:#444 ;background: #FFF; padding-left: 20px;padding-right: 20px; border-color: #FFF;border-radius: 4px;
                             min-height: 350px;margin-bottom: 80px;'>
                            <h2 class="panel-heading" style='height: 50px'>Statistics                           
                            </h2>    
                            <div class="row">
                                <div class="col-xs-12">
                                    <!--<form class="form-inline" style="display: table;position: relative; margin-top: 7px" >-->

                                    <div style="font-size: 10pt;display: table-cell;position: relative;float: left">   
                                        <div class="btn-group" style="margin-top:0px">
                                            <!--                                                <button type="button" class=" btn btn-warning" style="width: 90px;height: 28px;text-align: left;padding-left: 2px">All Outlets</button>
                                                                                            <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" style="height: 28px">
                                                                                                <span class="caret"></span>
                                                                                                <span class="sr-only"></span>
                                                                                            </button>
                                                                                            <ul class="dropdown-menu " role="menu" style="min-width: 90px" onclick="check();">
                                                                                                <li><a href="#">All<br></a></li>
                                                                                                <li class="divider"></li>
                                                                                                <li><a href="#">Outlet 1<br><span style="font-size: 8pt">Address of Outlet 1</span></a></li>
                                                                                                <li class="divider"></li>
                                                                                                <li><a href="#">Outlet 2<br><span style="font-size: 8pt">Address of Outlet 2</span></a></li>
                                                                                                <li class="divider"></li>
                                                                                                <li><a href="#">Outlet 3<br><span style="font-size: 8pt">Address of Outlet 3</span></a></li>
                                                                                            </ul>-->

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
                                        </div>
                                        <div class="btn-group" >
                                            <!--                                            <button id="btnCampaign" type="button" class="btn btn-info disabled" style="width: 106px;height: 28px;text-align: left;padding-left: 2px;">All Campaigns</button>
                                                                                        <button id="btnCampaign2" type="button" class="btn btn-info dropdown-toggle disabled" data-toggle="dropdown" style="height: 28px" >
                                                                                            <span class="caret"></span>
                                                                                            <span class="sr-only"></span>
                                                                                        </button>
                                                                                        <ul class="dropdown-menu" role="menu" style="min-width: 100px" >
                                                                                            <li><a href="#">All<br></a></li>
                                                                                            <li class="divider"></li>
                                                                                            <li><a href="#">Campaign 1<br><span style="font-size: 8pt">Campaign 1 deal information</span></a></li>
                                                                                            <li class="divider"></li>
                                                                                            <li><a href="#">Campaign 2<br><span style="font-size: 8pt">Campaign 1 deal information</span></a></li>
                                                                                            <li class="divider"></li>
                                                                                            <li><a href="#">Campaign 3<br><span style="font-size: 8pt">Campaign 1 deal information Campaign 1 deal information</span></a></li>
                                                                                        </ul>-->

                                            <select id="campaign" class="form-control input-sm" style="width: 170px; margin-left: 20px; float: left;" disabled="true">
                                                <option value="All">All Campaigns</option>
                                            </select>
                                        </div>

                                    </div>
                                    <div style="display: table-cell;position: relative;float: right">

                                        <div style="display: table;position: relative">
                                            <div style="display:table-cell;position: relative;float: left">
                                                <div class='input-group date' id='datetimepickerSt' style="height: 28px;margin-left: 3px ">
                                                    <input type='text' id="sDate" class="form-control" style="width: 136px;height: 30px;font-size: 10pt" placeholder="Start Time"/>
                                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>

                                                <!--<input type="datetime-local" id="datetimepickerSt" style="width:200px;height: 28px; font-size: 10pt;border-radius: 5px 5px 5px 5px" />-->
                                            <div style="display: table-cell;position: relative;float: right;"> 
                                                <div class='input-group date' id='datetimepickerEd' style="height: 28px; margin-left: 3px">
                                                    <input type='text' id="eDate" class="form-control" style="width: 136px;height: 30px;font-size: 10pt" placeholder="End Time"/>
                                                    <span class="input-group-addon" ><span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                    <button type="submit" id="submitBtn" class="btn btn-primary input-sm" style="height: 26px;padding-top: 3px;margin-left: 3px;" >Submit</button> 
                                                </div>
                                            </div>                                              
                                        </div>
                                        </form>
                                    </div>
                                </div>
                                <!--horizontal grey seperator   -->
                                <hr>
                                <div class='row'>
                                    <div class="col-xs-12" >

                                        <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                                        <br>
                                    </div>
                                </div>
                                <!--horizontal grey seperator   -->
                                <hr>
                                <div class='row'>
                                    <div class="col-xs-12" >
                                        <br><div id="container2" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                                        <br>
                                    </div>
                                </div>
                                <br>
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