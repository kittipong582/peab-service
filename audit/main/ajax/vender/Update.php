<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = mysqli_real_escape_string($connect_db, $_POST['user_id']);
$username = mysqli_real_escape_string($connect_db, $_POST['username']);
$fullname = mysqli_real_escape_string($connect_db, $_POST['fullname']);
$mobile_phone = mysqli_real_escape_string($connect_db, $_POST['mobile_phone']);
// echo "ersaf";
if ($_POST['mobile_phone'] != "") {

    $newpassword = mysqli_real_escape_string($connect_db, $_POST['mobile_phone']);

    // $password = md5($newpassword);
    // /*  1  secure_text , secure_pointer  */
    // $secure_text = getRandomID(5,'tbl_user','secure_text');
    // $secure_pointer = rand(1,9);
    // $mypassword = stringInsert($password, $secure_text, $secure_pointer);

    UpdatePassword($user_id, $newpassword);
}

$username = mysqli_real_escape_string($connect_db, $_POST['username']);
$mobile_phone = mysqli_real_escape_string($connect_db, $_POST['mobile_phone']);
$office_phone = mysqli_real_escape_string($connect_db, $_POST['office_phone']);
$email = mysqli_real_escape_string($connect_db, $_POST['email']);
$line_id = mysqli_real_escape_string($connect_db, $_POST['line_id']);
$user_level = mysqli_real_escape_string($connect_db, $_POST['user_level_1']);
$branch_id = mysqli_real_escape_string($connect_db, $_POST['branch_id']);

$line_token  = mysqli_real_escape_string($connect_db, $_POST['line_token']);
$line_active  = mysqli_real_escape_string($connect_db, $_POST['line_active']);

$sql_update_user = "UPDATE tbl_user SET fullname = '$fullname'
            ,username = '$username'
            ,mobile_phone = '$mobile_phone'
            ,office_phone = '$office_phone'
            ,email = '$email'
            ,line_id = '$line_id'
            ,line_token = '$line_token'
            ,line_active = '$line_active'";


if ($_FILES["profile_image"]["name"] != "") {
    $allowed = array('gif', 'png', 'jpg', "jpeg");
    $file_type = $_FILES['profile_image']['name'];
    $ext = pathinfo($file_type, PATHINFO_EXTENSION);
    if (in_array($ext, $allowed)) {
        $file = explode(".", $_FILES['profile_image']['name']);
        $file_surname = end($file);
        $filename_images = md5(date("dmYhis") . rand(1000, 9999)) . "." . $file_surname;
        $target_file = "../../upload/" . $filename_images;

        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $target_file)) {

            $sql_update_user .= ", profile_image = '$filename_images' ";
        }
    }
}

$sql_update_user .= " WHERE user_id = '$user_id'";

if ($user_level == 1) {

    $leader_user_id = $_POST['leader_user_id'];

    $sql_update = "UPDATE tbl_user 
    SET staff_team = '$leader_user_id'
    WHERE user_id = '$user_id'";
    mysqli_query($connect_db, $sql_update);
} else {
    $sql_update = "UPDATE tbl_user 
    SET staff_team = null
    WHERE user_id = '$user_id'";
    mysqli_query($connect_db, $sql_update);
}


$zone_id = mysqli_real_escape_string($connect_db, $_POST['zone_id']);
if ($zone_id != "") {


    $sql_update = "UPDATE tbl_user 
    SET zone_id = '$zone_id'
    WHERE user_id = '$user_id'";
    mysqli_query($connect_db, $sql_update);
}

$arr['sql'] = $sql_update_user;
$arr['file'] = $_FILES["profile_image"]["name"];
if (mysqli_query($connect_db, $sql_update_user)) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
