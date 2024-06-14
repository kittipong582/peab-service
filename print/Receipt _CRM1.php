<?php
require('./fpdf/alphapdf.php');
require("../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
date_default_timezone_set("Asia/Bangkok");
$current_datetime = date("Y-m-d H:i:s");
$starttime = microtime(true);
unlink("sign_image.png");
function clean($string)
{

    return preg_replace('/[^\p{L}\p{M}\p{Z}\p{N}\p{P}]/u', ' ', $string);
}

$date = date('d/m/Y');
$time = date('H:i');

$job_id = $_GET['job_id'];

$sql_chk = "SELECT COUNT(job_id) as num_job FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
$rs_chk = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_assoc($rs_chk);

if ($row_chk['num_job'] == 0) {
    ////////////////////////////////SET page
    $sql_count = "SELECT COUNT(*) AS num FROM (SELECT spare_used_id,job_id FROM tbl_job_spare_used

UNION

SELECT job_income_id,job_id FROM tbl_job_income

)AS tem WHERE job_id = '$job_id'";
    $rs_count = mysqli_query($connect_db, $sql_count);
    $row_count = mysqli_fetch_assoc($rs_count);

    $set_page = 6.7 + ($row_count['num'] * 0.27);



    ///////////////////////////////////////sql customer/////////////
    $sql_customer = "SELECT b.branch_code,b.billing_name,b.billing_address,b.billing_tax_no,d.fullname,e.team_number,a.job_no,a.signature_image,a.receipt_no,a.receipt_datetime FROM tbl_job a
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
LEFT JOIN tbl_branch e ON e.branch_id = d.branch_id	
 WHERE a.job_id = '$job_id'";
    $rs_customer = mysqli_query($connect_db, $sql_customer);
    $row_customer = mysqli_fetch_assoc($rs_customer);

    if (isset($row_customer['signature_image'])) {

        $img_string = $row_customer['signature_image'];

        $img = str_replace('data:image/png;base64,', '', $img_string);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $im = imageCreateFromString($data);

        // Make sure that the GD library was able to load the image
        // This is important, because you should not miss corrupted or unsupported images
        if (!$im) {
            die('Base64 value is not a valid image');
        }

        // $strdate = $date . $time;
        // $strdate = str_replace("/", "", $strdate);
        // $strdate = str_replace(":", "", $strdate);

        // Specify the location where you want to save the image
        $img_file = 'sign_image' . '.png';
        imagepng($im, $img_file, 0);
    }

    $sql_current = "";
    if ($row_customer['receipt_datetime'] == null) {
        $con_current = ",receipt_datetime = '$current_datetime'";
    } else {

        $date = date('d/m/Y', strtotime($row_customer['receipt_datetime']));
        $time = date('H:i', strtotime($row_customer['receipt_datetime']));
    }


    // เลขที่ running number กำหนดเป็น คลัง - ปี เดือน running
    // ตัวอย่าง เช่น  TE043-2302001
    // (กำหนดเป็นรายเดือน)

    if ($row_customer['receipt_no'] == null) {
        /////////////reciecve_no////////////////
        $year = $row_customer['team_number'] . "-" . substr(date("Y") + 543, 2) . date("m");
        $format =  $year;

        $sql1    = "SELECT (CASE WHEN (SELECT COUNT(receipt_no) AS count_this_month FROM tbl_job WHERE receipt_no LIKE '$format%') > 0 
                      THEN LPAD((MAX(substring(receipt_no, -3))+1),3,0) ELSE '001' END) AS NextCode 
               FROM tbl_job WHERE receipt_no LIKE '$format%'";
        $rs1     = mysqli_query($connect_db, $sql1);
        $row1 = mysqli_fetch_array($rs1);
        $reciecve_no = $format . $row1['NextCode'];

        mysqli_query($connect_db, "UPDATE tbl_job SET receipt_no = '$reciecve_no' $con_current WHERE job_id = '$job_id'");
        // echo "UPDATE tbl_job SET receipt_no = '$reciecve_no' $con_current WHERE job_id = '$job_id'";
    } else {
        $reciecve_no = $row_customer['receipt_no'];

        mysqli_query($connect_db, "UPDATE tbl_job SET receipt_no = '$reciecve_no' $con_current WHERE job_id = '$job_id'");
        // echo "UPDATE tbl_job SET receipt_no = '$reciecve_no' $con_current WHERE job_id = '$job_id'";
    }
} else {

    $row_chk_num = 0;
    $row_chk_date = 0;
    $detail_array = array();
    $job_array = array();
    $group_loop = 0;
    $row_loop = 0;

    $sql_group2 = "SELECT job_id,group_pm_id FROM tbl_group_pm_detail
        WHERE group_pm_id  IN(SELECT group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id')";
    $rs_group2 = mysqli_query($connect_db, $sql_group2);
    $all_job = mysqli_num_rows($rs_group2);
    while ($row_group2 = mysqli_fetch_assoc($rs_group2)) {

        $sql = "SELECT * FROM (SELECT a.spare_part_id as num1,a.job_id as num2,b.spare_part_code as num3,b.spare_part_name as num4,a.quantity as num5,a.unit_price as num6,1 as num7 FROM tbl_job_spare_used a
            LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id
            UNION
            SELECT a.job_income_id as num1,a.job_id as num2,b.income_code as num3,b.income_type_name as num4,a.quantity as num5,a.income_amount as num6,2 as num7 FROM tbl_job_income a
            LEFT JOIN tbl_income_type b ON b.income_type_id = a.income_type_id

            )AS tem WHERE num2 = '{$row_group2['job_id']}'";
        $rs = mysqli_query($connect_db, $sql);
        // echo $sql;
        while ($row = mysqli_fetch_assoc($rs)) {


            if ($row['num7'] == 1) {
                $unit_price = $row['num6'] / $row['num5'];
                $total = $row['num6'];
            } else {
                $unit_price = $row['num6'];
                $total = ($row['num5'] * $row['num6']);
            }

            if (array_keys(array_column($detail_array, 'id'), $row['num1']) == true) {

                $temp_key = array_search($row['num1'], array_column($detail_array, 'id'));
                $new_quantity = $detail_array[$temp_key]['quantity'] + $row['num5'];
                $detail_array[$temp_key]['quantity'] = $new_quantity;

                $new_total = $detail_array[$temp_key]['total'] + round($total,2);
                $detail_array[$temp_key]['total'] = $new_total;
            } else {
                $temp = array(
                    "id" => $row['num1'],
                    "list" => $row['num3'],
                    "quantity" => $row['num5'],
                    "unit_price" => round($unit_price,2),
                    "total" => round($total,2),
                    "list_detail" => $row['num4'],
                    "job_id" => $row_group2['job_id']
                );
                array_push($detail_array, $temp);

                $row_loop++;
            }
        }
        $group_pm_id = $row_group2['group_pm_id'];

        $sql_job = "SELECT receipt_no,receipt_datetime FROM tbl_job WHERE job_id = '{$row_group2['job_id']}'";
        $rs_job = mysqli_query($connect_db, $sql_job);


        while ($row_job = mysqli_fetch_assoc($rs_job)) {
            if ($row_job['receipt_no'] == NULL) {
                $row_chk_num++;
            }

            if ($row_job['receipt_datetime'] == NULL) {
                $row_chk_date++;
            }
        }
    }
    $sql_team = "SELECT team_number,signature_image FROM tbl_group_pm a
    LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id 
    LEFT JOIN tbl_branch e ON e.branch_id = b.branch_id
    WHERE a.group_pm_id = '$group_pm_id'";
    $rs_team = mysqli_query($connect_db, $sql_team);
    $row_team = mysqli_fetch_assoc($rs_team);
    // echo $sql_team;

    if ($row_chk_num == $all_job) {
        /////////////reciecve_no////////////////

        $year = $row_team['team_number'] . "-" . substr(date("Y") + 543, 2) . date("m");
        $format =  $year;

        $sql1    = "SELECT (CASE WHEN (SELECT COUNT(receipt_no) AS count_this_month FROM tbl_job WHERE receipt_no LIKE '$format%') > 0 
                      THEN LPAD((MAX(substring(receipt_no, -3))+1),3,0) ELSE '001' END) AS NextCode 
               FROM tbl_job WHERE receipt_no LIKE '$format%'";
        $rs1     = mysqli_query($connect_db, $sql1);
        $row1 = mysqli_fetch_array($rs1);
        $reciecve_no = $format . $row1['NextCode'];

        $sql_loop = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
        $rs_lopp = mysqli_query($connect_db, $sql_loop);
        while ($row_loop = mysqli_fetch_assoc($rs_lopp)) {

            $sql_update3 = "UPDATE tbl_job SET 
                receipt_no = '$reciecve_no'
                WHERE job_id = '{$row_loop['job_id']}'";


            $rs_update3 =  mysqli_query($connect_db, $sql_update3);
        }


        // echo $sql_update3;
    }
    if ($row_chk_date == $all_job) {


        $sql_loop = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '$group_pm_id'";
        $rs_lopp = mysqli_query($connect_db, $sql_loop);
        while ($row_loop = mysqli_fetch_assoc($rs_lopp)) {

            $sql_update4 = "UPDATE tbl_job SET 
            receipt_datetime ='$current_datetime' 
            WHERE job_id = '{$row_loop['job_id']}'";

            $rs_update4 =  mysqli_query($connect_db, $sql_update4);
        }
    }




    ///////////////////////////////////////sql customer/////////////
    $sql_customer = "SELECT b.branch_code,b.billing_name,b.billing_address,b.billing_tax_no,d.fullname,e.team_number,a.job_no,a.signature_image,a.receipt_no,a.receipt_datetime FROM tbl_job a
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
    LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
    LEFT JOIN tbl_branch e ON e.branch_id = d.branch_id
     WHERE a.job_id = '$job_id'";
    $rs_customer = mysqli_query($connect_db, $sql_customer) or die($connect_db->error);
    $row_customer = mysqli_fetch_assoc($rs_customer);
    $reciecve_no = $row_customer['receipt_no'];
    $date = date('d/m/Y', strtotime($row_customer['receipt_datetime']));
    $time = date('H:i', strtotime($row_customer['receipt_datetime']));


    $set_page = 6.7 + ($row_loop * 0.31);



    if (isset($row_customer['signature_image'])) {

        $img_string = $row_customer['signature_image'];

        $img = str_replace('data:image/png;base64,', '', $img_string);
        $img = str_replace(' ', '+', $img);
        $data = base64_decode($img);

        $im = imageCreateFromString($data);

        // Make sure that the GD library was able to load the image
        // This is important, because you should not miss corrupted or unsupported images
        if (!$im) {
            die('Base64 value is not a valid image');
        }

        // $strdate = $date . $time;
        // $strdate = str_replace("/", "", $strdate);
        // $strdate = str_replace(":", "", $strdate);

        // Specify the location where you want to save the image
        $img_file = 'sign_image' . '.png';
        imagepng($im, $img_file, 0);
    }
}

