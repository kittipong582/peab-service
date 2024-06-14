<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$sql = "SELECT COUNT(job_id) AS order_list FROM tbl_job_process_image WHERE job_id = '$job_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$list_order = $row['order_list'] + 1;

$image_id = getRandomID(10, 'tbl_job_process_image', 'image_id');

if ($_FILES['image'] != "") {

    $tmpFilePath_1 = $_FILES['image']['tmp_name'];

    $file_1  = explode(".", $_FILES['image']['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {

        if (move_uploaded_file($_FILES['image']['tmp_name'], "../../../upload/repair_image/" . $filename_images_1)) {

            $sql_insert = "INSERT INTO tbl_job_process_image 
            SET image_id = '$image_id'
            ,job_id = '$job_id'
            ,list_order = '$list_order'
            ,image_path = '$filename_images_1'";
            $rs1 = mysqli_query($connect_db, $sql_insert) or die($connect_db->error);

            if ($rs1) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }
        }
    }
}

echo json_encode($arr);
