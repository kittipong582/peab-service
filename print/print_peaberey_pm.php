<?php
require('../../print/fpdf/alphapdf.php');
require("../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$form_id = $_GET['id'];

$sql = "SELECT a.*,b.*,c.*,e.customer_name,d.branch_name,d.address,e.phone,e.customer_code,f.brand_name,g.model_name,c.install_date,c.serial_no FROM tbl_pmin_form a 
LEFT JOIN tbl_job b ON a.job_id = b.job_id
LEFT JOIN tbl_product c ON c.product_id = b.product_id 
LEFT JOIN tbl_customer_branch d ON b.customer_branch_id = d.customer_branch_id
LEFT JOIN tbl_customer e ON e.customer_id = d.customer_id
LEFT JOIN tbl_product_brand f ON f.brand_id = c.brand_id
LEFT JOIN tbl_product_model g ON c.model_id = g.model_id
WHERE form_id = '$form_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);



if ($row['install_date'] != null) {
    $install_date =  date("d-m-Y", strtotime($row['install_date']));
} else {
    $install_date =  '-';
}
// echo $sql;
//$pdf->Line(145, 25, 190, 25); //โค้ดเส้นบรรทัด
//$pdf->Image('check_mark.png', 27.5, 131.5, 5, 5, 'PNG');//ติ๊กถูก -3.3 จากตัวหนังสือ
//$pdf->Image('circle_mark.png', 64, 76, 8, 6, 'PNG');//วงกลม -2.3 จากตัวหนังสือ (สั้น 8 ยาว 14)
//$pdf->Image('wing_mark.png', 50, 71, 5, 7, 'PNG');//สี่เหลี่ยมด้านมน -3.3 จากตัวหนังสือ
//$pdf->Image('scissors_mark.png', 50, 71, 5, 7, 'PNG');//กรรไกร


$pdf = new FPDF();
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$pdf->AddPage();
$pdf->Image('print_peaberey_pm.jpg', 0, 0, 210, 297, 'JPG'); //print_peaberey_pm

//-----------------------------------------หัวกระดาษ------------------------------------
$pdf->SetTextColor(178, 34, 34);
$pdf->SetFont('THSarabunNew Bold', '', 25);
$pdf->SetXY(24, 11.3); //เล่มที่
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "0521"), 0, 'L', 0);
$pdf->SetXY(180, 11); //เลขที่
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "26030"), 0, 'L', 0);

$pdf->SetTextColor(0, 0, 0);
$pdf->SetFont('THSarabunNew Bold', '', 14);
$pdf->SetXY(0, 18); //เวลาแจ้งงาน
$pdf->MultiCell(66, 0, iconv('UTF-8', 'cp874', "19.50"), 0, 'C', 0);
$pdf->SetXY(0, 25.5); //เวลาปิดงาน
$pdf->MultiCell(66, 0, iconv('UTF-8', 'cp874', "19.50"), 0, 'C', 0);

