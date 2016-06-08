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
        <title>New Campaign</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">        


        <link href="css/bootstrap-timepicker.min.css" rel="stylesheet">        
        <script src="js/bootstrap-timepicker.min.js"></script>

        <link href="css/select2.css" rel="stylesheet">        
        <script src="js/select2.js"></script>

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

            .dtformat{
                font-size: 10px;
            }

            .separator{
                background: #ddd; 

                padding: 10px;
                border-color: #ddd;
                border-radius: 2px;

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

            td, tr, th{
                vertical-align: middle;
                border-bottom: 1px solid #ddd;
                padding:5px;
            }




        </style>

        <script>

            function deleteRow(rowid)  {   
                rowid = "row"+rowid;
                //                alert(rowid);
                var row = document.getElementById(rowid);
                //                console.log(row);
                row.parentNode.removeChild(row);
            }

            function insRow(outletName,outletId){
                //alert(outletName + " : " + outletId);
        
                var count = 1;
                var html = "";
                html += '<tr id="row'+outletId+'"><td>'+outletName+'<input type="hidden" id="id'+outletId+'" value="'+outletId+'"/></td>';
                html += '<td><div class="input-group date datetimepicker"> \
        <input type="text" id="sd'+outletId+'" class="form-control dtformat input-sm" /> \
        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar">\
        </span></span></div></td>';
                html += '<td><div class="input-group date datetimepicker"> \
        <input type="text" id="ed'+outletId+'" class="form-control dtformat input-sm" /> \
        <span class="input-group-addon"><span class="glyphicon glyphicon-calendar">\
        </span></span></div></td>';
                html += '<td><input type="number" onkeyup="updateCouponCount(this);" id="coup'+outletId+'" class="form-control input-sm"></td></tr>';
                //      html += '<td><input type="button" onclick="deleteRow('+outletId+')" class="form-control input-sm"></td></tr>';
                
                $('#couponTable tr:last').after(html);
                
                $('.datetimepicker').datetimepicker({
                    startDate: $.now()
                });
                
                count ++;
                selectedids += outletId + ",";
            }

            function readTable() {
                var balance = Number(<?php echo $Currentbalance; ?>);
                try {
                    var cost = 0;
                    var cellVal = "";
                    var table = document.getElementById("couponTable");
                    var rowlength = table.rows.length;
                    for(var i=1;i<rowlength;i++){
                        var oCell = table.rows.item(i).cells;
                        var celllength = oCell.length;
                        
                        //                        cellVal += oCell.item(0).innerHTML;
                        for(var j=0;j<celllength;j++){
                            //                            cellVal += oCell.item(j).innerHTML + " :: ";
                            var html = oCell.item(j).innerHTML + "";
                            //	alert(html);
                            var id = html.split('id="')[1].split('"')[0];
                            //	alert(id);
                            //    if($('#'+id).val() == ""){
                            //        $('#tableInfo').text('  Please fill all the fields');
                            //        return false;
                            //    }else{
                            //        $('#tableInfo').text('');
                            //    }
                            //    var TAmount = $('#'+id).val();
                            if(j == 3){
                                cost = cost + Number($('#'+id).val());
                            }
                            cellVal += $('#'+id).val() + ";";
                        }
                        cellVal = cellVal.substring(0,cellVal.length-1);
                        cellVal += ",";
                        
                        //                        cellVal = "";
                    }
                    cellVal = cellVal.substring(0,cellVal.length-1);
                    //                    alert(cellVal);
                    cost = cost/10;
                    $('#cost').val(cost);
                    //                    $('#tokenAmount').html('<p>$ ' + cost + '</p>');
                    $('#outletsToken').val(cellVal);
                    if(cost > balance){
                        alert("cost exceeds balance !");
                        //                        $('#tableInfo').text('  Amount exceeds the balance');
                        //                        return false;
                    }
                    else{
                        document.getElementById("newCampaign").submit();
                        //                        $('#tableInfo').text('');
                        //                        return true;
                    }
                }catch(e) {
                    alert("id: " + id + " :alert: " + e);
                }
            }
        </script>
        <script>
            var jcrop = null;
            var coords = null;
            var newCampaigns = {};
            var outletName="";
            var outletId;
            var selectedids="";
            $(function() {
	
                $("#spendingBuyingSelect").change(function() {
                    if ($("#spendingBuyingSelect").val() == 'spending') {
                        $('#spendingFields').fadeIn();
                        $('#buyingFields').hide();
                    } else if ($("#spendingBuyingSelect").val() == 'buying') {
                        $('#spendingFields').hide();
                        $('#buyingFields').fadeIn();
                    }                    
                    updateDiscountOfferPreview();

                });


                $("#couponType").change(function() {
                    if ($("#couponType").val() == 'discountOffer') {
                        $('#discountOfferFields').fadeIn();
                        $('#buySomeGetSomeFields').hide();
                    } else if ($("#couponType").val() == 'buySomeGetSome') {
                        $('#discountOfferFields').hide();
                        $('#buySomeGetSomeFields').fadeIn();
                    }
                });
                
                

                $("#outletsSelect").change(function() {
                    $('#outletsSelect option:selected').each(function(ind, opt){
                        var x = $(opt).val();
                        if(newCampaigns[x]==undefined){
                            outletId = x;
                            outletName = $(opt).text();
                            newCampaigns[x] = {"outletID":x,
                                "outletNameAddress":$(opt).text(),
                                "couponQuantity":0,
                                "startTime":$.now(),
                                "endTime":$.now()
                            };
                            insRow(outletName,outletId);
                        }
                        
                    });
                    
                    $('#outletsSelect option:not(:selected)').each(function(ind, opt){
                        var x = $(opt).val();
                        
                        if(newCampaigns[x]!=undefined){
                            delete newCampaigns[x];
                            deleteRow(x);
                        }
                        
                    });
                    /*
                    var html = '<table><thead style="background:cadetblue; vertical-align: middle; color:#FFF;"><tr style="height:30px; padding:5px;"><th style="width:170px;">Outlet</th><th>Offer Start time</th><th>Offer End time</th><th style="width:90px;">No of Coupons</th></tr></thead>';
                    $.each(newCampaigns, function(key, campaign){
                        html += '<tr><td>'+campaign["outletNameAddress"]+'</td>';
                        html += '<td><div class="input-group date datetimepicker"> \
                                <input type="text" class="form-control dtformat input-sm" /> \
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar">\
                                </span></span></div></td>';
                        html += '<td><div class="input-group date datetimepicker"> \
                                <input type="text" class="form-control dtformat input-sm" /> \
                                <span class="input-group-addon"><span class="glyphicon glyphicon-calendar">\
                                </span></span></div></td>';
                        html += '<td><input type="number" onchange="updateCouponCount(this);" class="form-control input-sm"></td></tr>';
                    });
                    
                    html +='</table>';
                     */
                                            //$('#newCampaignsTable').html(html);
                    
                                            //alert(outletName + " : " + outletId)
                                            
                                            $('.datetimepicker').datetimepicker({
                                                startDate: $.now()
                                            });
                    
                                            if(Object.keys(newCampaigns).length>0){
                                                $('#outletsGroup').fadeIn();
                                            }else{
                                                $('#outletsGroup').hide();                        
                                            }

                                        });



                                        $('#spendingFields').hide();
                                        $('#buySomeGetSomeFields').hide();
                                        $('#outletsGroup').hide();
                                        $("#outletsSelect").select2();
                
                
                
                                    });
            
            
                                    function updateBuySomeGetSomePreview(){
                                        var buywhat = $('#buyWhat').val();
                                        var getwhat = $('#getWhat').val();
                                        if(buywhat.length<1){
                                            buywhat = "something";
                                        }
                                        if(getwhat.length<1){
                                            getwhat = "something";
                                        }
                
                                        var offer = "Buy " + buywhat +" and get " + getwhat + " free.";
                                        $("#buySomeGetSomeOfferPreview").html(offer);
                                        $("#deal").val(offer);

                                    }

                                    function updateDiscountOfferPreview(){
                                        var percentage = $('#percentage').val();
                                        var discountMode = $('#spendingBuyingSelect').val();
                
                                        var offer = percentage+"% off on ";
                
                                        if(discountMode=='buying'){
                                            var products = $('#discountProducts').val();
                                            if(products.length<1){
                                                products = "all products";
                                            }
                                            offer += products;
                    
                                        }else if(discountMode=='spending'){
                                            var currency = $('#currency').val();
                                            var amount =  $('#spendingAmount').val();
                                            offer += "spending "+currency+" "+amount;
                                        }
                
                                        $("#discountOfferPreview").html(offer);
                                        $("#deal").val(offer);
                
                
                                    }
			
                                    function updateCouponCount(input){
                                        var coupons = 0;
                                        var values = selectedids.split(",");
                                        for(var i=0;i<values.length-1;i++){
                                            coupons += Number($("#coup"+values[i]).val());
                                        }
                                        coupons = coupons / 10;
                                        $("#campaignBill").html("Campaign Bill: $"+coupons);
                                    }
                                    
                                    function getTestId(){
                                        deleteRow($("#testId").val());
                                    }

        </script>

    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;">

        <?php include 'header.php'; ?>
        <div id='content' class='container-non-responsive'>
            <div class='row'>

                <?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("campaigns").className = "active";
                </script>

                <div class="col-xs-9">
                    <div class='row'>
                        <div class='panel panel-primary' style='background: #FFF; padding-left: 20px;padding-right: 20px; border-radius: 4px;'>
                            <h2 class="panel-heading">New Campaign</h2>
                            <form id="newCampaign" class="form-horizontal" action="addCampaign.php" method="post">
                                <div id="hiddenFields" style="display: none">
                                    <input id="deal" name="deal" type="text"/>
                                    <input id="cost" name="cost" type="text"/>
                                    <input id="outletsToken" name="outletsToken" type="text"/>
                                </div>
                                <h4 class="separator">Offer Details
                                </h4>


                                <div class="form-group">
                                    <label for="couponType" class="col-sm-3 control-label">Offer Type</label>
                                    <div class="col-xs-5">
                                        <select id="couponType" name="couponType" class="form-control">
                                            <option value="discountOffer">Discount Offer</option>
                                            <option value="buySomeGetSome">Buy something, Get something free</option>
                                        </select>
                                    </div>
                                </div>


                                <div class="form-group" id="discountOfferFields">
                                    <label for="inputEmail3" class="col-xs-3 control-label">What's the offer?</label>
                                    <div class='col-xs-9'>

                                        <span style='width: 60px; float: left;' >
                                            <input id="percentage" name="percentage" onkeyup="updateDiscountOfferPreview();" onchange="updateDiscountOfferPreview();" style='float: left;' type="number" class='form-control' min='0' max="100" value="0"></span>
                                        <span style='height:34px; background-color: #eee; border: 1px solid #ccc;float: left; font-weight: normal; padding-top: 5px; padding-left: 5px; padding-right: 5px;'> % off on </span>
                                        <span style='width: 115px; float: left;'>
                                            <select style="border-radius: 0px;" id='spendingBuyingSelect' name="spendingBuyingSelect" class="form-control">
                                                <option value="buying" selected>buying</option>
                                                <option value="spending">spending</option>
                                            </select>
                                        </span>

                                        <div id='spendingFields'>
                                            <span style='width: 80px; float: left; border-radius: 0px;'>
                                                <select id="currency" name="currency" onchange="updateDiscountOfferPreview();" class="form-control">
                                                    <option value="PKR">PKR</option>
                                                    <option value="USD">USD</option>
                                                </select>
                                            </span>

                                            <span style='width: 80px; float: left;' >
                                                <input id="spendingAmount" name="spendingAmount" onchange="updateDiscountOfferPreview();" onkeyup="updateDiscountOfferPreview();" style='float: left;' min='0' type="number" class='form-control' value="0">
                                            </span>
                                        </div>

                                        <div id='buyingFields'>
                                            <span style='width: 150px; float: left;' >
                                                <input id="discountProducts" name="discountProducts" onkeyup="updateDiscountOfferPreview();" style='float: left;' type="text" class='form-control' placeholder="e.g. all products">
                                            </span>
                                        </div>


                                    </div>
                                    <div class="col-xs-9 col-xs-offset-3" style="margin-top: 5px;">
                                        <span class="label label-default" style="background-color: #fff; color: #000;">Offer looks like: </span>
                                        <span id="discountOfferPreview" class="label label-info">0% off on all products</span>
                                    </div>
                                </div>


                                <div class="form-group" id="buySomeGetSomeFields">
                                    <label for="inputEmail3" class="col-xs-3 control-label">What's the offer?</label>
                                    <div class='col-xs-7'>
                                        <div class="input-group">
                                            <span class="input-group-addon">Buy </span>
                                            <input id="buyWhat" name="buyWhat" onkeyup="updateBuySomeGetSomePreview();" type="text" class="form-control" placeholder="e.g. 3 burgers">
                                            <span class="input-group-addon"> and get </span>
                                            <input id="getWhat" name="getWhat" onkeyup="updateBuySomeGetSomePreview();" type="text" class="form-control" placeholder="e.g. mini pizza">
                                            <span class="input-group-addon"> free </span>
                                        </div>

                                    </div>

                                    <div class="col-xs-9 col-xs-offset-3" style="margin-top: 5px;">
                                        <span class="label label-default" style="background-color: #fff; color: #000;">Offer looks like: </span>
                                        <span id="buySomeGetSomeOfferPreview" class="label label-info">Buy something, get something free</span>
                                    </div>


                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-xs-3 control-label">Select outlets where u want to launch the offer</label>
                                    <div class='col-xs-7'>
                                        <div class="input-group">
                                            <select id="outletsSelect" name="outletsSelect" multiple style="width: 400px;" placeholder="Select outlets" >
                                                <?php
                                                $tbl_name = "outlets";
                                                $query = "SELECT * FROM $tbl_name where MechantId=$uid and IsDeleted=0 order by OutletName";
                                                $result = mysqli_query($con, $query);
                                                while ($row = mysqli_fetch_array($result)) {
                                                    echo '<OPTION VALUE="' . $row['OutletId'] . '" >' . $row['OutletName'] . ' , ' . $row['OutletAddress'] . '</OPTION>';
                                                }
                                                ?>
                                            </select>
                                        </div>

                                    </div>
                                </div>


                                <div id="outletsGroup" class="form-group">
                                    <label for="inputEmail3" class="col-xs-3 control-label">How many coupons do you want to push at each outlet?</label>
                                    <div class='col-xs-9'>
                                        <!--<div id="newCampaignsTable">-->
                                        <table id="couponTable"><thead style="background:cadetblue; vertical-align: middle; color:#FFF;"><tr style="height:30px; padding:5px;"><th style="width:170px;">Outlet</th><th>Offer Start time</th><th>Offer End time</th><th style="width:90px;">No of Coupons</th></tr></thead>

                                        </table>
                                        <!--</div>-->

                                    </div>

                                </div>

                                <hr>

                                <div id="outletsGroup" class="form-group">
                                    <label for="inputEmail3" class="col-xs-3 control-label">Bill details and checkout </label>
                                    <div class='col-xs-9'>
                                        <div id="campaignBill" style="height: 30px; width: 200px;float: left;" class="btn-danger btn-sm" >Campaign Bill: $00.00</div>
                                        <a class="btn btn-success btn-sm" style="margin-right: 50px; margin-left: 5px;" onclick="readTable()">Checkout</a>
                                    </div>
                                </div>

                                <hr>

                                <input type="file" id="inputLogo" accept="image/*" style="visibility: hidden;" />
                                <input type="file" id="inputCover" accept="image/*" style="visibility: hidden;" />

                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div id='footer' style="height: 50px; margin-top: 100px; background: #FFF;width: 100% !important; border-top: solid 2px #285e8e;">

            <div class='container-non-responsive' style="margin-top: -2px;">
                <div class="row">
                    <div class="col-xs-5"> </div>
                    <div class="col-xs-2">
                        <div class='row'>
                            <div class='col-xs-4 social-icon' ><i class="fa fa-facebook-square"></i> </div>
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

        <div class="modal fade" id="uploadLogoModal" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Upload Logo</h4>
                    </div>
                    <div class="modal-body">
                        <p class="alert alert-danger" style='margin-bottom: 10px;'>Crop the photo to make a rectangular selection.</p>
                        <div style="display: block; margin-left: auto; margin-right: auto; text-align: center">
                            <img id='logoCropper' src='img/bg_black.png'>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Crop</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->

        <div class="modal fade" id="uploadCoverModal" >
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background: #357ebd; color: #FFF;">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Upload Logo</h4>
                    </div>
                    <div class="modal-body">
                        <p class="alert alert-danger" style='margin-bottom: 10px;'>Kindly select a cover photo with 18:6 aspect ratio.</p>
                        <div style="display: block; margin-left: auto; margin-right: auto; text-align: center">
                            <img id='coverCropper' src=''>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-success">Crop</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </body>
</html>