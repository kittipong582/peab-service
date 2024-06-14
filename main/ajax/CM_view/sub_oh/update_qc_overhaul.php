<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];
$oh_type = $_POST['oh_type'];
$product_type = $_POST['product_type'];
$product_status = $_POST['product_status'];
$oh_form_id = $_POST['oh_form_id'];
$remark = $_POST['remark'];

$create_datetime = date("y-m-d H:i:s", strtotime('NOW'));




// $sql = "UPDATE tbl_job_oh_form_head
// SET 
// product_type = '$product_type'
// ,product_status = '$product_status'
// ,remark = '$remark'
// WHERE oh_form_id = '$oh_form_id'";
// $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

// // echo $sql;
mysqli_query($connect_db,"DELETE FROM tbl_job_oh_form_detail WHERE oh_form_id = '$oh_form_id'");

$i = 1;
foreach ($_POST['form_id'] as $key => $value) {
    $temp_array_u[$i]['form_id'] = $value;

    $i++;
}

$i = 1;
foreach ($_POST['note'] as $key => $value) {
    $temp_array_u[$i]['note'] = $value;
    $i++;
}

$i = 1;
foreach ($_POST['form_type'] as $key => $value) {
    $temp_array_u[$i]['form_type'] = $value;
    $i++;
}

for ($a = 1; $a < $i; $a++) {
    // $sql3 = "";

    $form_id = $temp_array_u[$a]['form_id'];
    $form_type = $temp_array_u[$a]['form_type'];

    $note = $_POST["note$a"];


    if ($form_type == 1) {

        $select_choice = $_POST["select_choice$a"];


        $sql3 = "INSERT INTO tbl_job_oh_form_detail 
                        SET oh_form_id = '$oh_form_id' 
                            ,form_id = '$form_id'
                            ,select_choice = '$select_choice'
                            ,note = '$note'";
    } else if ($form_type == 2) {

        $choice1_value = $_POST["choice1_value$a"];
        $choice2_value = $_POST["choice2_value$a"];




        $sql3 = "INSERT INTO tbl_job_oh_form_detail 
    SET oh_form_id = '$oh_form_id' 
        ,form_id = '$form_id'
        ,choice1_value = '$choice1_value'
        ,choice2_value = '$choice2_value'
        ,note = '$note'";
    } else if ($form_type == 3) {



        $sql3 = "INSERT INTO tbl_job_oh_form_detail 
    SET  oh_form_id = '$oh_form_id' 
        ,form_id = '$form_id'
        ,note = '$note'";
    }


    $rs_record = mysqli_query($connect_db, $sql3) or die($connect_db->error);
}




if ($a == $i) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}


echo json_encode($arr);