//----------------------------------------------เลือกประเภทบริการ------------------------------------------
$pdf->SetFont('THSarabunNew Bold', '', 15);
if ($row['product_type'] == 3) {
    $pdf->SetXY(0, 32.6); //INSTALLATION
    $pdf->MultiCell(14.7, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
}
if ($row['product_type'] == 2) {
    $pdf->SetXY(0, 32.6); //SERVICE PM
    $pdf->MultiCell(77.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
}
if ($row['product_type'] == 1) {
    $pdf->SetXY(0, 32.6); //SERVICE CM
    $pdf->MultiCell(139.7, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
}

$pdf->SetFont('THSarabunNew Bold', '', 14);
$pdf->SetXY(0, 32.2); //อื่นๆ
$pdf->MultiCell(232, 0, iconv('UTF-8', 'cp874', "XXXXXX"), 0, 'C', 0);
$pdf->SetXY(0, 32.2); //ปีที่
$pdf->MultiCell(272, 0, iconv('UTF-8', 'cp874', "2565"), 0, 'C', 0);

$pdf->SetFont('THSarabunNew Bold', '', 15);
$pdf->SetXY(0, 32.3); //ครั้งที่ 1
$pdf->MultiCell(289.7, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 32.3); //ครั้งที่ 2
$pdf->MultiCell(320, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 32.3); //ครั้งที่ 3
$pdf->MultiCell(350.4, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 32.3); //ครั้งที่ 4
$pdf->MultiCell(380.7, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);

//---------------------CUSTOMER PROFILE------------------------------------------
$pdf->SetFont('THSarabunNew Bold', '', 14);
$pdf->SetXY(0, 42); //ชื่อลูกค้า
$pdf->MultiCell(140, 0, iconv('UTF-8', 'cp874', $row['customer_name']), 0, 'C', 0);
$pdf->SetXY(0, 42); //ชื่อร้าน
$pdf->MultiCell(320, 0, iconv('UTF-8', 'cp874', $row['branch_name']), 0, 'C', 0);
$pdf->SetXY(37, 49.5); //ที่อยู่
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', $row['address']), 0, 'L', 0);
$pdf->SetXY(0, 57); //โทร
$pdf->MultiCell(140, 0, iconv('UTF-8', 'cp874', $row['phone']), 0, 'C', 0);
$pdf->SetXY(0, 57); //customer code
$pdf->MultiCell(330, 0, iconv('UTF-8', 'cp874', $row['customer_code']), 0, 'C', 0);

if ($row['product_type'] == 1) {
    //---------------------ESPRESSO MACHINE------------------------------------------
    $pdf->SetFont('THSarabunNew Bold', '', 14);
    $pdf->SetXY(0, 66.5); //เครื่องชงกาแฟ
    $pdf->MultiCell(140, 0, iconv('UTF-8', 'cp874', $row['brand_name']), 0, 'C', 0);
    $pdf->SetXY(0, 66.5); //Model
    $pdf->MultiCell(250, 0, iconv('UTF-8', 'cp874', $row['model_name']), 0, 'C', 0);
    $pdf->SetXY(0, 66.5); //S/N
    $pdf->MultiCell(340, 0, iconv('UTF-8', 'cp874', $row['serial_no']), 0, 'C', 0);
    $pdf->SetXY(0, 74); //วันที่ติดตั้ง
    $pdf->MultiCell(140, 0, iconv('UTF-8', 'cp874', $install_date), 0, 'C', 0);

    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['warranty_type'] == 1) {
        $pdf->SetXY(0, 74.2); //ในประกัน 
        $pdf->MultiCell(199.4, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['warranty_type'] == 2) {
        $pdf->SetXY(0, 74.2); //นอกประกัน 
        $pdf->MultiCell(230.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    //----------------------------------------------เช็คสภาพ------------------------------------------
    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['choice_no1'] == 1) {
        $pdf->SetXY(0, 86.8); //ข้อ  ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no1'] == 2) {
        $pdf->SetXY(0, 86.8); //ข้อ  ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no2'] == 1) {
        $pdf->SetXY(0, 91); //ข้อ 2 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no2'] == 2) {
        $pdf->SetXY(0, 91); //ข้อ 2 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no3'] == 1) {
        $pdf->SetXY(0, 94.8); //ข้อ 3 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no3'] == 2) {
        $pdf->SetXY(0, 94.8); //ข้อ 3 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }


    if ($row['choice_no4'] == 1) {
        $pdf->SetXY(0, 99); //ข้อ 4 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no4'] == 2) {
        $pdf->SetXY(0, 99); //ข้อ 4 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no5'] == 1) {
        $pdf->SetXY(0, 103.2); //ข้อ 5 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no5'] == 1) {
        $pdf->SetXY(0, 103.2); //ข้อ 5 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no6'] == 1) {
        $pdf->SetXY(0, 107.4); //ข้อ 6 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no6'] == 2) {
        $pdf->SetXY(0, 107.4); //ข้อ 6 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no7'] == 1) {
        $pdf->SetXY(0, 111.4); //ข้อ 7 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no7'] == 2) {
        $pdf->SetXY(0, 111.4); //ข้อ 7 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no8'] == 1) {
        $pdf->SetXY(0, 115.6); //ข้อ 8 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no8'] == 2) {
        $pdf->SetXY(0, 115.6); //ข้อ 8 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no9'] == 1) {
        $pdf->SetXY(0, 119.8); //ข้อ 9 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no9'] == 2) {
        $pdf->SetXY(0, 119.8); //ข้อ 9 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no10'] == 1) {
        $pdf->SetXY(0, 124); //ข้อ 10 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no10'] == 2) {
        $pdf->SetXY(0, 124); //ข้อ 10 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no11'] == 1) {
        $pdf->SetXY(0, 128); //ข้อ 11 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no11'] == 2) {
        $pdf->SetXY(0, 128); //ข้อ 11 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }


    if ($row['choice_no12'] == 1) {
        $pdf->SetXY(0, 132.2); //ข้อ 12 ปกติ
        $pdf->MultiCell(149.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no12'] == 2) {
        $pdf->SetXY(0, 132.2); //ข้อ 12 ไม่ปกติ
        $pdf->MultiCell(189.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    //
    $pdf->SetXY(0, 136.4); //ข้อ 13 ก่อนกรอง
    $pdf->MultiCell(154.2, 0, iconv('UTF-8', 'cp874', $row['no_13_before']), 0, 'C', 0);
    $pdf->SetXY(0, 136.4); //ข้อ 13 หลังกรอง
    $pdf->MultiCell(216.2, 0, iconv('UTF-8', 'cp874', $row['no_13_after']), 0, 'C', 0);

    $pdf->SetXY(0, 140.4); //ข้อ 14 ก่อนกรอง
    $pdf->MultiCell(154.2, 0, iconv('UTF-8', 'cp874', $row['no_14_before']), 0, 'C', 0);
    $pdf->SetXY(0, 140.4); //ข้อ 14 หลังกรอง
    $pdf->MultiCell(216.2, 0, iconv('UTF-8', 'cp874', $row['no_14_after']), 0, 'C', 0);

    $pdf->SetXY(0, 144.4); //ข้อ 15 ก่อนกรอง
    $pdf->MultiCell(154.2, 0, iconv('UTF-8', 'cp874', $row['no_15_before']), 0, 'C', 0);
    $pdf->SetXY(0, 144.4); //ข้อ 15 หลังกรอง
    $pdf->MultiCell(216.2, 0, iconv('UTF-8', 'cp874', $row['no_15_after']), 0, 'C', 0);

    $pdf->SetXY(0, 148.6); //ข้อ 16 ก่อนกรอง
    $pdf->MultiCell(154.2, 0, iconv('UTF-8', 'cp874', $row['no_16_before']), 0, 'C', 0);
    $pdf->SetXY(0, 148.6); //ข้อ 16 หลังกรอง
    $pdf->MultiCell(216.2, 0, iconv('UTF-8', 'cp874', $row['no_16_after']), 0, 'C', 0);

    //
    if ($row['choice_no17'] == 1) {
        $pdf->SetXY(0, 85.8); //ข้อ 17 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no17'] == 2) {
        $pdf->SetXY(0, 85.8); //ข้อ 17 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no18'] == 1) {
        $pdf->SetXY(0, 90); //ข้อ 18 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no18'] == 2) {
        $pdf->SetXY(0, 90); //ข้อ 18 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }


    if ($row['choice_no19'] == 1) {
        $pdf->SetXY(0, 94); //ข้อ 19 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no19'] == 2) {
        $pdf->SetXY(0, 94); //ข้อ 19 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }


    if ($row['choice_no20'] == 1) {
        $pdf->SetXY(0, 98.2); //ข้อ 20 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no20'] == 2) {
        $pdf->SetXY(0, 98.2); //ข้อ 20 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no21'] == 1) {
        $pdf->SetXY(0, 102.4); //ข้อ 21 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no21'] == 2) {
        $pdf->SetXY(0, 102.4); //ข้อ 22 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no22'] == 1) {
        $pdf->SetXY(0, 106.6); //ข้อ 22 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no22'] == 2) {
        $pdf->SetXY(0, 106.6); //ข้อ 22 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no23'] == 1) {
        $pdf->SetXY(0, 110.4); //ข้อ 23 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no23'] == 2) {
        $pdf->SetXY(0, 110.4); //ข้อ 23 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no24'] == 1) {
        $pdf->SetXY(0, 114.6); //ข้อ 24 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no24'] == 2) {
        $pdf->SetXY(0, 114.6); //ข้อ 24 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no25'] == 1) {
        $pdf->SetXY(0, 118.6); //ข้อ 25 yes
        $pdf->MultiCell(355.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no25'] == 2) {
        $pdf->SetXY(0, 118.6); //ข้อ 25 no
        $pdf->MultiCell(383.3, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    //
    if ($row['choice_no26'] == 1) {
        $pdf->SetXY(0, 124); //ข้อ 26 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no26'] == 2) {
        $pdf->SetXY(0, 124); //ข้อ 26 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 123.5); //ข้อ 26 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no26_detail']), 0, 'C', 0);

    if ($row['choice_no27'] == 1) {
        $pdf->SetXY(0, 128.4); //ข้อ 27 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no27'] == 2) {
        $pdf->SetXY(0, 128.4); //ข้อ 27 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 127.5); //ข้อ 27 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no27_detail']), 0, 'C', 0);

    if ($row['choice_no28'] == 1) {
        $pdf->SetXY(0, 132.2); //ข้อ 28 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no28'] == 2) {
        $pdf->SetXY(0, 132.2); //ข้อ 28 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 131.5); //ข้อ 28 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no28_detail']), 0, 'C', 0);

    if ($row['choice_no29'] == 1) {
        $pdf->SetXY(0, 136.5); //ข้อ 29 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no29'] == 5) {
        $pdf->SetXY(0, 136.5); //ข้อ 29 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 135.5); //ข้อ 29 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no29_detail']), 0, 'C', 0);

    if ($row['choice_no30'] == 1) {
        $pdf->SetXY(0, 140.5); //ข้อ 30 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no30'] == 2) {
        $pdf->SetXY(0, 140.5); //ข้อ 30 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 139.8); //ข้อ 30 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no30_detail']), 0, 'C', 0);

    if ($row['choice_no31'] == 1) {
        $pdf->SetXY(0, 144.7); //ข้อ 31 clean
        $pdf->MultiCell(310, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no31'] == 2) {
        $pdf->SetXY(0, 144.7); //ข้อ 31 replace
        $pdf->MultiCell(342.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    $pdf->SetXY(0, 144); //ข้อ 31 replace ตอบ
    $pdf->MultiCell(385, 0, iconv('UTF-8', 'cp874', $row['no31_detail']), 0, 'C', 0);
}


if ($row['product_type'] == 2) {
    //---------------------COFFEE GRINDER------------------------------------------
    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(0, 158.5); //เครื่องบดกาแฟ
    $pdf->MultiCell(83, 0, iconv('UTF-8', 'cp874', $row['brand_name']), 0, 'C', 0);
    $pdf->SetFont('THSarabunNew Bold', '', 8);
    $pdf->SetXY(0, 158.5); //Model
    $pdf->MultiCell(133, 0, iconv('UTF-8', 'cp874', $row['model_name']), 0, 'C', 0);
    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(0, 158.5); //S/N
    $pdf->MultiCell(178, 0, iconv('UTF-8', 'cp874', $row['serial_no']), 0, 'C', 0);
    $pdf->SetXY(0, 164.8); //วันที่ติดตั้ง
    $pdf->MultiCell(75, 0, iconv('UTF-8', 'cp874', $install_date), 0, 'C', 0);

    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['warranty_type'] == 1) {
        $pdf->SetXY(0, 164.8); //ในประกัน 
        $pdf->MultiCell(109, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['warranty_type'] == 2) {
        $pdf->SetXY(0, 164.8); //นอกประกัน 
        $pdf->MultiCell(145, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }




    //--------------------------------------------การตรวจเช็คสภาพ-------------------------------------------------------------------------------------------------------------------------------------
    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['choice_no1'] == 1) {
        $pdf->SetXY(0, 178.3); //ทั่วไป ปกติ
        $pdf->MultiCell(50, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no1'] == 2) {
        $pdf->SetXY(0, 178.3); //ทั่วไป ไม่ปกติ 
        $pdf->MultiCell(65, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no2'] == 1) {
        $pdf->SetXY(0, 183.5); //สวิทซ์ ปกติ
        $pdf->MultiCell(50, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no2'] == 2) {
        $pdf->SetXY(0, 183.5); //สวิทซ์ ไม่ปกติ 
        $pdf->MultiCell(65, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no3'] == 1) {
        $pdf->SetXY(0, 188.7); //ระบบการทำงาน ปกติ
        $pdf->MultiCell(50, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no3'] == 2) {
        $pdf->SetXY(0, 188.7); //ระบบการทำงาน ไม่ปกติ 
        $pdf->MultiCell(65, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no4'] == 1) {
        $pdf->SetXY(0, 195.9); //ความละเอียดของกาแฟ ปกติ
        $pdf->MultiCell(50, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no4'] == 2) {
        $pdf->SetXY(0, 195.9); //ความละเอียดของกาแฟ ไม่ปกติ 
        $pdf->MultiCell(65, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no5'] == 1) {
        $pdf->SetXY(0, 178.3); //ปริมาณผงกาแฟ ปกติ
        $pdf->MultiCell(129.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no5'] == 2) {
        $pdf->SetXY(0, 178.3); //ทั่วไป ไม่ปกติ 
        $pdf->MultiCell(145, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no6'] == 1) {
        $pdf->SetXY(0, 183.5); //เฝืองบด ปกติ
        $pdf->MultiCell(129.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no6'] == 2) {
        $pdf->SetXY(0, 183.5); //สวิทซ์ ไม่ปกติ 
        $pdf->MultiCell(145, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no7'] == 1) {
        $pdf->SetXY(0, 188.7); //สปริง ปกติ
        $pdf->MultiCell(129.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no7'] == 2) {
        $pdf->SetXY(0, 188.7); //สปริง ไม่ปกติ 
        $pdf->MultiCell(145, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no8'] == 1) {
        $pdf->SetXY(0, 195.9); //ชงกาแฟตามมาตรฐานลูกค้า ปกติ
        $pdf->MultiCell(129.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no8'] == 2) {
        $pdf->SetXY(0, 195.9); //ชงกาแฟตามมาตรฐานลูกค้า ไม่ปกติ 
        $pdf->MultiCell(145, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(80, 177); //Note. 
    $pdf->MultiCell(22, 3.5, iconv('UTF-8', 'cp874', "Xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"), 0, 'L', 0);
}


if ($row['product_type'] == 3) {
    //---------------------BLENDER------------------------------------------
    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(0, 158.5); //เครื่องปั่น
    $pdf->MultiCell(276, 0, iconv('UTF-8', 'cp874', $row['brand_name']), 0, 'C', 0);
    $pdf->SetFont('THSarabunNew Bold', '', 8);
    $pdf->SetXY(0, 158.5); //Model
    $pdf->MultiCell(326, 0, iconv('UTF-8', 'cp874', $row['model_name']), 0, 'C', 0);
    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(0, 158.5); //S/N
    $pdf->MultiCell(371, 0, iconv('UTF-8', 'cp874', $row['serial_no']), 0, 'C', 0);
    $pdf->SetXY(0, 164.8); //วันที่ติดตั้ง
    $pdf->MultiCell(271, 0, iconv('UTF-8', 'cp874', $install_date), 0, 'C', 0);

    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['warranty_type'] == 1) {
        $pdf->SetXY(0, 164.8); //ในประกัน 
        $pdf->MultiCell(304, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['warranty_type'] == 2) {
        $pdf->SetXY(0, 164.8); //นอกประกัน 
        $pdf->MultiCell(339.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    //
    $pdf->SetFont('THSarabunNew Bold', '', 15);
    if ($row['choice_no1'] == 1) {
        $pdf->SetXY(0, 177.5); //เครื่องภายนอกทั่วไป ปกติ
        $pdf->MultiCell(258, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no1'] == 2) {
        $pdf->SetXY(0, 177.5); //เครื่องภายนอกทั่วไป ไม่ปกติ 
        $pdf->MultiCell(270.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no2'] == 1) {
        $pdf->SetXY(0, 182.7); //ปุ่มคอลโทรล ปกติ
        $pdf->MultiCell(258, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no2'] == 2) {
        $pdf->SetXY(0, 182.7); //ปุ่มคอลโทรล ไม่ปกติ 
        $pdf->MultiCell(270.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no3'] == 1) {
        $pdf->SetXY(0, 188.2); //ระบบไฟฟ้า ปกติ
        $pdf->MultiCell(258, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no3'] == 2) {
        $pdf->SetXY(0, 188.2); //ระบบไฟฟ้า ไม่ปกติ 
        $pdf->MultiCell(270.5, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    if ($row['choice_no4'] == 1) {
        $pdf->SetXY(0, 178); //สภาพ เครื่อง/โถปั่น/ฝาปิด ปกติ
        $pdf->MultiCell(335.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no4'] == 2) {
        $pdf->SetXY(0, 178); //สภาพ เครื่อง/โถปั่น/ฝาปิด ไม่ปกติ 
        $pdf->MultiCell(349.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no5'] == 1) {
        $pdf->SetXY(0, 183); //ชุดใบมีด ปกติ
        $pdf->MultiCell(335.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }
    if ($row['choice_no5'] == 2) {
        $pdf->SetXY(0, 183); //ชุดใบมีด ไม่ปกติ 
        $pdf->MultiCell(349.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
    }

    $pdf->SetFont('THSarabunNew Bold', '', 10);
    $pdf->SetXY(183, 175.5); //Note. 
    $pdf->MultiCell(20, 3.5, iconv('UTF-8', 'cp874', "Xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"), 0, 'L', 0);
}



//--------------------------------------------COMMENT-------------------------------------------------------------------------------------------------------------------------------------
$pdf->SetFont('THSarabunNew', '', 11);
$pdf->SetXY(45, 217.3); //comment บรรทัด 1
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "การซื้อสินค้าไปโดยที่ไม่ได้รับการติดตั้งจากฝ่ายเทคนิคของบริษัทฯ"), 0, 'L', 0);
$pdf->SetXY(17, 222.3); //comment บรรทัด 2
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "สินค้าที่ลดราคาพิเศษ/สินค้าที่เข้าร่วมโปรโมชั่นclearance/สินค้าที่ได้แจ้งเงื่อนไขพิเศษในวันที่สั่งซื้อ"), 0, 'L', 0);
$pdf->SetXY(17, 227.3); //comment บรรทัด 3
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "สินค้าที่ทางบริษัทฯยังไม่ได้รับเงินครบถ้วนสมบูรณ์ตามจำนวนที่เรียกเก็บ"), 0, 'L', 0);
$pdf->SetXY(17, 232.5); //comment บรรทัด 4
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "การไม่แจ้งเลขใบรับประกัน, รายละเอียดรถ หรือหลักฐานการซื้อสินค้าอื่นๆ เพื่อให้ทางบริษัทฯสามารถค้นหาข้อมูลได้"), 0, 'L', 0);
$pdf->SetXY(17, 238); //comment บรรทัด 5
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "การไม่แจ้งเลขใบรับประกัน, รายละเอียดรถ หรือหลักฐานการซื้อสินค้าอื่นๆ เพื่อให้ทางบริษัทฯสามารถค้นหาข้อมูลได้"), 0, 'L', 0);

$pdf->SetXY(45, 243.6); //comment เพิ่มเติม
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "การซื้อสินค้าไปโดยที่ไม่ได้รับการติดตั้งจากฝ่ายเทคนิคของบริษัทฯ"), 0, 'L', 0);
$pdf->SetXY(38, 249.6); //customer/ลูกค้า
$pdf->MultiCell(0, 0, iconv('UTF-8', 'cp874', "การซื้อสินค้าไปโดยที่ไม่ได้รับการติดตั้งจากฝ่ายเทคนิคของบริษัทฯ"), 0, 'L', 0);
$pdf->Image('ex_pic.png', 166.8, 216, 34, 34, 'PNG'); //ตราประทับร้าน

//--------------------------------------------ประเมินความพึงพอใจ-------------------------------------------------------------------------------------------------------------------------------------
$pdf->SetFont('THSarabunNew', '', 30);
$pdf->SetXY(0, 263.6); //การแต่งกาย มาก/3
$pdf->MultiCell(119.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 263.6); //การแต่งกาย ปานกลาง/2
$pdf->MultiCell(139.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 263.6); //การแต่งกาย ปรับปรุง/1
$pdf->MultiCell(158.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);

$pdf->SetXY(0, 269.1); //ความชัดเจน มาก/3
$pdf->MultiCell(119.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 269.1); //ความชัดเจน ปานกลาง/2
$pdf->MultiCell(139.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 269.1); //ความชัดเจน ปรับปรุง/1
$pdf->MultiCell(158.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);

$pdf->SetXY(0, 274.6); //การให้บริการตามเวลส มาก/3
$pdf->MultiCell(119.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 274.6); //การให้บริการตามเวลส ปานกลาง/2
$pdf->MultiCell(139.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 274.6); //การให้บริการตามเวลส ปรับปรุง/1
$pdf->MultiCell(158.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);

$pdf->SetXY(0, 280.1); //ความสามารถในการทำงาน มาก/3
$pdf->MultiCell(119.6, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 280.1); //ความสามารถในการทำงาน ปานกลาง/2
$pdf->MultiCell(139.2, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);
$pdf->SetXY(0, 280.1); //ความสามารถในการทำงาน ปรับปรุง/1
$pdf->MultiCell(158.8, 0, iconv('UTF-8', 'cp874', "X"), 0, 'C', 0);

//--------------------------------------------เซ็นชื่อ-------------------------------------------------------------------------------------------------------------------------------------
$pdf->SetFont('THSarabunNew', '', 10);
$pdf->SetXY(0, 262.4); //เซ็นชื่อ
$pdf->MultiCell(205, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 268); //ลงชื่อ
$pdf->MultiCell(205, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 273.6); //วัน
$pdf->MultiCell(185, 0, iconv('UTF-8', 'cp874', "26"), 0, 'C', 0);
$pdf->SetXY(0, 273.6); //เดือน
$pdf->MultiCell(205, 0, iconv('UTF-8', 'cp874', "02"), 0, 'C', 0);
$pdf->SetXY(0, 273.6); //ปี
$pdf->MultiCell(225, 0, iconv('UTF-8', 'cp874', "2022"), 0, 'C', 0);

$pdf->SetFont('THSarabunNew', '', 10); //ช่างเทคนิค
$pdf->SetXY(0, 262.2); //เซ็นชื่อ
$pdf->MultiCell(276.2, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 267.8); //ลงชื่อ
$pdf->MultiCell(276.2, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 273.4); //วัน
$pdf->MultiCell(258.2, 0, iconv('UTF-8', 'cp874', "26"), 0, 'C', 0);
$pdf->SetXY(0, 273.4); //เดือน
$pdf->MultiCell(276.2, 0, iconv('UTF-8', 'cp874', "02"), 0, 'C', 0);
$pdf->SetXY(0, 273.4); //ปี
$pdf->MultiCell(296.2, 0, iconv('UTF-8', 'cp874', "2022"), 0, 'C', 0);

$pdf->SetFont('THSarabunNew', '', 10); //ลูกค้า
$pdf->SetXY(0, 261.9); //เซ็นชื่อ
$pdf->MultiCell(371, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 267.5); //ลงชื่อ
$pdf->MultiCell(360, 0, iconv('UTF-8', 'cp874', "คงเดช เทพประตู"), 0, 'C', 0);
$pdf->SetXY(0, 273.1); //วัน
$pdf->MultiCell(352, 0, iconv('UTF-8', 'cp874', "26"), 0, 'C', 0);
$pdf->SetXY(0, 273.1); //เดือน
$pdf->MultiCell(376, 0, iconv('UTF-8', 'cp874', "02"), 0, 'C', 0);
$pdf->SetXY(0, 273.1); //ปี
$pdf->MultiCell(396, 0, iconv('UTF-8', 'cp874', "2022"), 0, 'C', 0);









$pdf->Output();
