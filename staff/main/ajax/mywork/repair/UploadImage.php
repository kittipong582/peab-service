<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$fixed_id = $_POST['fixed_id'];
$sql = "SELECT COUNT(fixed_id) AS order_list FROM tbl_job_process_image WHERE fixed_id = '$fixed_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$list_order = $row['order_list'] + 1;



require '../../../vendor/autoload.php';
require '../../../function.php';


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

$files_name  = $_FILES['image']['name'];
$i = 0;
foreach ($files_name as $key) {

    // echo $i;
    $file_1  = explode(".", $key);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $files_tmp = $_FILES['image']['tmp_name'][$i];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {

        if (move_uploaded_file($files_tmp, "../../../../../main/upload/repair_image/" . $filename_images_1)) {


            $file_Path = __DIR__ . '/../../../../../main/upload/repair_image/' . $filename_images_1;
            $key = basename($file_Path);

            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read', // make file 'public'
            ]);

            $urlFile = $result->get('ObjectURL');

            $sql_insert = "INSERT INTO tbl_job_process_image 
            SET fixed_id = '$fixed_id'
            ,list_order = '$list_order'
            ,image_path = '$filename_images_1'";
            $rs1 = mysqli_query($connect_db, $sql_insert) or die($connect_db->error);

            // echo $sql_insert;

            unlink($file_Path);
        }
    }
    $i++;
}


if ($rs1) {
    $arr['result'] = 1;
    $arr['fixed_id'] = $fixed_id;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
