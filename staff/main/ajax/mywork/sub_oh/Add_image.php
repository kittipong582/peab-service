<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$sub_job_id = $_POST['sub_job_id'];
$create_datetime = date("Y-m-d H:i", strtotime("NOW"));


$files_name  = $_FILES['image']['name'];
$count_array = count($files_name);
$i = 0;
foreach ($files_name as $key) {

    $sql = "SELECT COUNT(job_image_id) AS order_list FROM tbl_job_image WHERE job_id = '$job_id' and sub_job_id = '$sub_job_id'";
    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
    $row = mysqli_fetch_assoc($rs);

    $list_order = $row['order_list'] + 1;

    $file_1  = explode(".", $key);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $files_tmp = $_FILES['image']['tmp_name'][$i];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {

        if (move_uploaded_file($files_tmp, "../../../../../main/upload/job_image/" . $filename_images_1)) {

            $sql_insert = "INSERT INTO tbl_job_image 
            SET job_id = '$job_id'
            ,list_order = '$list_order'
            ,sub_job_id = '$sub_job_id'
            ,image_name = '$filename_images_1'";
            $rs1 = mysqli_query($connect_db, $sql_insert) or die($connect_db->error);
            if ($rs1) {
                $i++;
            }
        }
    }
}



if ($i == $count_array) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);
