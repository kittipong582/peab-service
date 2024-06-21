<?php
require('fpdf/alphapdf.php');
require("../config/main_function.php");
require('../config/vendor/autoload.php');
$connection = connectDB("LM=VjfQ{6rsm&/h`");

use Aws\S3\S3Client;

$s3 = new S3Client([
    'version' => 'latest',
    'region' => 'ap-southeast-1',
    'credentials' => [
        'key' => 'AKIAZ22PRPGFGD6B2RUO',
        'secret' => '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'
    ]
]);
$bucket = 'peabery-upload';


$job_qc_id = $_GET['job_qc_id'];

$sql = "SELECT b.file_part
    FROM tbl_qc_record a
    LEFT JOIN tbl_qc_record_img b ON a.record_id = b.record_id
    WHERE job_qc_id = '$job_qc_id' AND b.file_part IS NOT NULL
    ORDER BY b.create_datetime ASC
";

$res = mysqli_query($connection, $sql) or die($connection->error);

$list = array();
while ($row = mysqli_fetch_assoc($res)) {
    $temp_arr = [
        "file_part" => $row['file_part']

    ];

    array_push($list, $temp_arr);
}



// // echo $num = mysqli_num_rows($res);

$pdf = new FPDF('P', 'mm', array(210, 297));
// $pdf = new FPDF();
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

foreach ($list as $row) {
    $img = $row['file_part'];
    $fileName = $img;
    $saveAs = 'qc_img/' . basename($fileName);
    try {
        $result = $s3->getObject([
            'Bucket' => $bucket,
            'Key'    => $fileName,
            'SaveAs' => $saveAs,
        ]);
        // echo "File downloaded successfully to {$saveAs}.\n";
    } catch (AwsException $e) {
        echo "Error downloading file: " . $e->getMessage() . "\n";
    }
}

foreach ($list as $row) {

    $pdf->AddPage();
    $img = $row['file_part'];
    $img_pdf = "qc_img/" . $img;
    $pdf->Image($img_pdf, 0, 0, '210', '297', 'jpg');

    unlink($img_pdf);
}

$pdf->Output();
