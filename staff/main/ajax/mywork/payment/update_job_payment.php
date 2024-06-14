<?php
session_start();
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$job_id = $_POST['job_id'];
$payment_id = $_POST['payment_id'];
$total_amount = str_replace(',', '', $_POST['all_total']);
$account_id = $_POST['account_id'];
$cash_amount = $_POST['cash_amount'];
$transfer_amount = $_POST['transfer_amount'];
$customer_cost = $_POST['customer_cost'];
$payment_note = $_POST['payment_note'];
$job_id = $_POST['job_id'];

$sql = "UPDATE tbl_job_payment_file 
SET total_amount = '$total_amount'
,account_id = '$account_id'
,cash_amount = '$cash_amount'
,transfer_amount = '$transfer_amount'
,customer_cost = '$customer_cost'
,remark = '$payment_note'
,create_user_id = '$create_user_id'
WHERE payment_id = '$payment_id'";


$rs_insert = mysqli_query($connect_db, $sql) or die($connect_db->error);


$sql_del_img = "DELETE FROM tbl_job_payment_img WHERE payment_id = '$payment_id'";
$rs_del_img = mysqli_query($connect_db, $sql_del_img) or die($connect_db->error);


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


$files_name  = $_FILES['image1']['name'];
$i = 0;
foreach ($files_name as $key) {


    $file_1  = explode(".", $key);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];
    $files_tmp = $_FILES['image1']['tmp_name'][$i];
    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {


        if (move_uploaded_file($files_tmp, "../../../upload/payment_img/" . $filename_images_1)) {

            $file_Path = __DIR__ . '/../../../upload/payment_img/' . $filename_images_1;
            $key = basename($file_Path);

            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read', // make file 'public'
            ]);
            $urlFile = $result->get('ObjectURL');


            $sql1 = "INSERT INTO tbl_job_payment_img SET img_id = '$filename_images_1'
                    ,payment_id = '$payment_id'
                    ;";

            $rs1 = mysqli_query($connect_db, $sql1) or die($connect_db->error);

            unlink($file_Path);
        }
    }
    $i++;
}

if ($rs_insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}



echo json_encode($arr);
