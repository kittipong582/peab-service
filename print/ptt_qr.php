<?php
require('fpdf/alphapdf.php');
require("../config/main_function.php");
include("../main/qrcodegenerate/qrlib.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qr_code_id = $row['qr_no'];

@unlink('../main/qrcode/' . $qr_code_id . '.png');
// Add QR code
$tempDir = "../main/qrcode/";
$codeContents = "https://peaberry-care.com/ptt_group/ptt_group.php";
$fileName = $qr_code_id . '.png';
$pngAbsoluteFilePath = $tempDir . $fileName;
$urlRelativeFilePath = $tempDir . $fileName;
// // generating
if (!file_exists($pngAbsoluteFilePath)) {
	QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 15, 0);
}
function removeAccents($str)
{
    $accentedChars = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'à', 'è', 'ì', 'ò', 'ù', 'À', 'È', 'Ì', 'Ò', 'Ù', 'â', 'ê', 'î', 'ô', 'û', 'Â', 'Ê', 'Î', 'Ô', 'Û', 'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'ã', 'õ', 'Ã', 'Õ', 'ñ', 'Ñ', 'ç', 'Ç', 'ÿ', 'Ÿ', 'ø', 'Ø', 'æ', 'Æ', 'å', 'Å', 'ß', 'œ', 'Œ', '€', '£'];
    $nonAccentedChars = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'o', 'A', 'O', 'n', 'N', 'c', 'C', 'y', 'Y', 'o', 'O', 'ae', 'AE', 'a', 'A', 'ss', 'oe', 'OE', 'EUR', 'GBP'];
    return strtr($str, array_combine($accentedChars, $nonAccentedChars));
}


$pdf = new FPDF('P','mm',array(100,120));

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$pdf->AddPage();
$pdf->SetFont('THSarabunNew Bold', '', 14);
// $pdf->SetXY(10, 8);
// $pdf->MultiCell(35, 3, iconv('UTF-8', 'cp874//TRANSLIT//IGNORE', "รหัสร้านค้า : " . $row['branch_code']), 0, 'C', 0);
// $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "ลูกค้า : ".$row['customer_name']), 0, 'C', 0);
// $pdf->SetXY(10, 14); 
// $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "สาขา : " . removeAccents($row['branch_name'])), 0, 'C', 0);
// $pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "สาขา : ".$row['branch_name']), 0, 'C', 0);
/// QR Code
$pdf->Image('../main/qrcode/' . $qr_code_id . '.png', 10, 20, 80, 80, 'PNG');
$pdf->SetFont('THSarabunNew Bold', '', 15);
$pdf->SetXY(10,105);
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "ลูกค้ากลุ่ม PTT"), 0, 'C', 0);

$pdf->Output();
unlink('../main/qrcode/' . $qr_code_id . '.png');


