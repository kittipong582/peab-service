<?php
    session_start();
    include("../../../config/main_function.php");
    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $daily_id = mysqli_real_escape_string($connection, $_POST['daily_id']);

    $sql = "DELETE FROM tbl_customer_daily_record WHERE daily_id = '$daily_id' ;";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);

echo $sql;
    // if($rs){
    // $arr['result'] = 1;
    // } else {
    // $arr['result'] = 0;
    // }

    echo json_encode($arr);
    mysqli_close($connection);
  

?>