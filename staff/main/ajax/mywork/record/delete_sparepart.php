<?php 
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


    $spare_used_id = $_POST['spare_used_id'];

    $sql_spare_part = "SELECT *,b.job_id AS id_job FROM tbl_job_spare_used a
    LEFT JOIN tbl_job b ON a.job_id = b.job_id 
    LEFT JOIN tbl_user c ON b.responsible_user_id = c.user_id 
    WHERE a.spare_used_id = '$spare_used_id'";
    $result_spare_part  = mysqli_query($connect_db, $sql_spare_part);
    $row_spare_part = mysqli_fetch_array($result_spare_part);
    
    $branch_id = $row_spare_part['branch_id'];
    $spare_id = $row_spare_part['spare_part_id'];
    $id_job = $row_spare_part['id_job'];
    
    $sql_stock = "SELECT * FROM tbl_branch_stock WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_id'";
    $result_stock  = mysqli_query($connect_db, $sql_stock);
    $row_stock = mysqli_fetch_array($result_stock);
    
    $return_stock = $row_stock['remain_stock'] + $row_spare_part['quantity'];
    
    $sql_update = "UPDATE tbl_branch_stock 
    SET remain_stock = '$return_stock'
    WHERE branch_id = '$branch_id' AND spare_part_id = '$spare_id'";
    $result_update  = mysqli_query($connect_db, $sql_update);
    
    
    
    $sql_del = "DELETE  FROM tbl_job_spare_used WHERE spare_used_id = '$spare_used_id'";
    $result_del = mysqli_query($connect_db, $sql_del) or die($connect_db->error);
    

    
    // echo $sql_spare_q;
    if ($result_del && $result_update) {
        $arr['result'] = 1;
       
    } else {
        $arr['result'] = 0;
    }
    
    echo json_encode($arr);
