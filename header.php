<div id='header' style="height: 100px; width: 100%; background: url(img/bg_black.png) repeat-x; ">
    <div class='container-non-responsive'>
        <div class='row'>
            <div id="logo" class="col-xs-4" style="padding-top: 15px; font-size: 32px; color: #FFFFFF; font-family: 'Euphoria Script', sans-serif;">
                City Deals

            </div>

            <div class="col-xs-8" style="padding-top: 5px; color: #FFFFFF">
                <span class='pull-right' style='color: #EEE; font-size: 12px;'><?php echo $_SESSION['email']; ?></span><br>
                <span class='pull-right'>
                    <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#qrCodeModal"> QR Code </button>


                    <div class="btn-group">
                        <button type="button" class="btn btn-info dropdown-toggle btn-sm" data-toggle="dropdown">
                            Credit: $<?php echo $Currentbalance; ?> <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#" data-toggle="modal" data-target="#rechargeModal">Recharge</a></li>
                        </ul>
                    </div>


                    <a class="btn btn-default btn-sm" href="logout.php"> Logout </a>
                </span>
            </div>



        </div>

    </div>
</div>