// echo $img_file;

$endtime = microtime(true);
$duration = $endtime - $starttime; //calculates total time taken


$pdf = new FPDF('P', 'in', array(2.83, $set_page));
$pdf->AliasNbPages();

$pdf->SetAutoPageBreak(false);
$pdf->AddFont('THSarabunNew', '', 'THSarabunNew.php');
$pdf->AddFont('THSarabunNew Bold', '', 'THSarabunNew Bold.php');
$pdf->AddFont('THSarabunNew BoldItalic', '', 'THSarabunNew BoldItalic.php');

$pdf->AddPage();
// $pdf->Image('Receipt CRM_page-0001.jpg', 71, 254, 0, 0, 'JPG'); //print_hrt_admonition_book
//$pdf->Image('print_hrt_admonition_book.jpg', 0, 0, 210, 297, 'JPG');//print_hrt_admonition_book

// //------------------------------------------------หัวกรดาษ------------------------

$pdf->SetTextColor(0, 0, 0, 255);
$pdf->SetFont('THSarabunNew Bold', '', 11);
$pdf->SetXY(0, 0); //บริษัท พีเบอร์รี่ ไทย จำกัด
// $pdf->MultiCell(1.9, 0.9, iconv('UTF-8', 'cp874', "บริษัท พีเบอร์รี่ ไทย จำกัด"), 0, 'R', 0);
$pdf->Image('logo.jpg', 1.1, 0.1, 0.62, 0.62, 'jpg'); //print_hrt_admonition_book
$pdf->SetXY(0, 0.14); //123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา
$pdf->MultiCell(1.99, 1.14, iconv('UTF-8', 'cp874', "บริษัท พีเบอร์รี่ ไทย จํากัด"), 0, 'R', 0);
$pdf->SetXY(0, 0.145); //123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา
$pdf->MultiCell(2.43, 1.4, iconv('UTF-8', 'cp874', "123/17 ถนนนนทรี เเขวงช่องนนทรี เขตยานนาวา"), 0, 'R', 0);
$pdf->SetXY(0, 0.145); //123/17 ถ.นนทรี เเขวงช่องนนทรี เขตยานนาวา
$pdf->MultiCell(2.13, 1.7, iconv('UTF-8', 'cp874', "จังหวัดกรุงเทพมหานคร  10120"), 0, 'R', 0);

