<div class="modal fade" id="qrCodeModal" >
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header" style="background: #357ebd; color: #FFF;">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
        <h4 class="modal-title">QR Code</h4>
      </div>
      <div class="modal-body">
        <p class="alert alert-info" style='margin-bottom: 0px;'>Print QR code and keep it at outlet's counter. Your customers will redeem coupons by scanning QR code through their Smart Phone camera.</p>
        <img src="https://chart.googleapis.com/chart?cht=qr&chs=320x320&chl=<?php echo $_SESSION['code']; ?>" style="width: 300px; display: block; margin-left: auto; margin-right: auto;">
        <!--<img src="https://chart.googleapis.com/chart?cht=qr&chs=320x320&chl=<?php echo $_SESSION['code']; ?>"/>-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        <!--<button type="button" class="btn btn-success">Print</button>-->
        <a class="btn btn-success" href="PrintingQRCode.php?code=<?php echo $_SESSION['code']; ?>">Print</a>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
