<?php
require('./fpdf/alphapdf.php');
require("../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");




// echo $sql_customer;
//$pdf->SetLineWidth(0.8); //ขนาดของเส้น
//$pdf->SetDrawColor(238, 44, 44); //สีของเส้น
//$pdf->Line(145, 25, 190, 25); //โค้ดเส้นบรรทัด

//$pdf->Image('check_mark.png', 27.5, 131.5, 5, 5, 'PNG');//ติ๊กถูก -3.3 จากตัวหนังสือ
//$pdf->Image('circle_mark.png', 64, 76, 8, 6, 'PNG');//วงกลม -2.3 จากตัวหนังสือ (สั้น 8 ยาว 14)
//$pdf->Image('wing_mark.png', 50, 71, 5, 7, 'PNG');//สี่เหลี่ยมด้านมน -3.3 จากตัวหนังสือ
//$pdf->Image('scissors_mark.png', 50, 71, 5, 7, 'PNG');//กรรไกร
//
$set_page = 4.42 + (15 * 0.15);

$pdf = new FPDF('P', 'in', array(2.83, $set_page));
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$pdf->AddPage();
$pdf->Image('Receipt CRM_page-0001.jpg', 71, 254, 0, 0, 'JPG'); //print_hrt_admonition_book
//$pdf->Image('print_hrt_admonition_book.jpg', 0, 0, 210, 297, 'JPG');//print_hrt_admonition_book

// //------------------------------------------------หัวกรดาษ------------------------

$pdf->SetTextColor(0, 0, 0, 255);
$pdf->SetFont('THSarabunNew Bold', '', 10.5);
$pdf->SetXY(0, 0); //บริษัท พีเบอร์รี่ ไทย จำกัด
$pdf->MultiCell(1.9, 0.7, iconv('UTF-8', 'cp874', "บริษัท พีเบอร์รี่ ไทย จำกัด"), 0, 'R', 0);
$pdf->SetXY(0, 0); //123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา
$pdf->MultiCell(2.25, 1.4, iconv('UTF-8', 'cp874', "123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา"), 0, 'R', 0);
$pdf->SetXY(0, 0); //123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา
$pdf->MultiCell(2.01, 1.7, iconv('UTF-8', 'cp874', "จังหวัดกรุงเทพมหานคร  10120"), 0, 'R', 0);

$pdf->SetXY(0, 0); //โทรศัพท์
$pdf->MultiCell(0.52, 2, iconv('UTF-8', 'cp874', "โทรศัพท์"), 0, 'R', 0);
$pdf->SetXY(0, 0); //โทรศัพท์
$pdf->MultiCell(1.2, 2, iconv('UTF-8', 'cp874', "02-681-2424"), 0, 'R', 0);

$pdf->SetXY(0, 0); //เลขประจำตัวผู้เสียภาษี
$pdf->MultiCell(1.01, 2.3, iconv('UTF-8', 'cp874', "เลขประจำตัวผู้เสียภาษี"), 0, 'R', 0);
$pdf->SetXY(0, 0); //เลขประจำตัวผู้เสียภาษี
$pdf->MultiCell(1.8, 2.3, iconv('UTF-8', 'cp874', "0105563135500"), 0, 'R', 0);

$pdf->SetXY(0, 0); //สาขาที่ออกเอกสาร
$pdf->MultiCell(0.87, 2.6, iconv('UTF-8', 'cp874', "สาขาที่ออกเอกสาร"), 0, 'R', 0);
$pdf->SetXY(0, 0); //สาขาที่ออกเอกสาร
$pdf->MultiCell(1.5, 2.6, iconv('UTF-8', 'cp874', "สำนักงานใหญ่"), 0, 'R', 0);


////---------------------------------------------------------------------

$pdf->SetXY(0, 0); //ใบเสร็จเงินชั่วคราว
$pdf->MultiCell(1.8, 3.2, iconv('UTF-8', 'cp874', "ใบเสร็จเงินชั่วคราว"), 0, 'R', 0);

