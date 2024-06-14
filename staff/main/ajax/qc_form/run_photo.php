<?php
session_start();
// @include ("../../../../config/main_function.php");
include ("../../../../config/main_function.php");
require '../../vendor/autoload.php';
require '../../function.php';

$connection = connectDB("LM=VjfQ{6rsm&/h`");





use Aws\S3\S3Client;

// Instantiate an Amazon S3 client.
$s3Client = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-1',
    'credentials' => [
        'key' => 'AKIAZ22PRPGFGD6B2RUO',
        'secret' => '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'
    ]
]);
$bucket = 'peabery-upload';

$sql = "SELECT * FROM tbl_qc_record_img WHERE job_qc_id IN(SELECT job_qc_id  FROM tbl_job_qc)";
$res = mysqli_query($connection, $sql);
echo$row_num = mysqli_num_rows($res);

while ($row = mysqli_fetch_assoc($res)) {



    // $file_Path = __DIR__ . '../../upload/qc_img/' . $filename_images_1;
   echo $file_Path = "../../upload/qc_img/" . $row['file_part'];
    // $key = basename($file_Path);
    // $bucket;
    // $result = $s3Client->putObject([
    //     'Bucket' => $bucket,
    //     'Key' => $key,
    //     'Body' => fopen($file_Path, 'r'),
    //     'ACL' => 'public-read', // make file 'public'
    // ]);

    // $urlFile = $result->get('ObjectURL');
}