<?php

session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

// Requires php5
define('UPLOAD_DIR', '../../upload/signature/');
$img = $_POST['canvasImage'];
$img = str_replace('data:image/png;base64,', '', $img);
$img = str_replace(' ', '+', $img);
$data = base64_decode($img);
$file = UPLOAD_DIR . uniqid() . '.png';
$success = file_put_contents($file, $data);
echo $file;
print $success ? $file : 'Unable to save the file.';


// $file = explode(".", $_FILES['profile_image']['name']);
// $file_surname = end($file);
// $filename_images = md5(date("dmYhis") . rand(1000, 9999)) . "." . $file_surname;
// $target_file = "../../upload/signature/" . $filename_images;
// if (move_uploaded_file($filename_images, $target_file)) {

//     // $sql_update_user .= ", profile_image = '$filename_images' ";


//     echo "test";
// }
