<?php
    session_start();
    include("../../../config/main_function.php");
    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $name = mysqli_real_escape_string($connection, $_POST['name']);
    $phone = mysqli_real_escape_string($connection, $_POST['phone']);
    $position = mysqli_real_escape_string($connection, $_POST['position']);
    $email = mysqli_real_escape_string($connection, $_POST['email']);
    
    $customer_branch_id = mysqli_real_escape_string($connection, $_POST['customer_branch_id']);
    // $values = mysqli_real_escape_string($connection, $_POST['values']);
    $chk = mysqli_real_escape_string($connection, $_POST['chk']);

    $create_user_id = $_SESSION['user_id'];

    // echo $chk;

    if($chk == "1"){

        $sql_update = "UPDATE tbl_customer_contact
        SET main_contact_status = '0' ;";
        $rs_update  = mysqli_query($connection, $sql_update) or die($connection->error);

        // echo $sql_update;


    $sql = "INSERT INTO tbl_customer_contact
    SET  
        customer_branch_id = '$customer_branch_id'
        ,create_user_id = '$create_user_id'
        ,main_contact_status = '1'
        ,contact_name = '$name'
        ,contact_phone = '$phone'
        ,contact_email = '$email'
        ,contact_position = '$position'
     ;";

    $rs  = mysqli_query($connection, $sql) or die($connection->error);

    // echo $sql;

    }else{
        $sql = "INSERT INTO tbl_customer_contact
    SET  
        customer_branch_id = '$customer_branch_id'
        ,create_user_id = '$create_user_id'
        ,main_contact_status = '0'
        ,contact_name = '$name'
        ,contact_phone = '$phone'
        ,contact_email = '$email'
        ,contact_position = '$position'
     ;";

    $rs  = mysqli_query($connection, $sql) or die($connection->error);

    // echo $sql;
    }

    

    if($rs){
    $arr['result'] = 1;
    } else {
    $arr['result'] = 0;
    }
    
    mysqli_close($connection);
    echo json_encode($arr);

?>