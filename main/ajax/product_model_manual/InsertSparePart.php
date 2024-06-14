 <?php
 
    include("../../../config/main_function.php");

    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);
    $spare_part_id = mysqli_real_escape_string($connect_db, $_POST['spare_part_id']);

    if($connect_db){

    $sql_ck_list = "SELECT MAX(list_order) AS list_order FROM tbl_product_model_sparepart WHERE model_id = '$model_id'";
    $res_ck_list = mysqli_query($connect_db, $sql_ck_list);
    $row_ck_list = mysqli_fetch_assoc($res_ck_list);
    if (empty($row_ck_list['list_order'])) {
        $list_order = 1;
    }else{
        $list_order = $row_ck_list['list_order'] + 1;
    }

    $sql_insert = "INSERT INTO tbl_product_model_sparepart SET  
        list_order = '$list_order',
        model_id = '$model_id',
        spare_part_id = '$spare_part_id'";

    $res_insert = mysqli_query($connect_db, $sql_insert)  or die($connect_db->error);

        if($res_insert){
            $arr['result'] = 1;
        }else{
            $arr['result'] = 0;
        }
    }else{
    $arr['result'] = 9;
    }

mysqli_close($connect_db);
echo json_encode($arr);
?>