<?php
session_start(); 
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$import_id = mysqli_real_escape_string($connection, $_POST['import_id']);
$branch_id = mysqli_real_escape_string($connection, $_POST['branch']);
$ax_ref_no = mysqli_real_escape_string($connection, $_POST['ax_ref_no']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);

$withdraw_date = $_POST['withdraw_date'];
$withdraw_date = str_replace('/', '-', $withdraw_date);
$withdraw_date = date('Y-m-d', strtotime($withdraw_date));

$create_user_id = $_SESSION['user_id'];

// $sql_c = "SELECT MAX(import_no) AS c_import_no FROM tbl_import_stock; ";
// $rs_c = mysqli_query($connection, $sql_c) or die($connection->error);
// $row_c = mysqli_fetch_assoc($rs_c);

// 6504xxxxx
$year = date('y')+43;
$month = date('m');
$job_ex = $year.$month;

$sql_conut = "SELECT count(*) as count1 FROM tbl_import_stock";
$rs_conut  = mysqli_query($connection, $sql_conut) or die($connection->error);
$row_conut = mysqli_fetch_assoc($rs_conut);
//  echo $sql_conut;
 
 $count_no = $row_conut['count1'] + 1;
 $import_no = "IM".$year.$month.str_pad($count_no, 4,"0",STR_PAD_LEFT);



$sql = "INSERT INTO tbl_import_stock
SET   import_id = '$import_id'
    ,import_no = '$import_no'
    ,create_user_id  = '$create_user_id '
    ,ax_ref_no = '$ax_ref_no'
    ,ax_withdraw_date = '$withdraw_date'
    ,note = '$remark'
    ,receive_branch_id = '$branch_id' 
    ;";
$rs = mysqli_query($connection, $sql) or die($connection->error);


$i = 1;
foreach ($_POST['ax'] as $key => $value) {
    $temp_array_u[$i]['ax'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['quantity'] as $key => $value) {
    $temp_array_u[$i]['quantity'] = $value;
    $i++;
}

for ($a = 1; $a < $i; $a++) {

    $nums = "SELECT MAX(list_order) AS list_import_id FROM tbl_import_stock_detail 
    WHERE import_id = '$import_id'";
    $qry = mysqli_query($connection, $nums);
    $rows = mysqli_fetch_assoc($qry);
    if ($rows['list_import_id'] < 0) {
        $rows['list_import_id'] = 0;
    }
    // substr ตัดคำ
    $maxId = substr($rows['list_import_id'], 0);
    $maxId = ($maxId + 1);
    $nextId = $maxId;
    $list_order = $nextId;

    $ax = $temp_array_u[$a]['ax'];
    $quantity = $temp_array_u[$a]['quantity'];


    $sql_detail = "INSERT INTO tbl_import_stock_detail
                SET  import_id = '$import_id'
                    ,spare_part_id = '$ax'
                    , quantity = '$quantity'
                    , list_order = '$list_order'
                ";

    $rs_detail = mysqli_query($connection, $sql_detail) or die($connection->error);


}



if ($rs && $rs_detail) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);