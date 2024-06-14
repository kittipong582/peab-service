<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$manual_name = mysqli_real_escape_string($connect_db, $_POST['manual_name']);
$remark = mysqli_real_escape_string($connect_db, $_POST['remark']);
$manual_id = mysqli_real_escape_string($connect_db, $_POST['manual_id']);

$sql = "SELECT MAX(list_order) as last_list_order FROM tbl_spare_part_manual_sub WHERE manual_id = '$manual_id'";
$rs = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($rs);
$list_order = $row['last_list_order'] + 1;

require '../../../staff/main/vendor/autoload.php';
require '../../../staff/main/function.php';

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



if ($_FILES['file_name'] != "") {

    $tmpFilePath_1 = $_FILES['file_name']['tmp_name'];

    $file_1  = explode(".", $_FILES['file_name']['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG' || $file_surname_1 == 'PDF' || $file_surname_1 == 'pdf') {

        if (move_uploaded_file($tmpFilePath_1, "../../upload/repair_image/" . $filename_images_1)) {

            $file_Path = __DIR__ . '/../../upload/repair_image/' . $filename_images_1;
            $key = basename($file_Path);

            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read', // make file 'public'
            ]);

            $urlFile = $result->get('ObjectURL');

            $condition_sql = ",file_name = '$filename_images_1'";


            unlink($file_Path);
        }
    }
}



$sql_insert = "INSERT INTO tbl_spare_part_manual_sub SET 
manual_sub_name = '$manual_name', 
remark = '$remark',
manual_id = '$manual_id',
list_order = '$list_order'
$condition_sql";

if (mysqli_query($connect_db, $sql_insert)) {
    $arr['sql'] = $sql_insert;
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
