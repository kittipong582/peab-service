<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$product_type = $_POST['product_type'];
$job_id = $_POST['job_id'];
$product_id = $_POST['product_id'];
$remark = $_POST['remark'];

$sql_job = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs_job = mysqli_query($connect_db, $sql_job);
$row_job = mysqli_fetch_assoc($rs_job);


// var_dump($_POST);
$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));



$i = 1;
foreach ($_POST['form_id'] as $key => $value) {
    $temp_array_u[$i]['form_id'] = $value;

    $i++;
}




for ($a = 1; $a < $i; $a++) {



    $form_id = $temp_array_u[$a]['form_id'];

    $sql_chk = "SELECT form_type,have_remark FROM tbl_technical_form WHERE form_id = '$form_id'";
    $result_chk  = mysqli_query($connect_db, $sql_chk);
    $row_chk = mysqli_fetch_array($result_chk);

    if ($row_chk['form_type'] == 1 && $row_chk['have_remark'] == 0) {

        $select_choice = $_POST["select_choice$a"];


        $sql3 = "UPDATE tbl_job_form 
    SET 
    select_choice = '$select_choice'
    WHERE job_id = '$job_id' and form_id = '$form_id'
    ";

        $rs_record = mysqli_query($connect_db, $sql3) or die($connect_db->error);
    } else if ($row_chk['form_type'] == 1 && $row_chk['have_remark'] == 1) {

        $select_choice = $_POST["select_choice$a"];
        $note = $_POST["note$a"];


        $sql3 = "UPDATE tbl_job_form 
    SET select_choice = '$select_choice'
    ,note = '$note'
    WHERE job_id = '$job_id' and form_id = '$form_id'
    ";
        $rs_record = mysqli_query($connect_db, $sql3) or die($connect_db->error);
    } else if ($row_chk['form_type'] == 2) {

        $choice1_value = $_POST["choice1_value$a"];
        $choice2_value = $_POST["choice2_value$a"];


        $sql3 = "UPDATE tbl_job_form 
        SET choice1_value = '$choice1_value'
        ,choice2_value = '$choice2_value'
        WHERE job_id = '$job_id' and form_id = '$form_id'";
        // echo $sql3;
        $rs_record = mysqli_query($connect_db, $sql3) or die($connect_db->error);
    }
}

$i = 0;
$sql_el = "SELECT * FROM tbl_job_evaluate WHERE job_type = '{$row_job['job_type']}' ORDER BY list_order ASC";
$rs_el = mysqli_query($connect_db, $sql_el);
while ($row_el = mysqli_fetch_assoc($rs_el)) {
    $i++;
    $choice_score = $_POST['choice_el_' . $row_el['evaluate_id']];

    $sql_el1 = "UPDATE tbl_job_evaluate_record 
SET 
evaluate_score = '$choice_score'
WHERE job_id = '$job_id' AND evaluate_id = '{$row_el['evaluate_id']}'
";
    $rs_el1 = mysqli_query($connect_db, $sql_el1) or die($connect_db->error);
}




$sql4 = "UPDATE tbl_job_form_remark 
SET remark = '$remark'
WHERE job_id = '$job_id'AND product_id = '$product_id'
";

// echo $sql3;
$rs4 = mysqli_query($connect_db, $sql4) or die($connect_db->error);


// if ($rs_record) {
    $arr['result'] = 1;
// } else {
//     $arr['result'] = 0;
// }

echo json_encode($arr);
