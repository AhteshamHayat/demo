<?php

//$con = mysqli_connect("localhost", "hums", "hums", "citydeals");
//if (mysqli_connect_errno()) {
//    echo "Failed to connect to MySQL: " . mysqli_connect_error();
//}

include 'DBConfig.php';
$id = $_POST['id'];
$index = $_POST['index'];
$table = "";
$column = "";
tableName();
$query = "update $table set IsDeleted=1 where $column=$index";
mysqli_query($con, $query);
echo $query;
mysqli_close($con);

function tableName(){
    global $id,$table,$column;
    switch ($id){
        case '1':
            $table = "outlets";
            $column = "OutletId";
            break;
        case '2':
            $table = "coupons";
            $column = "CouponId";
            break;
        case '3':
            $table = "users";
            $column = "userId";
            break;
        case '4':
            $table = "survey";
            $column = "surveyId";
            break;
        case '5':
            $table = "questionnaire";
            $column = "questionnaireId";
            break;
        case '6':
            $table = "question";
            $column = "questionId";
            break;
        
    }
}
?>
