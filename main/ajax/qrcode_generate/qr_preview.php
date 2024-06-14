<?php

include("../../../config/main_function.php");
include("../../qrcodegenerate/qrlib.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qr_no = mysqli_real_escape_string($connect_db, $_POST['qr_no']);

$sql = "SELECT * FROM tbl_qr_code WHERE qr_no ='$qr_no'";
$res = mysqli_query($connect_db, $sql);

$row = mysqli_fetch_assoc($res);
$qr_code_id = $row['qr_no'];

unlink('QrCode/' . $qr_code_id . '.jpg');
// Add QR code
$tempDir = "QrCode/";
$codeContents = "http://peaberry-fortest.com/qr/qr_reader.php?id=" . $qr_code_id;
$fileName = $qr_code_id . '.jpg';
$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $tempDir . $fileName;
// // generating
if (!file_exists($pngAbsoluteFilePath)) {
	QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 15, 0);
}

//Set the Content Type
header('Content-type: image/jpeg');
$jpg_image = imagecreatefromjpeg('QrCode/'.$fileName);
// Allocate A Color For The Text
$black = imagecolorallocate($jpg_image, 0, 0, 0);

$newwidth  = 200;
$newheight = 200;

$source = imagecreatefrompng($urlRelativeFilePath);
$thumb  = imagecreatetruecolor($newwidth, $newheight);
// imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);
imagecopyresized($thumb, $source, 0, 0, 0, 0, $newwidth, $newheight, 497, 497);
imagecopymerge($jpg_image, $thumb, 770, 390, 0,0, $newwidth, $newheight, 100);

// Send Image to Browser
imagejpeg($jpg_image);
// Clear Memory
imagedestroy($jpg_image);

?> 