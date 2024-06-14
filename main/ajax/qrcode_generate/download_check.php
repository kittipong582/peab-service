<?php
include("../../../config/main_function.php");
include("../../qrcodegenerate/qrlib.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qty_download = mysqli_real_escape_string($connect_db, $_POST['qty_download']);

$sql = "SELECT * FROM tbl_qr_code WHERE register_datetime IS NULL";
$res = mysqli_query($connect_db, $sql);
$num = mysqli_num_rows($res);

if ($num >= $qty_download) {
    $arr['result'] = 1;
}else if ($num < $qty_download) {
    $arr['result'] = 0;
}
echo json_encode($arr);