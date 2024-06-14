<?php
    session_start();
    include("../../../config/main_function.php");
    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $contact_id = mysqli_real_escape_string($connection, $_POST['contact_id']);

    $sql = "DELETE FROM tbl_customer_contact WHERE contact_id = '$contact_id' ;";
    $rs  = mysqli_query($connection, $sql) or die($connection->error);


    if($rs){
    $arr['result'] = 1;
    } else {
    $arr['result'] = 0;
    }

    echo json_encode($arr);
    mysqli_close($connection);
  

?>