$pdf->SetXY(0, 0.145); //โทรศัพท์
$pdf->MultiCell(1.08, 2, iconv('UTF-8', 'cp874', "โทรศัพท์"), 0, 'R', 0);
$pdf->SetXY(0, 0.145); //โทรศัพท์
$pdf->MultiCell(2.16, 2, iconv('UTF-8', 'cp874', "02-681-2424 ต่อ 1108"), 0, 'R', 0);

$pdf->SetXY(0, 0.13); //เลขประจำตัวผู้เสียภาษี
$pdf->MultiCell(1.15, 2.5, iconv('UTF-8', 'cp874', "เลขประจำตัวผู้เสียภาษี"), 0, 'R', 0);
$pdf->SetXY(0, 0.13); //เลขประจำตัวผู้เสียภาษี
$pdf->MultiCell(2, 2.5, iconv('UTF-8', 'cp874', "0105563135500"), 0, 'R', 0);

$pdf->SetXY(0, 0.13); //สาขาที่ออกเอกสาร
$pdf->MultiCell(0.99, 2.8, iconv('UTF-8', 'cp874', "สาขาที่ออกเอกสาร"), 0, 'R', 0);
$pdf->SetXY(0, 0.13); //สาขาที่ออกเอกสาร
$pdf->MultiCell(1.67, 2.8, iconv('UTF-8', 'cp874', "สำนักงานใหญ่"), 0, 'R', 0);


