<?php
    session_start();
    include("../../../config/main_function.php");
    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    $contact_line_id = mysqli_real_escape_string($connection, $_POST['contact_line_id']);
    
    
    $contact_id = mysqli_real_escape_string($connection, $_POST['contact_id']);
    // $values = mysqli_real_escape_string($connection, $_POST['values']);
    $chk = mysqli_real_escape_string($connection, $_POST['chk']);

    $create_user_id = $_SESSION['user_id'];

    // echo $chk;

    if($chk == "1"){

        $sql_update = "UPDATE tbl_customer_contact
        SET main_contact_status = '0' ;";
        $rs_update  = mysqli_query($connection, $sql_update) or die($connection->error);

        // echo $sql_update;


    $sql = "UPDATE tbl_customer_contact
    SET  
         main_contact_status = '1'
        ,contact_name = '$name'
        ,contact_phone = '$phone'
        ,contact_email = '$email'
        ,contact_position = '$position'
        ,contact_line_id = '$contact_line_id'
        WHERE contact_id = '$contact_id'
     ;";

    $rs  = mysqli_query($connection, $sql) or die($connection->error);

    // echo $sql;

    }else{
        $sql = "UPDATE tbl_customer_contact
    SET  
         main_contact_status = '0'
        ,contact_name = '$name'
        ,contact_phone = '$phone'
        ,contact_email = '$email'
        ,contact_position = '$position'
        ,contact_line_id = '$contact_line_id'
        WHERE contact_id = '$contact_id'
     ;";

    $rs  = mysqli_query($connection, $sql) or die($connection->error);

    // echo $sql;
    }

    

    if($rs){
    $arr['result'] = 1;
    } else {
    $arr['result'] = 0;
    }

    echo json_encode($arr);
    mysqli_close($connection);
  

?>