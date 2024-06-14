<?php
session_start();

require '../../vendor/autoload.php';
require '../../function.php';

include("../../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$group_id  = mysqli_real_escape_string($connection, $_POST['group_id']);

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


if ($connection) {

    if (!empty($_POST['signature'])) {
        $signature_name = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . '.png';
        $base64ImageData = $_POST['signature'];

        list(, $base64ImageData) = explode(';', $base64ImageData);
        list(, $base64ImageData) = explode(',', $base64ImageData);

        $decodedImageData = base64_decode($base64ImageData);

        $image = imagecreatefromstring($decodedImageData);

        $width = imagesx($image);
        $height = imagesy($image);

        $outputImage = imagecreatetruecolor($width, $height);
        $transparentColor = imagecolorallocatealpha($outputImage, 0, 0, 0, 127);
        imagefill($outputImage, 0, 0, $transparentColor);
        imagesavealpha($outputImage, true);

        $whiteColor = imagecolorallocate($image, 255, 255, 255);

        for ($x = 0; $x < $width; $x++) {
            for ($y = 0; $y < $height; $y++) {
                $pixelColor = imagecolorat($image, $x, $y);
                if ($pixelColor !== $whiteColor) {
                    imagesetpixel($outputImage, $x, $y, $pixelColor);
                }
            }
        }

        $sig_path = '../../upload/' . $signature_name;
 
        if (imagepng($outputImage,  $sig_path)) {

            $file_Path = __DIR__ . '/../../upload/' . $signature_name;
            $key = basename($file_Path);

            $result = $s3Client->putObject([
                'Bucket' => $bucket,
                'Key'    => $key,
                'Body'   => fopen($file_Path, 'r'),
                'ACL'    => 'public-read', // make file 'public'
            ]);

            $urlFile = $result->get('ObjectURL');

            $date = date("Y-m-d H:i:s");
            
            $sql_update = "UPDATE tbl_job_audit_group SET  
            close_datetime = '$date', 
            signature_image = '$signature_name' 
            WHERE group_id  = '$group_id '";

            $res_update = mysqli_query($connection, $sql_update) or die($connection->error);

            if ($res_update) {
                $arr['result'] = 1;
            } else {
                $arr['result'] = 0;
            }

            unlink($file_Path);
            $arr['result'] = 1; /// มีรูป insert success

          
        }

        imagedestroy($image);
        imagedestroy($outputImage);
    }
} else {
    $arr['result'] = 9;
}

mysqli_close($connection);
echo json_encode($arr);
