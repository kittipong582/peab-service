 <?php
    include("../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $qr_register =  mysqli_real_escape_string($connect_db, $_POST['qr_register']);
    $customer_id =  mysqli_real_escape_string($connect_db, $_POST['customer_id']);
    $branch_id =  mysqli_real_escape_string($connect_db, $_POST['branch']);
    $register_datetime  = date('Y-m-d H:s:i');
    if ($connect_db) {

        $sql_update = "UPDATE tbl_qr_code SET
        register_datetime  = '$register_datetime' ,
        branch_id = '$branch_id' 
        WHERE qr_no = '$qr_register'";

        $res_update = mysqli_query($connect_db, $sql_update)  or die($connect_db->error);

        if ($res_update) {
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