 <?php
    include("../../../config/main_function.php");
    $connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    $qty_qrcode = mysqli_real_escape_string($connect_db, $_POST['qty_qrcode']);

    if ($connect_db) {
        $count = 0;
        for ($i = 0; $i < $qty_qrcode; $i++) {
            $qr_id = getRandomID(20, 'tbl_qr_code', 'qr_id');
            $qr_no = getRandomID2(8, 'tbl_qr_code', 'qr_no');

            $sql_insert = "INSERT INTO tbl_qr_code SET  
                qr_id = '$qr_id',
                qr_no = '$qr_no'
                ";
            $res_insert = mysqli_query($connect_db, $sql_insert)  or die($connect_db->error);
            $count++;
        }


        if ($qty_qrcode == $count) {
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