$pdf->SetXY(0, 0); //วันที่
$pdf->MultiCell(0.38, 3.65, iconv('UTF-8', 'cp874', "วันที่"), 0, 'R', 0);
$pdf->SetXY(0, 0); //วันที่
$pdf->MultiCell(0.9, 3.65, iconv('UTF-8', 'cp874',  "01-01-2023"), 0, 'R', 0);


$pdf->SetXY(0, 0); //เวลา
$pdf->MultiCell(2.4, 3.65, iconv('UTF-8', 'cp874', "เวลา"), 0, 'R', 0);
$pdf->SetXY(0, 0); //เวลา
$pdf->MultiCell(2.7, 3.65, iconv('UTF-8', 'cp874', "00:00:00"), 0, 'R', 0);


$pdf->SetXY(0, 0); //เลขที่ใบเสร็จรับเงิน
$pdf->MultiCell(0.88, 4, iconv('UTF-8', 'cp874', "เลขที่ใบเสร็จรับเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //เลขที่ใบเสร็จรับเงิน
$pdf->MultiCell(2.7, 4, iconv('UTF-8', 'cp874', "IV.................................."), 0, 'R', 0);

$pdf->SetXY(0, 0); //ผู้ซื้อ
$pdf->MultiCell(0.43, 4.5, iconv('UTF-8', 'cp874', "ผู้ซื้อ :"), 0, 'R', 0);
$pdf->SetXY(0.42, 2.19); //ผู้ซื้อ
$pdf->MultiCell(1.85, 0.137, iconv('UTF-8', 'cp874', "ผู้ซื้อทดสอบ"), 0, 'L', 0);

$pdf->SetXY(0, 0); //ที่อยู่
$pdf->MultiCell(0.43, 4.8, iconv('UTF-8', 'cp874', "ที่อยู่ :"), 0, 'R', 0);
$pdf->SetXY(0.42, 2.34); //ที่อยู่
$pdf->MultiCell(2.0, 0.137, iconv('UTF-8', 'cp874', " อีกหนึ่ง ไอเท็มใหม่ ที่ เรา ตั้งใจคิดค้น, ออกแบบ และ ผลิตขึ้นมา เพื่อช่วยเพิ่มความมั่นใจ"), 0, 'L', 0);
// $pdf->SetXY(0, 0); //ที่อยู่
// $pdf->MultiCell(1.41, 5.1, iconv('UTF-8', 'cp874', ""), 0, 'R', 0);

$pdf->SetXY(0, 0); //Tax ID 
$pdf->MultiCell(0.53, 5.4, iconv('UTF-8', 'cp874', "Tax ID :"), 0, 'R', 0);
$pdf->SetXY(0.52, 2.64); //Tax ID 
$pdf->MultiCell(0.8, 0.137, iconv('UTF-8', 'cp874', "111111111111111111"), 0, 'L', 0);



$pdf->SetXY(0, 0); //รายการ 
$pdf->MultiCell(0.6, 5.9, iconv('UTF-8', 'cp874', "รายการ"), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวน 
$pdf->MultiCell(1.3, 5.9, iconv('UTF-8', 'cp874', "จำนวน"), 0, 'R', 0);

$pdf->SetXY(0, 0); //ราคา 
$pdf->MultiCell(1.9, 5.9, iconv('UTF-8', 'cp874', "ราคา"), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวนเงิน 
$pdf->MultiCell(2.6, 5.9, iconv('UTF-8', 'cp874', "จำนวนเงิน"), 0, 'R', 0);


////----------------------------------------------------------------------------


// $pdf->SetXY(0, 0);//รายการ
// $pdf->MultiCell(0.6, 6.2, iconv('UTF-8', 'cp874', "SP00386"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//จำนวน 
// $pdf->MultiCell(1.2, 6.2, iconv('UTF-8', 'cp874', "3"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//ราคา
// $pdf->MultiCell(2, 6.2, iconv('UTF-8', 'cp874', "95.00"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//จำนวนเงิน 
// $pdf->MultiCell(2.7, 6.2, iconv('UTF-8', 'cp874', "285.00"), 0, 'R', 0);



$c = 6.2;

// echo $sql;
$list = 1;
while ($list <= 15) {


    $pdf->SetXY(0, 0); //รายการ
    $pdf->MultiCell(0.6, $c, iconv('UTF-8', 'cp874', "xxxxxxxxxxxxxxxxxxxxxxx"), 0, 'R', 0);

    $pdf->SetXY(0, 0); //จำนวน 
    $pdf->MultiCell(1.2, $c, iconv('UTF-8', 'cp874', "100"), 0, 'R', 0);

    $pdf->SetXY(0, 0); //ราคา
    $pdf->MultiCell(2, $c, iconv('UTF-8', 'cp874', "1000.00"), 0, 'R', 0);

    $pdf->SetXY(0, 0); //จำนวนเงิน 
    $pdf->MultiCell(2.7, $c, iconv('UTF-8', 'cp874', "100,000.00"), 0, 'R', 0);

    $c = $c + 0.3;
    $list++;
}
// echo $img_position;
$b = $c;

$tax = (100000 * 7) / 100;


$pdf->SetXY(0, 0); //รวมเป็นเงิน 
$pdf->MultiCell(2, $b + 0.4, iconv('UTF-8', 'cp874', "รวมเป็นเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //รวมเป็นเงิน 
$pdf->MultiCell(2.7, $b + 0.4, iconv('UTF-8', 'cp874', "1,500,000.00"), 0, 'R', 0);

$pdf->SetXY(0, 0); //ภาษีมูลค่าเพิ่ม 
$pdf->MultiCell(2, $b + 0.7, iconv('UTF-8', 'cp874', "ภาษีมูลค่าเพิ่ม"), 0, 'R', 0);
$pdf->SetXY(0, 0); //ภาษีมูลค่าเพิ่ม 
$pdf->MultiCell(2.7, $b + 0.7, iconv('UTF-8', 'cp874', number_format($tax, 2)), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวนเงินรวมทั้งสิ้น 
$pdf->MultiCell(2, $b + 1, iconv('UTF-8', 'cp874', "จำนวนเงินรวมทั้งสิ้น"), 0, 'R', 0);
$pdf->SetXY(0, 0); //จำนวนเงินรวมทั้งสิ้น 
$pdf->MultiCell(2.7, $b + 1, iconv('UTF-8', 'cp874', number_format((1500000 + $tax), 2)), 0, 'R', 0);

$pdf->SetXY(0, 0); //ผู้รับบริหาร 
$pdf->MultiCell(0.65, $b + 1.5, iconv('UTF-8', 'cp874', "ผู้รับบริการ"), 0, 'R', 0);
$pdf->SetXY(50, 50); // ผู้รับบริหาร
// $pdf->MultiCell(1.3, $b + 1.5, iconv('UTF-8', 'cp874', $src), 0, 'R', 0);



$pdf->SetXY(0, 0); //ผู้รับเงิน 
$pdf->MultiCell(2, $b + 1.5, iconv('UTF-8', 'cp874', "ผู้รับเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //ผู้รับเงิน 
$pdf->MultiCell(2.7, $b + 1.5, iconv('UTF-8', 'cp874', "ผู้รับเงิน"), 0, 'R', 0);



$pdf->SetXY(0, 0); //Warehouse 
$pdf->MultiCell(2, $b + 1.75, iconv('UTF-8', 'cp874', "Warehouse"), 0, 'R', 0);
$pdf->SetXY(0, 0); //Warehouse 
$pdf->MultiCell(2.7, $b + 1.75, iconv('UTF-8', 'cp874', "ทีมทดสอบ"), 0, 'R', 0);

$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(2, $b + 2, iconv('UTF-8', 'cp874', "Reference No."), 0, 'R', 0);
$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(2.7, $b + 2, iconv('UTF-8', 'cp874', "NO66050510"), 0, 'R', 0);




$pdf->Output();
