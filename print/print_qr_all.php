<?php
require('fpdf/alphapdf.php');
require("../config/main_function.php");
include("../main/qrcodegenerate/qrlib.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

function clean($string)
{

    return preg_replace('/[^\p{L}\p{M}\p{Z}\p{N}\p{P}]/u', ' ', $string);
}


function removeAccents($str)
{
    $accentedChars = ['á', 'é', 'í', 'ó', 'ú', 'Á', 'É', 'Í', 'Ó', 'Ú', 'à', 'è', 'ì', 'ò', 'ù', 'À', 'È', 'Ì', 'Ò', 'Ù', 'â', 'ê', 'î', 'ô', 'û', 'Â', 'Ê', 'Î', 'Ô', 'Û', 'ä', 'ë', 'ï', 'ö', 'ü', 'Ä', 'Ë', 'Ï', 'Ö', 'Ü', 'ã', 'õ', 'Ã', 'Õ', 'ñ', 'Ñ', 'ç', 'Ç', 'ÿ', 'Ÿ', 'ø', 'Ø', 'æ', 'Æ', 'å', 'Å', 'ß', 'œ', 'Œ', '€', '£'];
    $nonAccentedChars = ['a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'e', 'i', 'o', 'u', 'A', 'E', 'I', 'O', 'U', 'a', 'o', 'A', 'O', 'n', 'N', 'c', 'C', 'y', 'Y', 'o', 'O', 'ae', 'AE', 'a', 'A', 'ss', 'oe', 'OE', 'EUR', 'GBP'];
    return strtr($str, array_combine($accentedChars, $nonAccentedChars));
}


$page = mysqli_real_escape_string($connect_db, $_GET['page']);
$group = mysqli_real_escape_string($connect_db, $_GET['group']);
$end = number_format($page, 0) + 600;
// $con_group = '';
// if ($group == 0) {
//     $con_group .= 'c.customer_group IS NULL';
// } else {
//     $con_group .= "c.customer_group = '$group'";
// }
$con_group = '';
if ($group == 7) {
    $con_group .= " AND NOT ( b.branch_code LIKE 'CC%' 
    OR b.branch_code LIKE 'SC%' 
    OR b.branch_code LIKE 'SD%' 
    OR b.branch_code LIKE 'RM%' 
    OR b.branch_code LIKE 'JM%' 
    OR b.branch_code LIKE 'DD%' 
    OR b.branch_code LIKE 'CD%'
    OR b.branch_code = 'C1100737' 
    OR b.branch_code = 'C1100738' )";
} else if ($group == 6){
    $con_group .= " AND ( b.branch_code LIKE 'CC%' 
    OR b.branch_code LIKE 'SC%' 
    OR b.branch_code LIKE 'SD%' 
    OR b.branch_code LIKE 'RM%' 
    OR b.branch_code LIKE 'JM%' 
    OR b.branch_code LIKE 'DD%' 
    OR b.branch_code LIKE 'CD%'
    OR b.branch_code = 'C1100737' 
    OR b.branch_code = 'C1100738' )";
}else if ($group == 'x'){
    $con_group .= "";
}

// $sql = "SELECT 
// IF(b.branch_code != 'null' , b.branch_code ,'-') AS branch_code , b.branch_name 
// FROM tbl_customer a 
// LEFT JOIN tbl_customer_branch b ON  b.customer_id = a.customer_id
// LEFT JOIN tbl_qr_code c ON c.branch_id = b.customer_branch_id
// WHERE a.active_status = 1 AND $con_group LIMIT $page , $end";

// LEFT JOIN tbl_customer c ON c.customer_id = b.customer_id
$sql = "SELECT a.*
,IF(b.branch_code != 'null' , b.branch_code ,'-') AS branch_code 
, b.branch_name 
FROM tbl_qr_code a
LEFT JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id

WHERE b.active_status = '1' $con_group
LIMIT $page , $end";
$res = mysqli_query($connect_db, $sql);

// $pdf = new FPDF('P', 'mm', array(210, 297));
$pdf = new FPDF('P', 'mm', array(297, 420));

$pdf->AliasNbPages();
$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$pdf->AddPage();
// $substring = mb_substr($str, 0, 40);
$x = 5;
$y = 5;

// วนลูปแสดงข้อมูลในหน้าปัจจุบัน
while ($row = mysqli_fetch_assoc($res)) {
    // ตรวจสอบว่าต้องขยับตำแหน่ง y ลงมาหรือไม่
    if ($x > 250) {
        $x = 5;
        $y += 50; // ขยับตำแหน่ง y ลงมา
        // ตรวจสอบว่าตำแหน่ง y เกินกว่าที่กำหนดหรือไม่
    }

    if ($y > 370) {
        $pdf->AddPage(); // เพิ่มหน้าใหม่
        $x = 5; // รีเซ็ตตำแหน่ง x
        $y = 5; // รีเซ็ตตำแหน่ง y
    }
    $qr_code_id = $row['qr_no'];

    unlink('../main/qrcode/' . $qr_code_id . '.png');
    // Add QR code
    $tempDir = "../main/qrcode/";
    $codeContents = "http://peaberry-care.com/qr/qr_reader.php?id=" . $qr_code_id;
    $fileName = $qr_code_id . '.png';
    $pngAbsoluteFilePath = $tempDir . $fileName;
    $urlRelativeFilePath = $tempDir . $fileName;
    // // generating
    if (!file_exists($pngAbsoluteFilePath)) {
        QRcode::png($codeContents, $pngAbsoluteFilePath, QR_ECLEVEL_L, 15, 0);
    }
    //echo iconv('UTF-8', 'ISO-8859-1//TRANSLIT//IGNORE', $string);
    // แสดงข้อมูลลูกค้า
    $pdf->SetFont('THSarabunNew Bold', '', 8);
    $pdf->SetXY($x + 2, $y);
    $pdf->MultiCell(35, 3, iconv('UTF-8', 'cp874//TRANSLIT//IGNORE', "รหัสร้านค้า : " . $row['branch_code']), 0, 'C', 0);
    $pdf->SetXY($x + 2, $y + 3);
    $pdf->MultiCell(35, 3, iconv('UTF-8', 'cp874', "สาขา : " . removeAccents($row['branch_name'])), 0, 'C', 0);
    // $pdf->MultiCell(75, 4, iconv('UTF-8', 'cp874//TRANSLIT//IGNORE', "สาขา : " . preg_replace("f'e", "fe", $row['branch_name'])), 0, 'C', 0);

    // แสดงรูป qrcode
    $pdf->Image('../main/qrcode/' . $qr_code_id . '.png', $x + 10, $y + 13, 20, 20, 'PNG');

    // แสดงเลข qr
    $pdf->SetFont('THSarabunNew Bold', '', 8);
    $pdf->SetXY($x - 5, $y + 36);
    $pdf->MultiCell(50, 0, iconv('UTF-8', 'cp874', $row['qr_no']), 0, 'C', 0);

    // ขยับตำแหน่ง x ไปทางขวา
    $x += 40;
}


$pdf->Output();
// $pdf->Output('D', "QRcode_NO".$page_start[0]."-".$page_end[0].".pdf");
unlink('../main/qrcode/' . $qr_code_id . '.png');
