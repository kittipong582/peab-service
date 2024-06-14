<?php
include("../../../config/main_function.php");
include("../../qrcodegenerate/qrlib.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qty_download = mysqli_real_escape_string($connect_db, $_POST['qty_download']);

$sql = "SELECT * FROM tbl_qr_code WHERE register_datetime IS NULL LIMIT $qty_download";
$res = mysqli_query($connect_db, $sql);

$files = array(); /*Image array*/

while ($row = mysqli_fetch_assoc($res)) {

    // echo $row['qr_no'];

    $qr_code_id = $row['qr_no'];
    unlink('QrCode/' . $qr_code_id . '.png');
    // Add QR code
    $tempDir = "QrCode/";
    $codeContents = "http://peaberry-fortest.com/qr/qr_reader.php?id=" . $qr_code_id;
    $fileName = $qr_code_id . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = $tempDir . $fileName;

    // // generating
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 15, 0);
    }

    array_push($files, $fileName);
    // unlink('../../qrcode/' . $qr_code_id . '.png');
}

function createZipAndDownload($files, $filesPath, $zipFileName)
{
    // Create instance of ZipArchive. and open the zip folder.
    $zip = new \ZipArchive();
    if ($zip->open($zipFileName, \ZipArchive::CREATE) !== TRUE) {
        exit("cannot open <$zipFileName>\n");
    }

    // Adding every attachments files into the ZIP.
    foreach ($files as $file) {
        $zip->addFile($filesPath . $file, $file);
    }
    $zip->close();

    // Download the created zip file
    header("Content-type: application/zip");
    header("Content-Disposition: attachment; filename = $zipFileName");
    header("Pragma: no-cache");
    header("Expires: 0");
    readfile("$zipFileName");

    foreach ($files as $file) {
        unlink('QrCode/' . $file);
    }
    exit;
}

// Files which need to be added into zip
// $files = array('sample.php', 'sample.jpg', 'sample.pdf', 'sample.doc');
// Directory of files
$filesPath = 'QrCode/';
// Name of creating zip file
$zipName = 'qr_code.zip';

if (createZipAndDownload($files, $filesPath, $zipName)) {
    $arr['result'] = 1;
}
