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
    $index = $_REQUEST["index"];
}

function customError($errno, $errstr) {
    
}

set_error_handler("customError");
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Edit outlet</title>
        <script src="js/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <link href="css/bootstrap.min.css" rel="stylesheet">
        <link href='http://fonts.googleapis.com/css?family=Sintony' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Snippet' rel='stylesheet' type='text/css'>
        <link href='http://fonts.googleapis.com/css?family=Euphoria Script' rel='stylesheet' type='text/css'>
        <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">        
        <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&sensor=false"></script>

        <link href="css/jquery.Jcrop.css" rel="stylesheet">        
        <script src="js/jquery.Jcrop.js"></script>
        <script src="js/cityStates.js"></script>

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

            .separator{
                background: #f5f5f5; 

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



        </style>

        <script>
            var jcrop = null;
            var coords = null;
            $(function() {
                
                //                var mapOptions = {
                //                    zoom: 8,
                //                    center: new google.maps.LatLng(33.6000,73.0500),
                //                    mapTypeId: google.maps.MapTypeId.ROADMAP
                //                };
                //                map = new google.maps.Map(document.getElementById('googleMap'), mapOptions);
                
                $('#inputLogo').change(function(e){
                    var oFile = $('#inputLogo')[0].files[0];
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (theFile) {
                            $('#logoCropper').attr('src', theFile.target.result);
                            
                            var $preview = $("#logoPreview");
                            $preview.attr('src', theFile.target.result);

                            var image = new Image();
                            image.src = theFile.target.result;
                            
                            image.onload = function() {
                                
                                $('#filetype').val(oFile.type);
                                $('#filesize').val(oFile.size);
                                var imgw = this.width;
                                var imgh = this.height;

                                var jcropOptions = {
                                    bgColor:     'black',
                                    bgOpacity:   .3,
                                    aspectRatio: 1/1,
                                    boxHeight: 400,
                                    boxWidth: 500,
                                    setSelect: [0, 0, imgw/2, imgh/2],
                                    onChange: function(c){
                                        
                                        $('#x1').val(c.x);
                                        $('#y1').val(c.y);
                                        $('#x2').val(c.x2);
                                        $('#y2').val(c.y2);
                                        $('#w').val(c.w);
                                        $('#h').val(c.h);
                                        
                                        coords = c;
                                        
                                        if (parseInt(coords.w) > 0)
                                        {
                                            var rx = 150 / coords.w;
                                            var ry = 150 / coords.h;
                                            $preview.css({
                                                width: Math.round(rx * imgw) + 'px',
                                                height: Math.round(ry * imgh) + 'px',
                                                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                                                marginTop: '-' + Math.round(ry * coords.y) + 'px'
                                            }).show();
                                        }

                                    }
                                };
                                
                                if(jcrop!=null){
                                    jcrop.destroy();
                                    //alert("dest");
                                }
                                

                                $('#logoCropper').Jcrop(jcropOptions, function(){
                                    jcrop = this;
                                });
                                
                                $('#uploadLogoModal').modal('show');

                            };

                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });




                $('#inputCover').change(function(e){
                    var oFile = $('#inputCover')[0].files[0];
                    var input = this;
                    if (input.files && input.files[0]) {
                        var reader = new FileReader();
                        reader.onload = function (theFile) {
                            $('#coverCropper').attr('src', theFile.target.result);
                            
                            var $preview = $("#coverPreview");
                            $preview.attr('src', theFile.target.result);

                            var image = new Image();
                            image.src = theFile.target.result;
                            
                            image.onload = function() {
                                
                                $('#filetype').val(oFile.type);
                                $('#filesize').val(oFile.size);
                                var imgw = this.width;
                                var imgh = this.height;

                                var jcropOptions = {
                                    bgColor:     'black',
                                    bgOpacity:   .3,
                                    aspectRatio: 18/6,
                                    boxHeight: 400,
                                    boxWidth: 500,
                                    allowResize: true,
                                    allowSelect: false,
                                    setSelect: [0, 0, imgw/2, imgh/2],
                                    onChange: function(c){
                                        
                                        $('#c_x1').val(c.x);
                                        $('#c_y1').val(c.y);
                                        $('#c_x2').val(c.x2);
                                        $('#c_y2').val(c.y2);
                                        $('#c_w').val(c.w);
                                        $('#c_h').val(c.h);
                                        
                                        coords = c;
                                        
                                        if (parseInt(coords.w) > 0)
                                        {
                                            var rx = 450 / coords.w;
                                            var ry = 150 / coords.h;
                                            $preview.css({
                                                width: Math.round(rx * imgw) + 'px',
                                                height: Math.round(ry * imgh) + 'px',
                                                marginLeft: '-' + Math.round(rx * coords.x) + 'px',
                                                marginTop: '-' + Math.round(ry * coords.y) + 'px'
                                            }).show();
                                        }

                                    }
                                };
                                
                                if(jcrop!=null){
                                    jcrop.destroy();
                                    //alert("dest");
                                }
                                

                                $('#coverCropper').Jcrop(jcropOptions, function(){
                                    jcrop = this;
                                });
                                
                                $('#uploadCoverModal').modal('show');

                            };

                        }
                        reader.readAsDataURL(input.files[0]);
                    }
                });

            });



        </script>

        <script type="text/javascript">
            var marker=null;
            var geocoder;
            var map;
            function initialize()
            {
                var mapProp = {
                    center:new google.maps.LatLng(33.6000,73.0500),
                    zoom:5,
                    mapTypeId:google.maps.MapTypeId.ROADMAP
                };
                geocoder = new google.maps.Geocoder();
                map=new google.maps.Map(document.getElementById("googleMap"),mapProp);
                google.maps.event.addListener(map, 'click', function(event) {
                    if(marker != null){
                        marker.setMap(null);
                    }
                    marker = new google.maps.Marker({position: event.latLng, map: map});
                    var latitude = marker.position.lat();
                    var longitude = marker.position.lng();
                    $('#lat').val(latitude);
                    $('#lon').val(longitude);
                    codeLatLng(latitude,longitude);
                });
                
                var outletId = <?php echo $index; ?>;
                $.post("SelectOutletById.php",
                {
                    index:outletId
                },
                function(data,status){
                    //id^name^city^country^Stime^Etime^Days^Number^Lat^Lon^Services
                    //                    alert("Data: " + data + "\nStatus: " + status);
                    var values = data.split("^");
                    //                    for(var i=0;i<10;i++){
                    //                        alert(values[i]);
                    //                    }
//                    $('#outletName').val("values[1]");
                    $('#outletName').val(values[1]);
                    $('#conatctNo').val(values[7]);
                    $('#lat').val(values[8]);
                    $('#lon').val(values[9]);
                    
                    var myLatLng = new google.maps.LatLng(values[8], values[9]);
                    marker = new google.maps.Marker({
                        map: map,
                        position: myLatLng
                    });
                    map.setCenter(myLatLng);
                    map.setZoom(13);
                    codeLatLng(values[8], values[9]);
                    
                    set_city_state1(values[3],city_state,values[2]);
                    if(marker != null){
                        marker.setMap(null);
                    }
                    
                });
                
            }
            
            function codeLatLng(Slat,Slon) {
                //                alert(latLon);
                //                var input = document.getElementById('latlng').value;
                //                var latlngStr = input.toString().split(',', 2);
                var lat = parseFloat(Slat);
                var lng = parseFloat(Slon);
                var latlng = new google.maps.LatLng(lat, lng);
                geocoder.geocode({'latLng': latlng}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        if (results[1]) {
                            //                            alert(results[1].formatted_address);
                            $('#addressInfo').html('<span class="label label-info">'+results[1].formatted_address+'</span>');   
                            $('#outletAdd').val(results[1].formatted_address);
                        } else {
                            alert('No results found');
                        }
                    } else {
                        alert('Geocoder failed due to: ' + status);
                    }
                });
            }
            
            
            function codeAddress1(address) {
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(13);
                        //                        document.getElementById('markMap').innerHTML = "<p style='color: orange'>Please mark the location on the map</p>"
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
            
            function codeAddress(address) {
                geocoder.geocode( { 'address': address}, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) {
                        map.setCenter(results[0].geometry.location);
                        map.setZoom(13);
                        document.getElementById('markMap').innerHTML = "<p style='color: orange'>Please mark the location on the map</p>"
                    } else {
                        alert("Geocode was not successful for the following reason: " + status);
                    }
                });
            }
            google.maps.event.addDomListener(window, 'load', initialize);
        </script>

    </head>
    <body style="font-family: 'Sintony', sans-serif; background: url(img/bg_main.jpg) repeat;" onload="initialize();">
        <?php include 'header.php' ?>

        <div id='content' class='container-non-responsive'>
            <div class='row'>
                
                <?php include 'navigationMenu.php' ?>
                <script>
                    document.getElementById("outlets").className = "active";
                </script>

                <div class="col-xs-9">
                    <div class='row'>
                        <div class='panel panel-primary' style='background: #FFF; padding-left: 20px;padding-right: 20px; border-radius: 4px;'>
                            <h2 class="panel-heading">Edit outlet</h2>
                            <form class="form-horizontal" action="editOutlet.php" method="post" enctype="multipart/form-data">

                                <input id="lat" name="lat" type="hidden"/>
                                <input id="lon" name="lon" type="hidden"/>
                                <input id="outletAdd" name="outletAdd" type="hidden"/>
                                <input name="outletId" id="outletId" type="hidden" value="<?php echo $index; ?>"/>
                                
                                <h4 class="separator">General Information</h4>

                                <div class="form-group">
                                    <label for="outletName" class="col-sm-3 control-label">Outlet Name</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="outletName" name="outletName" placeholder="e.g. McDonalds">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Category</label>
                                    <div class="col-xs-5">
                                        <select class="form-control" name="category" id="category">
                                            <?php
                                            $query = "SELECT * FROM types where Description LIKE 'outlet%'";
                                            $result = mysqli_query($con, $query);

                                            while ($row = mysqli_fetch_array($result)) {
                                                if ($row['TypeId'] == $Outletrow['TypeId']) {
                                                    echo '<OPTION SELECTED="SELECTED" VALUE="' . $row['TypeId'] . '" >' . $row['TypeName'];
                                                } else {
                                                    echo '<OPTION VALUE="' . $row['TypeId'] . '" >' . $row['TypeName'];
                                                }
                                            }
                                            ?>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label for="conatctNo" class="col-sm-3 control-label">Landline Number</label>
                                    <div class="col-xs-5">
                                        <input type="text" class="form-control" id="conatctNo" name="conatctNo" placeholder="+1 579 XXXX XXX">
                                    </div>
                                </div>



                                <h4 class="separator">Location Information</h4>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Country</label>
                                    <div class="col-xs-5">
                                        <select class="form-control" id="country" name="country" onchange="set_city_state(this,city_state)">
                                            <option value="" disabled="" selected="" style="display: none;color: gray">Select country</option>
                                            <option value="United States">United States</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="Afghanistan">Afghanistan</option>
                                            <option value="Albania">Albania</option>
                                            <option value="Algeria">Algeria</option>
                                            <option value="Andorra">Andorra</option>
                                            <option value="Angola">Angola</option>
                                            <option value="Anguilla">Anguilla</option>
                                            <option value="Argentina">Argentina</option>
                                            <option value="Armenia">Armenia</option>
                                            <option value="Aruba">Aruba</option>
                                            <option value="Australia">Australia</option>
                                            <option value="Austria">Austria</option>
                                            <option value="Azerbaijan">Azerbaijan</option>
                                            <option value="Bahamas">Bahamas</option>
                                            <option value="Bahrain">Bahrain</option>
                                            <option value="Bangladesh">Bangladesh</option>
                                            <option value="Barbados">Barbados</option>
                                            <option value="Belarus">Belarus</option>
                                            <option value="Belgium">Belgium</option>
                                            <option value="Belize">Belize</option>
                                            <option value="Benin">Benin</option>
                                            <option value="Bermuda">Bermuda</option>
                                            <option value="Bhutan">Bhutan</option>
                                            <option value="Botswana">Botswana</option>
                                            <option value="Brazil">Brazil</option>
                                            <option value="Brunei Darussalam">Brunei Darussalam</option>
                                            <option value="Bulgaria">Bulgaria</option>
                                            <option value="Burkina Faso">Burkina Faso</option>
                                            <option value="Burundi">Burundi</option>
                                            <option value="Cambodia">Cambodia</option>
                                            <option value="Cameroon">Cameroon</option>
                                            <option value="Canada">Canada</option>
                                            <option value="Cape Verde">Cape Verde</option>
                                            <!--<option value="Cayman Islands">Cayman Islands</option>-->
                                            <option value="Central African Republic">Central African Republic</option>
                                            <option value="Chad">Chad</option>
                                            <option value="Chile">Chile</option>
                                            <option value="China">China</option>
                                            <!--<option value="Christmas Island">Christmas Island</option>-->
                                            <!--<option value="Cocos (Keeling) Islands">Cocos (Keeling) Islands</option>-->
                                            <option value="Colombia">Colombia</option>
                                            <option value="Comoros">Comoros</option>
                                            <option value="Congo">Congo</option>
                                            <!--<option value="Congo, The Democratic Republic of The">Congo, The Democratic Republic of The</option>-->
                                            <!--<option value="Cook Islands">Cook Islands</option>-->
                                            <option value="Costa Rica">Costa Rica</option>
                                            <!--<option value="Cote D'ivoire">Cote D'ivoire</option>-->
                                            <option value="Croatia">Croatia</option>
                                            <option value="Cuba">Cuba</option>
                                            <!--<option value="Curacao">Curacao</option>-->
                                            <option value="Cyprus">Cyprus</option>
                                            <option value="Czech Republic">Czech Republic</option>
                                            <option value="Denmark">Denmark</option>
                                            <option value="Djibouti">Djibouti</option>
                                            <option value="Dominica">Dominica</option>
                                            <option value="Dominican Republic">Dominican Republic</option>
                                            <option value="Ecuador">Ecuador</option>
                                            <option value="Egypt">Egypt</option>
                                            <option value="El Salvador">El Salvador</option>
                                            <option value="Equatorial Guinea">Equatorial Guinea</option>
                                            <option value="Eritrea">Eritrea</option>
                                            <option value="Estonia">Estonia</option>
                                            <option value="Ethiopia">Ethiopia</option>
                                            <!--<option value="Falkland Islands (Malvinas)">Falkland Islands (Malvinas)</option>-->
                                            <!--<option value="Faroe Islands">Faroe Islands</option>-->
                                            <option value="Fiji">Fiji</option>
                                            <option value="Finland">Finland</option>
                                            <option value="France">France</option>
                                            <!--<option value="French Guiana">French Guiana</option>-->
                                            <!--<option value="French Polynesia">French Polynesia</option>-->
                                            <!--<option value="French Southern Territories">French Southern Territories</option>-->
                                            <option value="Gabon">Gabon</option>
                                            <option value="Gambia">Gambia</option>
                                            <option value="Georgia">Georgia</option>
                                            <option value="Germany">Germany</option>
                                            <option value="Ghana">Ghana</option>
                                            <!--<option value="Gibraltar">Gibraltar</option>-->
                                            <option value="Greece">Greece</option>
                                            <option value="Greenland">Greenland</option>
                                            <option value="Grenada">Grenada</option>
                                            <option value="Guadeloupe">Guadeloupe</option>
                                            <!--<option value="Guam">Guam</option>-->
                                            <option value="Guatemala">Guatemala</option>
                                            <!--<option value="Guernsey">Guernsey</option>-->
                                            <option value="Guinea">Guinea</option>
                                            <!--<option value="Guinea-bissau">Guinea-bissau</option>-->
                                            <option value="Guyana">Guyana</option>
                                            <option value="Haiti">Haiti</option>
                                            <!--<option value="Heard Island and Mcdonald Islands">Heard Island and Mcdonald Islands</option>-->
                                            <!--<option value="Holy See (Vatican City State)">Holy See (Vatican City State)</option>-->
                                            <option value="Honduras">Honduras</option>
                                            <option value="Hong Kong">Hong Kong</option>
                                            <option value="Hungary">Hungary</option>
                                            <option value="Iceland">Iceland</option>
                                            <option value="India">India</option>
                                            <option value="Indonesia">Indonesia</option>
                                            <option value="Iran">Iran</option>
                                            <option value="Iraq">Iraq</option>
                                            <option value="Ireland">Ireland</option>
                                            <!--<option value="Isle of Man">Isle of Man</option>-->
                                            <option value="Israel">Israel</option>
                                            <option value="Italy">Italy</option>
                                            <option value="Jamaica">Jamaica</option>
                                            <option value="Japan">Japan</option>
                                            <!--<option value="Jersey">Jersey</option>-->
                                            <option value="Jordan">Jordan</option>
                                            <option value="Kazakhstan">Kazakhstan</option>
                                            <option value="Kenya">Kenya</option>
                                            <option value="Kiribati">Kiribati</option>
                                            <option value="North Korea">North Korea</option>
                                            <option value="South Korea">South Korea</option>
                                            <option value="Kuwait">Kuwait</option>
                                            <option value="Kyrgyzstan">Kyrgyzstan</option>
                                            <!--<option value="Lao People's Democratic Republic">Lao People's Democratic Republic</option>-->
                                            <option value="Latvia">Latvia</option>
                                            <option value="Lebanon">Lebanon</option>
                                            <option value="Lesotho">Lesotho</option>
                                            <option value="Liberia">Liberia</option>
                                            <option value="Libya">Libya</option>
                                            <option value="Liechtenstein">Liechtenstein</option>
                                            <option value="Lithuania">Lithuania</option>
                                            <option value="Luxembourg">Luxembourg</option>
                                            <!--<option value="Macao">Macao</option>-->
                                            <option value="Macedonia">Macedonia</option>
                                            <option value="Madagascar">Madagascar</option>
                                            <option value="Malawi">Malawi</option>
                                            <option value="Malaysia">Malaysia</option>
                                            <option value="Maldives">Maldives</option>
                                            <option value="Mali">Mali</option>
                                            <option value="Malta">Malta</option>
                                            <!--<option value="Marshall Islands">Marshall Islands</option>-->
                                            <option value="Martinique">Martinique</option>
                                            <option value="Mauritania">Mauritania</option>
                                            <option value="Mauritius">Mauritius</option>
                                            <!--<option value="Mayotte">Mayotte</option>-->
                                            <option value="Mexico">Mexico</option>
                                            <option value="Micronesia">Micronesia</option>
                                            <option value="Moldova">Moldova</option>
                                            <option value="Monaco">Monaco</option>
                                            <option value="Mongolia">Mongolia</option>
                                            <!--<option value="Montenegro">Montenegro</option>-->
                                            <option value="Montserrat">Montserrat</option>
                                            <option value="Morocco">Morocco</option>
                                            <option value="Mozambique">Mozambique</option>
                                            <option value="Myanmar">Myanmar</option>
                                            <option value="Namibia">Namibia</option>
                                            <option value="Nauru">Nauru</option>
                                            <option value="Nepal">Nepal</option>
                                            <option value="Netherlands">Netherlands</option>
                                            <!--<option value="New Caledonia">New Caledonia</option>-->
                                            <option value="New Zealand">New Zealand</option>
                                            <option value="Nicaragua">Nicaragua</option>
                                            <option value="Niger">Niger</option>
                                            <option value="Nigeria">Nigeria</option>
                                            <!--<option value="Niue">Niue</option>-->
                                            <!--<option value="Norfolk Island">Norfolk Island</option>-->
                                            <!--<option value="Northern Mariana Islands">Northern Mariana Islands</option>-->
                                            <option value="Norway">Norway</option>
                                            <option value="Oman">Oman</option>
                                            <option value="Pakistan">Pakistan</option>
                                            <option value="Palau">Palau</option>
                                            <!--<option value="Palestinian Territory, Occupied">Palestinian Territory, Occupied</option>-->
                                            <option value="Panama">Panama</option>
                                            <option value="Papua New Guinea">Papua New Guinea</option>
                                            <option value="Paraguay">Paraguay</option>
                                            <option value="Peru">Peru</option>
                                            <option value="Philippines">Philippines</option>
                                            <!--<option value="Pitcairn">Pitcairn</option>-->
                                            <option value="Poland">Poland</option>
                                            <option value="Portugal">Portugal</option>
                                            <option value="Puerto Rico">Puerto Rico</option>
                                            <option value="Qatar">Qatar</option>
                                            <!--<option value="Reunion">Reunion</option>-->
                                            <option value="Romania">Romania</option>
                                            <option value="Russian Federation">Russian Federation</option>
                                            <option value="Rwanda">Rwanda</option>
                                            <!--<option value="Saint Barthelemy">Saint Barthelemy</option>-->
                                            <!--<option value="Saint Helena, Ascension and Tristan da Cunha">Saint Helena, Ascension and Tristan da Cunha</option>-->
                                            <!--<option value="Saint Kitts and Nevis">Saint Kitts and Nevis</option>-->
                                            <!--<option value="Saint Lucia">Saint Lucia</option>-->
                                            <!--<option value="Saint Martin (French part)">Saint Martin (French part)</option>-->
                                            <!--<option value="Saint Pierre and Miquelon">Saint Pierre and Miquelon</option>-->
                                            <!--<option value="Saint Vincent and The Grenadines">Saint Vincent and The Grenadines</option>-->
                                            <option value="Samoa">Samoa</option>
                                            <option value="San Marino">San Marino</option>
                                            <!--<option value="Sao Tome and Principe">Sao Tome and Principe</option>-->
                                            <option value="Saudi Arabia">Saudi Arabia</option>
                                            <option value="Senegal">Senegal</option>
                                            <!--<option value="Serbia">Serbia</option>-->
                                            <option value="Seychelles">Seychelles</option>
                                            <option value="Sierra Leone">Sierra Leone</option>
                                            <!--<option value="Singapore">Singapore</option>-->
                                            <!--<option value="Sint Maarten (Dutch part)">Sint Maarten (Dutch part)</option>-->
                                            <option value="Slovakia">Slovakia</option>
                                            <option value="Slovenia">Slovenia</option>
                                            <!--<option value="Solomon Islands">Solomon Islands</option>-->
                                            <option value="Somalia">Somalia</option>
                                            <option value="South Africa">South Africa</option>
                                            <!--<option value="South Georgia and The South Sandwich Islands">South Georgia and The South Sandwich Islands</option>-->
                                            <!--<option value="South Sudan">South Sudan</option>-->
                                            <option value="Spain">Spain</option>
                                            <option value="Sri Lanka">Sri Lanka</option>
                                            <option value="Sudan">Sudan</option>
                                            <option value="Suriname">Suriname</option>
                                            <!--<option value="Svalbard and Jan Mayen">Svalbard and Jan Mayen</option>-->
                                            <option value="Swaziland">Swaziland</option>
                                            <option value="Sweden">Sweden</option>
                                            <option value="Switzerland">Switzerland</option>
                                            <option value="Syria">Syria</option>
                                            <option value="Taiwan">Taiwan</option>
                                            <option value="Tajikistan">Tajikistan</option>
                                            <option value="Tanzania">Tanzania</option>
                                            <option value="Thailand">Thailand</option>
                                            <!--<option value="Timor-leste">Timor-leste</option>-->
                                            <option value="Togo">Togo</option>
                                            <!--<option value="Tokelau">Tokelau</option>-->
                                            <option value="Tonga">Tonga</option>
                                            <!--<option value="Trinidad and Tobago">Trinidad and Tobago</option>-->
                                            <option value="Tunisia">Tunisia</option>
                                            <option value="Turkey">Turkey</option>
                                            <option value="Turkmenistan">Turkmenistan</option>
                                            <!--<option value="Turks and Caicos Islands">Turks and Caicos Islands</option>-->
                                            <option value="Tuvalu">Tuvalu</option>
                                            <option value="Uganda">Uganda</option>
                                            <option value="Ukraine">Ukraine</option>
                                            <option value="United Arab Emirates">United Arab Emirates</option>
                                            <option value="United Kingdom">United Kingdom</option>
                                            <option value="United States">United States</option>
                                            <!--<option value="United States Minor Outlying Islands">United States Minor Outlying Islands</option>-->
                                            <option value="Uruguay">Uruguay</option>
                                            <option value="Uzbekistan">Uzbekistan</option>
                                            <option value="Vanuatu">Vanuatu</option>
                                            <option value="Venezuela">Venezuela</option>
                                            <option value="Vietnam">Vietnam</option>
                                            <!--<option value="Virgin Islands, British">Virgin Islands, British</option>-->
                                            <!--<option value="Virgin Islands, U.S.">Virgin Islands, U.S.</option>-->
                                            <!--<option value="Wallis and Futuna">Wallis and Futuna</option>-->
                                            <!--<option value="Western Sahara">Western Sahara</option>-->
                                            <option value="Yemen">Yemen</option>
                                            <option value="Zambia">Zambia</option>
                                            <option value="Zimbabwe">Zimbabwe</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">City</label>
                                    <div class="col-xs-5">
                                        <select class="form-control" name="city_state" size="1" id="city_state" disabled="disabled" onchange="print_city_state(country,this)">

                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Select location on map</label>
                                    <div id="googleMap" class="col-xs-7" style="height: 350px; background: #EEE; margin-left: 15px; border-radius: 5px;">

                                    </div>
                                </div>

                                <h4 class="separator">Logo and Cover Photo</h4>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-3 control-label">Kindly select a logo and a cover photo for your outlet. These photos will be displayed to customers in discount coupons.</label>
                                    <div class="col-xs-9">
                                        <div class='row' style="margin-left: 1px;">

                                            <div style="width:150px;height:150px;overflow:hidden;margin-left:0px; float: left;">
                                                <?php
                                                $query = "SELECT * FROM outlets where OutletId=$index";
                                                $result = mysqli_query($con, $query);
                                                $row = mysqli_fetch_array($result);
                                                ?>
                                                <img src="<?php echo $row['OutletThumbnail']; ?>" id="logoPreview" style="width: 150px; height: 150px; margin-left: 0px;">
                                            </div>

                                            <div style="width:450px;height:150px;overflow:hidden;margin-left:10px; float: left;">
                                                <img src="<?php echo $row['OutletImage']; ?>" id="coverPreview" style="width: 450px; height: 150px; margin-left: 0px;">
                                            </div>

                                        </div>
                                    </div>

                                    <div class='col-xs-9 col-xs-offset-3' style='margin-top: 0px; font-size: 16px; color: #3278b3'>
                                        <a class='btn btn-info btn-sm' href="#" onclick="document.getElementById('inputLogo').click(); return false;" style='margin-left: 1px; width: 150px;'>Upload Logo </a>
                                        <a class='btn btn-info btn-sm' href="#" onclick="document.getElementById('inputCover').click(); return false;" style='margin-left: 5px; width: 450px;'>Upload Cover Photo </a>
                                    </div>
                                </div>




                                <div class="form-group" style='margin-top: 50px;'>
                                    <div class="col-sm-offset-3 col-xs-09">
                                        <button type="submit" class="btn btn-success btn-lg" style='margin-left: 15px;'>Update Outlet</button>
                                    </div>
                                </div>
                                <!-- input logo -->

                                <div class="info" style="display: none">
                                    <input type="text" id="x1" name="x1" /><input type="text" id="y1" name="y1" />
                                    <input type="text" id="x2" name="x2" /><input type="text" id="y2" name="y2" />
                                    <input type="text" id="filesize" name="filesize" />
                                    <input type="text" id="filetype" name="filetype" />
                                    <input type="text" id="filedim" name="filedim" />
                                    <input type="text" id="w" name="w" />
                                    <input type="text" id="h" name="h" />
                                </div>

                                <input type="file" id="inputLogo" name="inputLogo" accept="image/jpeg" style="visibility: hidden;" />

                                <!-- input cover -->

                                <div class="info" style="display: none">
                                    <input type="text" id="c_x1" name="c_x1" /><input type="text" id="c_y1" name="c_y1" />
                                    <input type="text" id="c_x2" name="c_x2" /><input type="text" id="c_y2" name="c_y2" />
                                    <input type="text" id="c_filesize" name="c_filesize" />
                                    <input type="text" id="c_filetype" name="c_filetype" />
                                    <input type="text" id="c_filedim" name="c_filedim" />
                                    <input type="text" id="c_w" name="c_w" />
                                    <input type="text" id="c_h" name="c_h" />
                                </div>

                                <input type="file" id="inputCover" name="inputCover" accept="image/jpeg" style="visibility: hidden;" />

                            </form>
                        </div>
                    </div>

                </div>


            </div>
        </div>

        <div id='footer' style="height: 50px; margin-top: 50px; background: #FFF;width: 100% !important; border-top: solid 2px #285e8e;">

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
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
                        <button type="button" class="btn btn-success" data-dismiss="modal">Crop</button>
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
                        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>-->
                        <button type="button" class="btn btn-success" data-dismiss="modal">Crop</button>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->


    </body>
</html>
<?php
mysqli_close($con);
?>