////---------------------------------------------------------------------

$pdf->SetXY(0, 0); //ใบเสร็จเงินชั่วคราว
$pdf->MultiCell(1.9, 3.5, iconv('UTF-8', 'cp874', "ใบเสร็จรับเงินชั่วคราว"), 0, 'R', 0);

$pdf->SetXY(0, 0); //วันที่
$pdf->MultiCell(0.38, 3.85, iconv('UTF-8', 'cp874', "วันที่"), 0, 'R', 0);
$pdf->SetXY(0, 0); //วันที่
$pdf->MultiCell(0.96, 3.85, iconv('UTF-8', 'cp874',  $date), 0, 'R', 0);


$pdf->SetXY(0, 0); //เวลา
$pdf->MultiCell(2.4, 3.85, iconv('UTF-8', 'cp874', "เวลา"), 0, 'R', 0);
$pdf->SetXY(0, 0); //เวลา
$pdf->MultiCell(2.7, 3.85, iconv('UTF-8', 'cp874',  $time), 0, 'R', 0);


$pdf->SetXY(0, 0); //เลขที่ใบเสร็จรับเงิน
$pdf->MultiCell(1, 4.2, iconv('UTF-8', 'cp874', "เลขที่ใบเสร็จรับเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //เลขที่ใบเสร็จรับเงิน
$pdf->MultiCell(2.7, 4.2, iconv('UTF-8', 'cp874', $reciecve_no), 0, 'R', 0);

$pdf->SetXY(0, 0); //Tax ID 
$pdf->MultiCell(0.56, 4.7, iconv('UTF-8', 'cp874', "Tax ID :"), 0, 'R', 0);
$pdf->SetXY(0.61, 1.960); //Tax ID 
$pdf->MultiCell(1, 0.8, iconv('UTF-8', 'cp874', clean($row_customer['billing_tax_no'])), 0, 'L', 0);


// $pdf->SetXY(0, 0); //Tax ID 
// $pdf->MultiCell(2, 4.7, iconv('UTF-8', 'cp874', "Tax ID :"), 0, 'R', 0);
$pdf->SetXY(2.2, 1.960); //Tax ID 
$pdf->MultiCell(1, 0.78, iconv('UTF-8', 'cp874', clean($row_customer['branch_code'])), 0, 'L', 0);

$pdf->SetXY(0, 0); //ผู้ซื้อ
$pdf->MultiCell(0.46, 5.05, iconv('UTF-8', 'cp874', "ผู้ซื้อ :"), 0, 'R', 0);
$pdf->SetXY(0.62, 2.48); //ผู้ซื้อ
$pdf->MultiCell(1.85, 0.12, iconv('UTF-8', 'cp874', clean($row_customer['billing_name'])), 0, 'L', 0);

$pdf->SetXY(0, 0); //ที่อยู่
$pdf->MultiCell(0.46, 5.89, iconv('UTF-8', 'cp874', "ที่อยู่ :"), 0, 'R', 0);
$pdf->SetXY(0.62, 2.88); //ที่อยู่
$pdf->MultiCell(2.2, 0.16, iconv('UTF-8', 'cp874', clean($row_customer['billing_address'])), 0, 'L', 0);
// $pdf->SetXY(0, 0); //ที่อยู่
// $pdf->MultiCell(1.41, 5.1, iconv('UTF-8', 'cp874', ""), 0, 'R', 0);





$pdf->SetXY(0, 0); //รายการ 
$pdf->MultiCell(0.6, 7.2, iconv('UTF-8', 'cp874', "รายการ"), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวน 
$pdf->MultiCell(1.3, 7.2, iconv('UTF-8', 'cp874', "จำนวน"), 0, 'R', 0);

$pdf->SetXY(0, 0); //ราคา 
$pdf->MultiCell(2, 7.2, iconv('UTF-8', 'cp874', "ราคา"), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวนเงิน 
$pdf->MultiCell(2.71, 7.2, iconv('UTF-8', 'cp874', "จำนวนเงิน"), 0, 'R', 0);


////----------------------------------------------------------------------------


// $pdf->SetXY(0, 0);//รายการ
// $pdf->MultiCell(0.6, 6.2, iconv('UTF-8', 'cp874', "SP00386"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//จำนวน 
// $pdf->MultiCell(1.2, 6.2, iconv('UTF-8', 'cp874', "3"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//ราคา
// $pdf->MultiCell(2, 6.2, iconv('UTF-8', 'cp874', "95.00"), 0, 'R', 0);

// $pdf->SetXY(0, 0);//จำนวนเงิน 
// $pdf->MultiCell(2.7, 6.2, iconv('UTF-8', 'cp874', "285.00"), 0, 'R', 0);

if ($row_chk['num_job'] == 0) {

    $sql = "SELECT * FROM (SELECT a.spare_part_id as num1,a.job_id as num2,b.spare_part_code as num3,b.spare_part_name as num4,a.quantity as num5,a.unit_price as num6,1 as num7 FROM tbl_job_spare_used a
LEFT JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id

UNION

SELECT a.job_income_id as num1,a.job_id as num2,b.income_code as num3,b.income_type_name as num4,a.quantity as num5,a.income_amount as num6,2 as num7 FROM tbl_job_income a
LEFT JOIN tbl_income_type b ON b.income_type_id = a.income_type_id


)AS tem WHERE num2 = '$job_id'";
    $rs = mysqli_query($connect_db, $sql) or die($connect_db->error);;


    $c = 7.7;
    $img_position = 4.54;
    // echo $sql;

    while ($row = mysqli_fetch_assoc($rs)) {

        if ($row['num7'] == 1) {

            $unit_price = $row['num6'] / $row['num5'];

            $total = $row['num6'];
        } else {

            $unit_price = $row['num6'];
            $total = ($row['num5'] * $row['num6']);
        }


        $pdf->SetXY(0.14, 0); //รายการ
        $pdf->MultiCell(0.6, $c, iconv('UTF-8', 'cp874', $row['num3']), 0, 'L', 0);

        $pdf->SetXY(0, 0); //จำนวน 
        $pdf->MultiCell(1.2, $c, iconv('UTF-8', 'cp874', number_format($row['num5'])), 0, 'R', 0);

        $pdf->SetXY(0, 0); //ราคา
        $pdf->MultiCell(2, $c, iconv('UTF-8', 'cp874', number_format($unit_price,2)), 0, 'R', 0);

        $pdf->SetXY(0, 0); //จำนวนเงิน 
        $pdf->MultiCell(2.7, $c, iconv('UTF-8', 'cp874', number_format($total, 2)), 0, 'R', 0);

        $c = $c + 0.35;

        $pdf->SetXY(0.14, 0); //รายการ
        $pdf->MultiCell(1.5, $c, iconv('UTF-8', 'cp874', $row['num4']), 0, 'L', 0);

        $c = $c + 0.35;

        $all_total += $total;

        $img_line += 0.35;
    }
    // echo $img_position;
    $b = $c;
    $img_position = $img_position + $img_line;
    $tax = ($all_total * 7) / 100;
} else {


    $c = 7.7;
    $img_position = 4.54;



    // var_dump($detail_array);
    // echo $sql;

    foreach ($detail_array as $row) {

        $pdf->SetXY(0.14, 0); //รายการ
        $pdf->MultiCell(0.6, $c, iconv('UTF-8', 'cp874', $row['list']), 0, 'L', 0);

        $pdf->SetXY(0, 0); //จำนวน 
        $pdf->MultiCell(1.2, $c, iconv('UTF-8', 'cp874', number_format($row['quantity'])), 0, 'R', 0);

        $pdf->SetXY(0, 0); //ราคา
        $pdf->MultiCell(2, $c, iconv('UTF-8', 'cp874', number_format($row['unit_price'],2)), 0, 'R', 0);

        $pdf->SetXY(0, 0); //จำนวนเงิน 
        $pdf->MultiCell(2.7, $c, iconv('UTF-8', 'cp874', number_format($row['total'], 2)), 0, 'R', 0);

        $c = $c + 0.35;

        $pdf->SetXY(0.14, 0); //รายการ
        $pdf->MultiCell(1.5, $c, iconv('UTF-8', 'cp874', $row['list_detail']), 0, 'L', 0);

        $c = $c + 0.35;

        $all_total += $row['total'];

        $img_line  += 0.35;
    }
    // echo $img_position;
    $b = $c;
    $img_position = $img_position + $img_line;
    $tax = ($all_total * 7) / 100;
}


$pdf->SetXY(0, 0); //รวมเป็นเงิน 
$pdf->MultiCell(2, $b + 0.6, iconv('UTF-8', 'cp874', "รวมเป็นเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //รวมเป็นเงิน 
$pdf->MultiCell(2.7, $b + 0.6, iconv('UTF-8', 'cp874', number_format($all_total, 2)), 0, 'R', 0);

$pdf->SetXY(0, 0); //ภาษีมูลค่าเพิ่ม 
$pdf->MultiCell(2, $b + 0.9, iconv('UTF-8', 'cp874', "ภาษีมูลค่าเพิ่ม"), 0, 'R', 0);
$pdf->SetXY(0, 0); //ภาษีมูลค่าเพิ่ม 
$pdf->MultiCell(2.7, $b + 0.9, iconv('UTF-8', 'cp874', number_format($tax, 2)), 0, 'R', 0);

$pdf->SetXY(0, 0); //จำนวนเงินรวมทั้งสิ้น 
$pdf->MultiCell(2, $b + 1.2, iconv('UTF-8', 'cp874', "จำนวนเงินรวมทั้งสิ้น"), 0, 'R', 0);
$pdf->SetXY(0, 0); //จำนวนเงินรวมทั้งสิ้น 
$pdf->MultiCell(2.7, $b + 1.2, iconv('UTF-8', 'cp874', number_format(($all_total + $tax), 2)), 0, 'R', 0);

$pdf->SetXY(0, 0); //ผู้รับบริหาร 
$pdf->MultiCell(1.7, $b + 1.7, iconv('UTF-8', 'cp874', "ผู้รับบริการ"), 0, 'R', 0);
$pdf->SetXY(0, 0); // ผู้รับบริหาร
// $pdf->MultiCell(1.3, $b + 1.5, iconv('UTF-8', 'cp874', $src), 0, 'R', 0);
if (isset($img_file)) {
    $pdf->Image($img_file, 2.2, $img_position, 0.4, 0.31, 'png'); //print_hrt_admonition_book
}


$pdf->SetXY(0, 0); //ผู้รับเงิน 
$pdf->MultiCell(1.42, $b + 2.38, iconv('UTF-8', 'cp874', "ผู้รับเงิน"), 0, 'R', 0);
$pdf->SetXY(0, 0); //ผู้รับเงิน 
$pdf->MultiCell(2.7, $b + 2.38, iconv('UTF-8', 'cp874', clean($row_customer['fullname'])), 0, 'R', 0);



$pdf->SetXY(0, 0); //Warehouse 
$pdf->MultiCell(1.65, $b + 2.68, iconv('UTF-8', 'cp874', "Warehouse"), 0, 'R', 0);
$pdf->SetXY(0, 0); //Warehouse 
$pdf->MultiCell(2.7, $b + 2.68, iconv('UTF-8', 'cp874', clean($row_customer['team_number'])), 0, 'R', 0);

$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(1.8, $b + 2.95, iconv('UTF-8', 'cp874', "Reference No."), 0, 'R', 0);
$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(2.7, $b + 2.95, iconv('UTF-8', 'cp874', clean($row_customer['job_no'])), 0, 'R', 0);

$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(2.4, $b + 3.45, iconv('UTF-8', 'cp874', "ธนาคารกสิกรไทย พีเบอร์รี่ ไทย 943-1-01321-2"), 0, 'R', 0);

$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(1.9, $b + 3.75, iconv('UTF-8', 'cp874', " สามารถหัก ณ ที่จ่ายได้"), 0, 'R', 0);

$pdf->SetXY(0, 0); //Reference No.   
$pdf->MultiCell(2.05, $b + 4.03, iconv('UTF-8', 'cp874', "(พร้อมแนบเอกสารฉบับจริง)"), 0, 'R', 0);

$pdf->Output();
