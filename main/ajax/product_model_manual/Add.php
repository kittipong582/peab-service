<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];
$manaul_name = $_POST['manaul_name'];
$description = $_POST['description'];
$model_id = $_POST['model_id'];



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
$key  = $_FILES['image']['name'];
$i = 0;
$sql = "SELECT COUNT(model_id) AS order_list FROM tbl_product_model_manual WHERE model_id = '$model_id'";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);
$row = mysqli_fetch_assoc($rs);

$list_order = ($row['order_list'] + 1);

$file_1  = explode(".", $key);

$count1 = count($file_1) - 1;

$file_surname_1 = $file_1[$count1];

$files_tmp = $_FILES['image']['tmp_name'];

$filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'pdf' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG'|| $file_surname_1 == 'PDF') {

    if (move_uploaded_file($files_tmp, "../../upload/model_manual/" . $filename_images_1)) {

        $file_Path = __DIR__ . '/../../upload/model_manual/' . $filename_images_1;
        $key = basename($file_Path);

        $result = $s3Client->putObject([
            'Bucket' => $bucket,
            'Key'    => $key,
            'Body'   => fopen($file_Path, 'r'),
            'ACL'    => 'public-read', // make file 'public'
        ]);

        $urlFile = $result->get('ObjectURL');

        $condition = ",manual_image = '$filename_images_1'";

        unlink($file_Path);
    }
}


$sql_fixed = "INSERT INTO tbl_product_model_manual
                SET  manaul_name = '$manaul_name'
                    ,model_id	 = '$model_id'
                    ,description = '$description'
                    ,list_order = '$list_order'
                    $condition
                ";

$rs_fixed = mysqli_query($connect_db, $sql_fixed) or die($connect_db->error);




if ($rs_fixed) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);
