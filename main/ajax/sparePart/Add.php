<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_part_id = mysqli_real_escape_string($connect_db, $_POST['spare_part_id']);
$spare_part_name = mysqli_real_escape_string($connect_db, $_POST['spare_part_name']);
$spare_part_barcode = mysqli_real_escape_string($connect_db, $_POST['spare_part_barcode']);
$spare_part_code = mysqli_real_escape_string($connect_db, $_POST['spare_part_code']);
$spare_part_unit = mysqli_real_escape_string($connect_db, $_POST['spare_part_unit']);
$spare_part_des = mysqli_real_escape_string($connect_db, $_POST['spare_part_des']);
$spare_type_id = mysqli_real_escape_string($connect_db, $_POST['spare_type_id']);
$default_cost = mysqli_real_escape_string($connect_db, $_POST['default_cost']);
$manufacturer = mysqli_real_escape_string($connect_db, $_POST['manufacturer']);
$makker_code = mysqli_real_escape_string($connect_db, $_POST['makker_code']);


if ($default_cost == "") {
    $default_cost = 0;
}

$sql_insert = "INSERT INTO tbl_spare_part SET 
spare_part_id = '$spare_part_id', 
spare_type_id = '$spare_type_id', 
spare_barcode = '$spare_part_barcode', 
spare_part_name = '$spare_part_name',
spare_part_code = '$spare_part_code', 
spare_part_unit = '$spare_part_unit', 
default_cost = '$default_cost',
manufacturer = '$manufacturer',
makker_code = '$makker_code', 
spare_part_des = '$spare_part_des'";

if ($_FILES["spare_part_image"]["name"] != "") {
    $allowed = array('gif', 'png', 'jpg', "jpeg");
    $file_type = $_FILES['spare_part_image']['name'];
    $ext = pathinfo($file_type, PATHINFO_EXTENSION);
    if (in_array($ext, $allowed)) {
        $file = explode(".", $_FILES['spare_part_image']['name']);
        $file_surname = end($file);
        $filename_images = md5(date("dmYhis") . rand(1000, 9999)) . "." . $file_surname;
        $target_file = "../../upload/" . $filename_images;

        if (move_uploaded_file($_FILES["spare_part_image"]["tmp_name"], $target_file)) {

            $sql_insert .= ", spare_part_image = '$filename_images' ";
        }
    }
}

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

$arr['user_id'] = $user_id;

echo json_encode($arr);
