<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$fullname = mysqli_real_escape_string($connect_db, $_POST['fullname']);
$username = mysqli_real_escape_string($connect_db, $_POST['username']);
$newpassword = mysqli_real_escape_string($connect_db, $_POST['mobile_phone']);

$password = md5($newpassword);
/*  1  secure_text , secure_pointer  */
$secure_text = getRandomID(5,'tbl_user','secure_text');
$secure_pointer = rand(1,9);
$mypassword = stringInsert($password, $secure_text, $secure_pointer);

$user_id = CreateUser($username, $mypassword, $fullname);

if ($user_id) {

    $mobile_phone = mysqli_real_escape_string($connect_db, $_POST['mobile_phone']);
    $office_phone = mysqli_real_escape_string($connect_db, $_POST['office_phone']);
    $email = mysqli_real_escape_string($connect_db, $_POST['email']);
    $line_id = mysqli_real_escape_string($connect_db, $_POST['line_id']);
    $user_level = mysqli_real_escape_string($connect_db, $_POST['user_level_1']);
    $branch_id = mysqli_real_escape_string($connect_db, $_POST['branch_id']);


    $sql_update_user = "UPDATE tbl_user SET 
				mobile_phone = '$mobile_phone'
				,office_phone = '$office_phone'
				,email = '$email'
                ,vender_status = '1'
				,line_id = '$line_id'";
   
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
    mysqli_query($connect_db, $sql_update_user);

    if ($user_level == 1) {

        $leader_user_id = $_POST['leader_user_id'];

        $sql_update = "UPDATE tbl_user 
        SET staff_team = '$leader_user_id'
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
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

$arr['user_id'] = $user_id;

echo json_encode($arr);
