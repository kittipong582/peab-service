<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];


$type = $_POST['type'];

$start_service_time = date('Y-m-d H:i:s');

require '../../vendor/autoload.php';
require '../../function.php';


use Aws\S3\S3Client;
// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region'  => 'ap-southeast-1',
    'credentials' => [
        'key'    => 'AKIAZ22PRPGFGD6B2RUO',
        'secret' => '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'
    ]
]);

$bucket = 'peabery-upload';


if ($_FILES["anyfile"] != "") {

    $tmpFilePath_1 = $_FILES["anyfile"]['tmp_name'];

    $file_1  = explode(".", $_FILES["anyfile"]['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {

        if (move_uploaded_file($_FILES["anyfile"]['tmp_name'], "../../upload/" . $filename_images_1)) {

            $file_Path = __DIR__ . '/../../upload/' . $filename_images_1;
            $key = basename($file_Path);

            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read', // make file 'public'
            ]);

            $urlFile = $result->get('ObjectURL');


            if ($type == 1) {
                $job_id = $_POST['job_id'];
                $sql = "UPDATE tbl_job
                   SET check_in_img = '$filename_images_1' 
                       ,start_service_time = '$start_service_time' 
                   WHERE job_id = '$job_id' ;";
                $rs = mysqli_query($connect_db, $sql);
            } else if ($type == 4) {

                $job_id = $_POST['job_id'];
               $sql = "UPDATE tbl_job_oh
                   SET check_in_img = '$filename_images_1' 
                    ,check_in_datetime = '$start_service_time' 
                    WHERE job_id = '$job_id' and user_id = '$user_id';";
                $rs = mysqli_query($connect_db, $sql);

            } else if ($type == 2) {
                $group_pm_id = $_POST['job_id'];
                $sql_detail = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
                $result_detail  = mysqli_query($connect_db, $sql_detail);
                while ($row_detail = mysqli_fetch_array($result_detail)) {

                    $job_id = $row_detail['job_id'];

                    $sql = "UPDATE tbl_job
                            SET check_in_img = '$filename_images_1' 
                            ,start_service_time = '$start_service_time' 
                            WHERE job_id = '$job_id' ;";

                    $rs = mysqli_query($connect_db, $sql);
                    // echo $sql;
                }

                $sql_group = "UPDATE tbl_group_pm
                        SET check_in_img = '$filename_images_1' 
                        ,start_service_time = '$start_service_time' 
                        WHERE group_pm_id = '$group_pm_id' ;";
                $rs_group = mysqli_query($connect_db, $sql_group);
            }

            unlink($file_Path);
            if ($rs) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }
        }
    }
}


// Check if the form was submitted
// if ($_SERVER["REQUEST_METHOD"] == "POST") {

//     // Check if file was uploaded without errors
//     if (isset($_FILES["anyfile"]) && $_FILES["anyfile"]["error"] == 0) {

//         $allowed = array("jpg" => "image/jpg", "jpeg" => "image/jpeg", "gif" => "image/gif", "png" => "image/png");
//         $filename = $_FILES["anyfile"]["name"];
//         $filetype = $_FILES["anyfile"]["type"];
//         $filesize = $_FILES["anyfile"]["size"];

//         // Validate file extension
//         $ext = pathinfo($filename, PATHINFO_EXTENSION);

//         if (!array_key_exists($ext, $allowed)) die("Error: Please select a valid file format.");
//         // Validate file size - 10MB maximum
//         $maxsize = 10 * 1024 * 1024;

//         if ($filesize > $maxsize) die("Error: File size is larger than the allowed limit.");
//         // Validate type of the file

//         if (in_array($filetype, $allowed)) {
//             // Check whether file exists before uploading it

//             if (file_exists("../../upload/" . $filename)) {
//                 // echo $filename . " is already exists.";
//                 $arr['result'] = 2; /////////////////ซ้ำ
//             } else {

//                 if (move_uploaded_file($_FILES["anyfile"]["tmp_name"], "../../upload/" . $filename)) {
//                     $file_Path = __DIR__ . '/../../upload/' . $filename;
//                     $key = basename($file_Path);
//                     try {
//                         $result = $s3Client->putObject([
//                             'Bucket' => $bucket,
//                             'Key'    => $key,
//                             'Body'   => fopen($file_Path, 'r'),
//                             'ACL'    => 'public-read', // make file 'public'
//                         ]);

//                         $urlFile = $result->get('ObjectURL');

//                         // echo "Image uploaded successfully. Image path is: " . $result->get('ObjectURL');
//                         if ($type == 1) {
//                             $job_id = $_POST['job_id'];
//                             $sql = "UPDATE tbl_job
//                                SET check_in_img = '$filename' 
//                                    ,start_service_time = '$start_service_time' 
//                                WHERE job_id = '$job_id' ;";
//                             $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
//                         } else {
//                             $group_pm_id = $_POST['job_id'];
//                             $sql_detail = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
//                             $result_detail  = mysqli_query($connect_db, $sql_detail);
//                             while ($row_detail = mysqli_fetch_array($result_detail)) {

//                                 $job_id = $row_detail['job_id'];

//                                 $sql = "UPDATE tbl_job
//                                         SET check_in_img = '$filename' 
//                                         ,start_service_time = '$start_service_time' 
//                                         WHERE job_id = '$job_id' ;";

//                                 $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
//                             }

//                             $sql_group = "UPDATE tbl_group_pm
//                                     SET check_in_img = '$filename' 
//                                     ,start_service_time = '$start_service_time' 
//                                     WHERE group_pm_id = '$group_pm_id' ;";
//                             $rs_group = mysqli_query($connect_db, $sql_group) or die($connect_db->error);
//                         }

//                         unlink($file_Path);
//                     } catch (Aws\S3\Exception\S3Exception $e) {
//                         // echo "There was an error uploading the file.\n";
//                         // echo $e->getMessage();
//                     }


//                     // echo "Your file was uploaded successfully.";
//                     $arr['result'] = 1; /////////////////สำเร็จ
//                 } else {
//                     $arr['result'] = 0; ////////////////อัพไม่ได้
//                 }
//             }
//         } else {
//             // echo "Error: There was a problem uploading your file. Please try again.";
//             $arr['result'] = 3; ////////////////ไฟล์ไม่ถูกต้อง
//         }
//     } else {
//         // echo "Error: " . $_FILES["anyfile"]["error"];
//         $arr['result'] = 4; ////////////////ไฟล์มีปัญหา
//     }
// }


echo json_encode($arr);
mysqli_close($connect_db);
