<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$adjust_id = mysqli_real_escape_string($connection, $_POST['adjust_id']);
$branch = mysqli_real_escape_string($connection, $_POST['branch']);
$ax_ref_no = mysqli_real_escape_string($connection, $_POST['ax_ref_no']);
$remark = mysqli_real_escape_string($connection, $_POST['remark']);

$withdraw_date = $_POST['withdraw_date'];
$withdraw_date = str_replace('/', '-', $withdraw_date);
$withdraw_date = date('Y-m-d', strtotime($withdraw_date));

$create_user_id = $_SESSION['user_id'];
$adjust_type = mysqli_real_escape_string($connection, $_POST['adjust_type']);

// 6504xxxxx
$year = date('y') + 43;
$month = date('m');
$job_ex = $year . $month;

$sql_conut = "SELECT count(*) as count1 FROM tbl_adjust_head WHERE adjust_no LIKE '%$job_ex%'";
$rs_conut  = mysqli_query($connection, $sql_conut) or die($connection->error);
$row_conut = mysqli_fetch_assoc($rs_conut);
//  echo $sql_conut;

$count_no = $row_conut['count1'] + 1;
$adjust_no = "AD" . $year . $month . str_pad($count_no, 4, "0", STR_PAD_LEFT);


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


$i = 1;
foreach ($_POST['note'] as $key => $value) {
    $temp_array_u[$i]['note'] = $value;
    $i++;
}

if ($adjust_type == 1) {

    $condition = 0;
    for ($a = 1; $a < $i; $a++) {

        $ax = $temp_array_u[$a]['ax'];
        $quantity = $temp_array_u[$a]['quantity'];

        $sql_chk = "SELECT remain_stock FROM tbl_branch_stock WHERE spare_part_id = '$ax' AND branch_id = '$branch' ;";
        $rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
        $row_chk = mysqli_fetch_assoc($rs_chk);

        $remain_stock = $row_chk['remain_stock'] - $quantity;


        if ($remain_stock < 0) {
            $condition = "x";
        }
    }
}

if ($adjust_type == 2) {

    $condition = 0;
    for ($a = 1; $a < $i; $a++) {

        $ax = $temp_array_u[$a]['ax'];
        $quantity = $temp_array_u[$a]['quantity'];

        $sql_chk = "SELECT remain_stock FROM tbl_branch_stock WHERE spare_part_id = '$ax' AND branch_id = '$branch' ;";
        $rs_chk  = mysqli_query($connection, $sql_chk) or die($connection->error);
        $row_chk = mysqli_fetch_assoc($rs_chk);

        $remain_stock = $row_chk['remain_stock'] + $quantity;


        if ($remain_stock < 0) {
            $condition = "x";
        }
    }
}

if ($condition == 0) {
    /////////////////////////////////////////////////////////////////////////////////////
    $sql = "INSERT INTO tbl_adjust_head
        SET   adjust_id = '$adjust_id'
            ,adjust_no = '$adjust_no'
            ,create_user_id  = '$create_user_id'
            ,adjust_type  = '$adjust_type'
            ,ax_ref_no = '$ax_ref_no'
            ,ax_withdraw_date = '$withdraw_date'
            ,note = '$remark'
            ,receive_branch_id = '$branch' 
            ;";
    $rs = mysqli_query($connection, $sql) or die($connection->error);
    /////////////////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////////////////////////////////////////////

    for ($a = 1; $a < $i; $a++) {



        $ax = $temp_array_u[$a]['ax'];
        $quantity = $temp_array_u[$a]['quantity'];
        $note = $temp_array_u[$a]['note'];


        $sql_detail = "INSERT INTO tbl_adjust_detail
                        SET  adjust_id = '$adjust_id'
                            ,spare_part_id = '$ax'
                            ,quantity = '$quantity'
                            , list_order = '$a'
                            ,remark = '$note'
                        ";

        $rs_detail = mysqli_query($connection, $sql_detail) or die($connection->error);
    }
    $arr['result'] = 1;
    /////////////////////////////////////////////////////////////////////////////////////
} else {
    $arr['result'] = 2;
}



echo json_encode($arr);
mysqli_close($connection);
