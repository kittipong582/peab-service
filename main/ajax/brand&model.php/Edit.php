<?php
    session_start();
    include("../../../config/main_function.php");
    date_default_timezone_set("Asia/Bangkok");

    $secure = "LM=VjfQ{6rsm&/h`";
    $connection = connectDB($secure);

    $brand_id = mysqli_real_escape_string($connection, $_POST['brand_id']);
    $brand_name = mysqli_real_escape_string($connection, $_POST['brand_name']);
    $description = mysqli_real_escape_string($connection, $_POST['description']);

    $datetime = date('Y-m-d H:i:s');

    if ($connection) {

        $sql_update = "UPDATE tbl_product_brand SET 
            brand_name = '$brand_name', 
            description = '$description' 
            WHERE brand_id = '$brand_id'";
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