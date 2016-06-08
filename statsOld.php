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
        <title>Stats - City Deals</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <link href="css/bootstrap.min.css" rel="stylesheet">

        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">        

<!--<script src="js/chart.js"></script>-->
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


            .k-widget .k-state-selected,
            .k-list .k-state-selected
            { 
                background: dodgerblue;
            }

            .k-widget,
            .k-list 
            { 
                background: #f3f3f3;
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
                $.post("genderStats.php", {index:uid}, function(data,status){
                    genderChart(data);
                });
            }
                
            function genderChart(genderResults){
                
                var male = genderResults['m'];
                var female = genderResults['f'];
                $('#container').highcharts({
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
                                return (Math.abs(this.value) / 1000) + 'K';
                            }
                        },
                        min: -50000,
                        max: 50000
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
                            data: [male['1']*(-1000), male['2']*(-1000), male['3']*(-1000), male['4']*(-1000), male['5']*(-1000), male['6']*(-1000), male['7']*(-1000)]
                            //                 color: '#228b22'

                        }, {
                            name: 'Female',
                            data: [female['1']*1000, female['2']*1000, female['3']*1000, female['4']*1000, female['5']*1000, female['6']*1000, female['7']*1000]
                            //                color:'#182828'
                        }]
                });
            }
            
            function timeChart(){
                $('#container2').highcharts({
                    chart: {
                        type: 'column'
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
                            name: 'Coupons Pushed',
                            pointInterval: 24 * 3600 * 1000,
                            pointStart: Date.UTC(2013, 01, 01),
                            data: [1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179]
                        }, {
                            name: 'Coupons Availed',
                            pointInterval: 24 * 3600 * 1000,
                            pointStart: Date.UTC(2013, 01, 01),
                            data: [1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179, 1746181, 1884428, 2089758, 2222362, 2537431, 2507081, 2443179]
                        }]

                });
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
                            <h2 class="panel-heading" style=''>Statistics
                                <!--width:485px; display: table; float: right;-->
                                <form class="form-inline" role="form" style="width:475px; display: table; float: right;" >

                                    <div style="font-size: 10pt;width: 200px;display: table-cell;position: absolute;float: left;">
                                        <span> Start Date:</span>
                                        <input type="datetime-local" id="datetimepickerSt" style="width:190px; font-size: 10pt" />

                                    </div>

                                    <div style="font-size: 10pt;display: table-cell;position: relative;width: 200px;">   
                                        <div style="display: table; position: relative;width: 275px ">

                                            <div  style="width: 200px;margin-top: 0px;display: table-cell;position: relative;float: left">
                                                <span>End Date:</span>
                                                <input type="datetime-local" id="datetimepickerEd" style="width:190px; font-size: 10pt"  />

                                            </div>
                                            <div style="display: table-cell;position: relative;float:right;margin-top: 10px">
                                                <button type="submit" class="btn btn-default input-sm" >Submit</button> 
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </h2>                      

                            <div class='row'>
                                <div class="col-xs-12" >
                                    <br>
                                    <div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
                                    <br>
                                </div>
                            </div>
                            <div class='row'><div class='span12'>
                                    <hr>
                                </div>
                            </div>
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