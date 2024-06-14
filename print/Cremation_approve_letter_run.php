<?php
include('../config/main_function.php');
$secure = "30!dkxpGq1%21l";
include("qrcodegenerate/qrlib.php");
$connection = connectDB($secure);
require('fpdf/alphapdf.php');

$pdf = new FPDF();
$pdf->AliasNbPages();

$sql = "SELECT 

da_m.f_name AS m_f_name ,da_m.pre_name AS m_pre_name , da_m.s_name AS m_s_name ,da_m.member_code AS m_member_code
,da_m.phone  AS m_phone

,da_s.f_name,da_s.pre_name, da_s.s_name ,da_s.member_code
,da_s.address,da_s.moo,da_s.road,da_s.tambon,da_s.amphur,da_s.province,da_s.postcode,da_s.phone

FROM tbl_spouse_consent s_c
LEFT JOIN tbl_data da_m ON s_c.member_citizen_id = da_m.citizen_id 
LEFT JOIN tbl_data da_s ON s_c.spouse_citizen_id = da_s.citizen_id
LIMIT 100 OFFSET 0";
$res = mysqli_query($connection, $sql);


$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

while ($row = mysqli_fetch_assoc($res)) {
    # code...

    $pdf->AddPage();
    $pdf->Image('CM_approve_letter.jpg', 0, 0, 210, 297, 'JPG');

    $pdf->SetFont('THSarabunNew Bold', '', 14);

    $pdf->SetXY(40, 77.5);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $row['m_pre_name'] . ' ' . $row['m_f_name'] . ' ' . $row['m_s_name']), 0, 'L', 0); //เรียน
    $pdf->SetXY(107, 77);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $row['m_member_code']), 0, 'L', 0); //สมาชิกเลขทีี่

    $pdf->SetXY(63, 93);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $row['pre_name'] . ' ' . $row['f_name'] . ' ' . $row['s_name']), 0, 'L', 0); //บัญชีของ
    $pdf->SetXY(159, 93);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $row['member_code']), 0, 'L', 0); //สมาชิกสมาคมเลขที่

    $pdf->AddPage();
    $pdf->Image('letter.jpg', 0, 0, 210, 297, 'JPG');
    $pdf->Image('logo_cremation.png', 12, 108, 23, 23, 'PNG');

    $pdf->SetFont('THSarabunNew Bold', '', 15);
    $pdf->SetXY(40, 110);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', 'สมาคมฌาปนกิจสงเคราะห์อาสาสมัครสาธารณสุขประจำหมู่บ้านแห่งประเทศไทย'), 0, 'L', 0);


    $pdf->SetFont('THSarabunNew Bold', '', 14);
    $pdf->SetXY(40, 116);
    $pdf->MultiCell(120, 5, iconv('UTF-8', 'cp874', '88/44 ชั้น 2 กรมสนับสนุนบริการสุขภาพ กระทรวงสาธารณสุข ซ.สาธารณสุข 8 ถนนติวานนท์ ตำบลตลาดขวัญ อำเภอเมือง จังหวัดนนทบุรี 11000'), 0, 'L', 0);
    $pdf->SetXY(40, 126);
    $pdf->MultiCell(120, 5, iconv('UTF-8', 'cp874', 'โทรศัพท์ 082-705-3698,061-752-0990'), 0, 'L', 0);

    $pdf->SetXY(166, 110); //
    $pdf->MultiCell(40, 5, iconv('UTF-8', 'cp874', 'ชำระค่าไปรษณียากรแล้ว ใบอนุญาติเลขที่ 76/2566 ปณศ.(พ) นนทบุรี'), 0, 'C', 0);

    //ข้อมูลผู้รับ
    $pdf->SetXY(95, 138);
    $pdf->MultiCell(0, 5, iconv('UTF-8', 'cp874', $row['m_pre_name'] . ' ' . $row['m_f_name'] . ' ' . $row['m_s_name']), 0, 'L', 0); //ชื่อ
    $pdf->SetXY(138, 138);
    // $pdf->MultiCell(30, 5, iconv('UTF-8', 'cp874', '905'), 0, 'R', 0); //905

    $pdf->SetXY(95, 143);
    $pdf->MultiCell(70, 5, iconv('UTF-8', 'cp874', 'ที่อยู่' . $row['address']  . (($row['road'] != '') ? ' ถ.' . $row['road'] : '') . (($row['moo'] != '') ? ' ม.' . $row['moo'] : '') . ' ต.' . $row['tambon'] . ' อ.' . $row['amphur'] . ' จ.' . $row['province'] . ' ' . $row['postcode']), 0, 'L', 0); //ที่อยู่
    $pdf->SetXY(95, 158);

    $pdf->MultiCell(60, 5, iconv('UTF-8', 'cp874', ($row['phone'] != '') ? 'โทร : ' . $row['phone'] : 'โทร : ' . $row['m_phone']), 0, 'L', 0); //เลขสมาชิก
    // $pdf->MultiCell(60, 5, iconv('UTF-8', 'cp874', $row['member_code']), 0, 'L', 0); //เลขสมาชิก

    $pdf->SetXY(118, 170);
    // $pdf->MultiCell(50, 5, iconv('UTF-8', 'cp874', 'แจ้งเตือน 12/66 ครั้ง 1'), 0, 'R', 0); //แจ้งเตือนครั้งที่

}
// $pdf->Output();
$pdf->Output('F', 'Cremation_approve_letter 1 to 100.pdf');
