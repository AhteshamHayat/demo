<script>
    $(function(){
        $("#rechargeProceed").click(function(){
            var amount = $("#rechargeAmount").val();
            $("#amount").val(amount);
            document.getElementById("rechargeForm").submit();
        });
    });
</script>
<div class="modal fade" id="rechargeModal" style="padding-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">
            <form class="form-horizontal">

                <div class="modal-header" style="background: #357ebd; color: #FFF;">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Recharge Account</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Current Balance </label>
                        <div class="input-group" style="width: 50%;">
                            <span class="input-group-addon">$</span>
                            <input type="text" class="form-control" style="background: #EEE" value="<?php echo $Currentbalance; ?>" disabled>
                        </div>              
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Refill Amount: </label>
                        <div class="input-group" style="width: 50%;">
                            <span class="input-group-addon" >$</span>
                            <input id="rechargeAmount" type="number" class="form-control" value="10.00">
                        </div>              
                    </div>
                    <div class="form-group">
                        <label for="inputEmail3" class="col-xs-4 control-label">Balance After Refill: </label>
                        <div class="input-group" style="width: 50%;">
                            <span class="input-group-addon" >$</span>
                            <input type="text" class="form-control" value="10.00" disabled>
                        </div>              
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                    <button id="rechargeProceed" type="button" class="btn btn-success">Proceed</button>
                </div>
            </form>

        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<form id="rechargeForm" class="form-horizontal" action="https://www.moneybookers.com/app/payment.pl" method="post" target="_blank">

    <?php
    $query = "SELECT * FROM merchants where MerchantId=$uid";
    $result = mysqli_query($con, $query);

    $row = mysqli_fetch_array($result);
    $transactionComplete = $row["TransactionComplete"];

    if ($transactionComplete == 1) {
        $rand_id = "";
        for ($i = 1; $i <= 15; $i++) {
            mt_srand((double) microtime() * 1000000);
            $num = mt_rand(0, 9);
            $rand_id .= $num;
        }

        $trans_id = $rand_id;
        $updateQuery = "update merchants set TransactionId='$trans_id',TransactionComplete=0 where MerchantId=$uid";
        mysqli_query($con, $updateQuery);
    } else {
        $trans_id = $row["TransactionId"];
    }
    mysqli_close($con);
    ?>
    <!--    <div class="control-group">
            <label class="control-label">Balance:</label>
            <div class="controls">
                <p>$ <?php echo $row['Balance']; ?></p>
            </div>
        </div>
    
        <div class="control-group">
            <label class="control-label">Recharge Amount:</label>
            <div class="controls">
                <div class="input-prepend">
                    <span class="add-on">$</span>
                    <input id="amount" name="amount" type="text" value="10">
                </div>
                <div  id="amountInfo"><p style="color: grey">* Minimum of $10 can be recharged</p></div>
    
            </div>
        </div>-->

    <input id="amount" name="amount" type="hidden" value="10">
    <input type="hidden" name="transaction_id" value="<?php echo $trans_id; ?>">
    <input type="hidden" name="pay_to_email" value="dudecry@gmail.com">
    <input type="hidden" name="status_url" value="http://geekyntechy.com/atc/cd/web/SkrillPaymentValidation.php">
    <input type="hidden" name="language" value="EN">
    <!--<input type="hidden" id="skrillAmount" name="amount">-->
    <input type="hidden" name="currency" value="USD">
    <input type="hidden" name="detail1_description" value="Recharge Balance">
    <input type="hidden" name="detail1_text" value="Login into your skrill account to recharge your balance at CityDeals.com">
    <input type="hidden" name="confirmation_note" value="Transaction successful!!">

</form>
