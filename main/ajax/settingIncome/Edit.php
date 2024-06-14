<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $income_type_id = mysqli_real_escape_string($connection, $_POST['income_type_id']);
    $income_code = mysqli_real_escape_string($connection, $_POST['income_code']);

    $income_type_name = mysqli_real_escape_string($connection, $_POST['income_type_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);
    $unit_cost = str_replace(",", "", $_POST['unit_cost']);
    $datetime = date('Y-m-d H:i:s');
    $unit = $_POST['unit'];

    if ($connection) {

        $sql_update = "UPDATE tbl_income_type SET 
            income_type_name = '$income_type_name', 
            income_code = '$income_code', 
            unit_cost = '$unit_cost',
            description = '$description',
            unit = '$unit'
            WHERE income_type_id = '$income_type_id'";
        $update = mysqli_query($connection,$sql_update);
        if($update){
            $result = 1;
        }else{
            $result = 0;
        }
    } else {
        $result = 0;
    }
    $arr['result'] = $result;
    echo json_encode($arr);

    mysqli_close($connection);
?>