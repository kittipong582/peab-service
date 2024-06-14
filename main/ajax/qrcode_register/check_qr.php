 <?php
    include("../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $qr_no = mysqli_real_escape_string($connect_db, $_POST['qr_register']);

    if ($connect_db) {

        $sql_check = "SELECT * FROM tbl_qr_code WHERE qr_no = '$qr_no' ";
        $res_check = mysqli_query($connect_db, $sql_check)  or die($connect_db->error);
        $num_check = mysqli_num_rows($res_check);

        if ($num_check > 0) {

            $sql_check_register = "SELECT * FROM tbl_qr_code WHERE qr_no = '$qr_no' AND register_datetime IS NOT NULL ";
            $res_check_register = mysqli_query($connect_db, $sql_check_register)  or die($connect_db->error);
            $num_check_register = mysqli_num_rows($res_check_register);

            if ($num_check_register > 0) {
                $arr['result'] = 1;
            }else {
                $arr['result'] = 'ok';
            }
        } else {
            $arr['result'] = 0;
        } 
    } else {
        $arr['result'] = 9;
    }

    mysqli_close($connect_db);
    echo json_encode($arr);
    ?>