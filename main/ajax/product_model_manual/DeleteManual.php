 <?php
    include("../../../config/main_function.php");

    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");


    $manual_id =  mysqli_real_escape_string($connect_db, $_POST['manual_id']);

    if ($connect_db) {

        $sql_delete = "DELETE FROM tbl_product_model_manual WHERE manual_id = '$manual_id'";

        $res_delete = mysqli_query($connect_db, $sql_delete)  or die($connect_db->error);

        if ($res_delete) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {
        $arr['result'] = 9;
    }

    mysqli_close($connect_db);
    echo json_encode($arr);
    ?>