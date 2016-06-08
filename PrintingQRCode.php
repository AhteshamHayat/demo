<!--
To change this template, choose Tools | Templates
and open the template in the editor.
-->
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link href="css/bootstrap.css" rel="stylesheet" media="screen">
        <link href="css/jquery-ui.css" rel="stylesheet" media="screen">
        <script src="http://code.jquery.com/jquery.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <title>QR Code</title>
    </head>
    <body>
        <table border="1">
            <?php
            $code = $_REQUEST['code'];
            for ($j = 0; $j < 6; $j++) {
                echo '<tr>';
                for ($i = 0; $i < 5; $i++) {
                    echo '<td>';
                    echo '<img src="https://chart.googleapis.com/chart?cht=qr&chs=160x160&chl=';
                    echo $code.'"/>';
                    echo '</td>';
                }
                echo '</tr>';
            }
            ?>
        </table>
        <!--<img src="https://chart.googleapis.com/chart?cht=qr&chs=320x320&chl=<?php echo $_SESSION['code']; ?>"/>-->
    </body>
</html>
