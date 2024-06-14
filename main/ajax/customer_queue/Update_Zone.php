<?php
session_start();
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$queue_id = mysqli_real_escape_string($connection, $_POST['queue_id']);
$area_id = mysqli_real_escape_string($connection, $_POST['area_id']);
$o_area_id = mysqli_real_escape_string($connection, $_POST['o_area_id']);



if ($connection) {

    $sql_update = "UPDATE tbl_customer_queue SET  
        area_id = '$area_id' 
        WHERE queue_id = '$queue_id'";

    $res_update = mysqli_query($connection, $sql_update) or die($connection->error);


    if ($res_update) {

        ///////////////New Area///////////////////////
        $sql_new = "SELECT create_datetime,queue_id FROM tbl_customer_queue WHERE area_id = '$area_id' ORDER BY create_datetime ASC";
        $res_new = mysqli_query($connection, $sql_new) or die($connection->error);
        $num_list_new = mysqli_num_rows($res_new);
        $i = 1;
        while ($row_new = mysqli_fetch_assoc($res_new)) {

            $sql_update_q = "UPDATE tbl_customer_queue SET queue_no = $i
            WHERE queue_id = '{$row_new['queue_id']}'";
            $res_update_q = mysqli_query($connection, $sql_update_q) or die($connection->error);
            $i++;
        }

    }
    if ($res_update_q) {
        ///////////////OG Area///////////////////////
        $sql_og = "SELECT create_datetime,queue_id FROM tbl_customer_queue WHERE area_id = '$o_area_id' ORDER BY create_datetime ASC";
        $res_og = mysqli_query($connection, $sql_og) or die($connection->error);
        $num_list_og = mysqli_num_rows($res_og);
        $i = 1;
        while ($row_og = mysqli_fetch_assoc($res_og)) {
            $sql_update_q_OG = "UPDATE tbl_customer_queue SET queue_no = $i
            WHERE queue_id = '{$row_og['queue_id']}'";
            $res_update_q_OG = mysqli_query($connection, $sql_update_q_OG) or die($connection->error);
            $i++;
        }
        $arr['result'] = 1;
    } else {
        $arr['result'] = 0;

    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);
?>