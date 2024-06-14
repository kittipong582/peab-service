<?php
session_start();
include('../../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$type_select = $_POST['type_select'];
$appointment_date = explode(',', $_POST['appointment_date']);
$product_select = $_POST['product_select'];
$status = $_POST['status'];

$condition = "";
$condition2 = "";
if ($type_select == 1) {

    $start_date = explode('/', $appointment_date[0]);
    $start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

    $end_date = explode('/', $appointment_date[1]);
    $end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

    $condition = "AND d.appointment_date BETWEEN '$start_date' AND '$end_date'";
} else {
    $appointment_date = explode('/',  $_POST['appointment_date']);
    $year = $appointment_date['1'];
    $month = $appointment_date['0'];
    $condition = "AND MONTH(d.appointment_date) = '$month' and YEAR(d.appointment_date) = '$year'";
}

if ($status == 'x') {
    $condition .= '';
    $condition2 .= '';
} else if ($status == '1') {
    $condition .= ' AND d.appointment_date IS NOT NULL AND d.start_service_time IS NULL AND d.finish_service_time IS NULL';

} else if ($status == '2') {
    $condition .= ' AND d.start_service_time IS NOT NULL and d.finish_service_time IS NULL';

} else if ($status == '3') {
    $condition .= ' AND hold_status = 1';
    $condition2 .= ' AND hold_status = 1';
} else if ($status == '4') {

    $condition .= ' AND d.finish_service_time IS NOT NULL and d.close_datetime IS NULL';


} else if ($status == '5') {

    $condition .= ' AND d.close_datetime IS NOT NULL ';
  
} else if ($status == '6') {
    $condition .= 'AND DATE(d.appointment_date) != CURDATE() AND d.finish_service_time IS NULL ';
 
}

// set_time_limit(0);
/** PHPExcel */
require('../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */
require('../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');




// สร้าง object ของ Class  PHPExcel  ขึ้นมาใหม่
$objPHPExcel = new PHPExcel();

// กำหนดค่าต่างๆ
$objPHPExcel->getProperties()->setCreator("Company Co., Ltd.");
$objPHPExcel->getProperties()->setLastModifiedBy("Company Co., Ltd.");
$objPHPExcel->getProperties()->setTitle("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX ReportQuery Document");
$objPHPExcel->getProperties()->setDescription("ReportQuery from Company Co., Ltd.");

$sheet = $objPHPExcel->getActiveSheet();
$pageMargins = $sheet->getPageMargins();


// margin is set in inches (0.5cm)
$margin = 0.5 / 2.54;
$pageMargins->setTop($margin);
$pageMargins->setBottom($margin);
$pageMargins->setLeft($margin);
$pageMargins->setRight(0);


/////////////////////////////////////////////////////////////////////////////



$sql = "SELECT a.product_id,a.serial_no,a.warranty_start_date,a.warranty_expire_date,a.install_date,
b.brand_name,
c.model_name,
e.type_name,
d.job_id,d.appointment_date,d.finish_service_time,d.start_service_time,d.create_datetime AS job_create_date ,d.customer_branch_id,d.initial_symptoms,d.cancel_datetime,d.close_user_id,
f.branch_name,f.team_number
FROM tbl_product a
LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
LEFT JOIN tbl_product_model c ON a.model_id = c.model_id 
LEFT JOIN tbl_job d ON a.product_id = d.product_id
LEFT JOIN tbl_product_type e ON a.product_type = e.type_id
LEFT JOIN tbl_branch f ON d.care_branch_id = f.branch_id
WHERE d.job_type = 1 $condition $condition2
    ;";
// echo $sql;
$rs = mysqli_query($connection, $sql);
// $row = mysqli_fetch_array($rs);



/////////////////////////////////////////////////////////////////////////////


$styleHeader = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'fill' => array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'color' => array('rgb' => 'FFFF00'),
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'font' => array(
        'bold' => true,
        'size' => 10,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleNumber = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),

    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_green = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => '21BA21'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_red = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => 'FF0000'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleText_blue = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
        'color' => array('rgb' => '0000FF'),
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

// 'color' => array('rgb' => '32CD32'),
$styleTextCenter = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextLeft = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextRight = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'borders' => array(
        'allborders' => array(
            'style' => PHPExcel_Style_Border::BORDER_THIN,
            'color' => array('rgb' => '#000000')
        )
    ),
    'font' => array(
        'size' => 9,
        'name' => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);



$columnCharacter = array(
    'A',
    'B',
    'C',
    'D',
    'E',
    'F',
    'G',
    'H',
    'I',
    'J',
    'K',
    'L',
    'M',
    'N',
    'O',
    'P',
    'Q',
    'R',
    'S',
    'T',
    'U',
    'V',
    'W',
    'X',
    'Y',
    'Z',
    'AA',
    'AB',
    'AC',
    'AD',
    'AE',
    'AF',
    'AG',
    'AH',
    'AI',
    'AJ',
    'AK',
    'AL',
    'AM',
    'AN',
    'AO',
    'AP',
    'AQ',
    'AR',
    'AS',
    'AT',
    'AU',
    'AV',
    'AW',
    'AX',
    'AY',
    'AZ',
    'BA',
    'BB',
    'BC',
    'BD',
    'BE',
    'BF',
    'BG',
    'BH',
    'BI',
    'BJ',
    'BK',
    'BL',
    'BM',
    'BN',
    'BO',
    'BP',
    'BQ',
    'BR',
    'BS',
    'BT',
    'BU',
    'BV',
    'BW',
    'BX',
    'BY',
    'BZ'
);

/*------------------------------------------------------------------------------------------------------------------------------*/

// หัวตาราง
$rowCell = 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'วันที่เปิดงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'วันที่เข้างาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'วันที่ออกงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'ยี่ห้อ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'รุ่น');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(35);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'ประเภทเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'วันที่ติดตั้ง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'วันที่เริ่มประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'วันที่หมดอายุประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'รหัสสาขา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'ชื่อลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'ชื่อร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[12])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'จังหวัด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'ทีมดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'อาการเสียเบื้องต้น');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(50);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'อาการ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'ปัญหา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'หมายเหตุ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(50);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, 'สถานะ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[19])->setWidth(50);




$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(12);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[19] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[19] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;

while ($row = mysqli_fetch_array($rs)) {


    $sql_customer = "SELECT a.branch_code,b.customer_name,a.branch_name,a.district_id FROM tbl_customer_branch a
    LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id 
    WHERE a.customer_branch_id = '{$row['customer_branch_id']}'";
    $rs_customer = mysqli_query($connection, $sql_customer);
    $row_customer = mysqli_fetch_array($rs_customer);


    $sql_district = "SELECT c.province_name_th FROM tbl_district a 
    LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
    LEFT JOIN tbl_province c ON b.ref_province = c.province_id
    WHERE a.district_id = '{$row_customer['district_id']}'";
    $rs_district = mysqli_query($connection, $sql_district);
    $row_district = mysqli_fetch_array($rs_district);
   

    $initial_symptoms = str_replace("<p>", "", strip_tags($row['initial_symptoms']));
    $initial_symptoms = str_replace("</p>", "\n", $initial_symptoms);
    $initial_symptoms = str_replace("&nbsp;", "\n", $initial_symptoms);
    $initial_symptoms = str_replace("<br>", "\n", $initial_symptoms);

    $fixed_remark = "";
    $symptom_name = "";
    $reason_name = "";
    $sql_fixed = "SELECT b.type_name as symptom_name,c.type_name as reason_name,a.remark FROM tbl_fixed a 
    LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id 
    lEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id 
    WHERE a.job_id = '{$row['job_id']}'";
    $rs_fixed = mysqli_query($connection, $sql_fixed);
    $num_fixed = 0;
    while ($row_fixed = mysqli_fetch_array($rs_fixed)) {

        if ($num_fixed != 0) {
            $comma = ",";
        } else {
            $comma = "";
        }
        $remark = str_replace("<p>", "", strip_tags($row_fixed['remark']));
        $remark = str_replace("</p>", "\n", $remark);
        $remark = str_replace("&nbsp;", "\n", $remark);
        $remark = str_replace("<br>", "\n", $remark);

        $fixed_remark .= $remark . $comma;
        $symptom_name .= strip_tags($row_fixed['symptom_name']) . $comma;
        $reason_name .= strip_tags($row_fixed['reason_name']) . $comma;
        $num++;
    }


    if ($row['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {
        $status = "ปิดงาน";
    } else if ($row['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $status = "กำลังดำเนินการ";
    } else if ($row['start_service_time'] == null) {
        $status = "เปิดงาน";
    }



    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, date("d-m-Y", strtotime($row['job_create_date'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $row['start_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['finish_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row['serial_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['brand_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row['model_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, ($row['install_date'] != NULL) ? date("d-m-Y", strtotime($row['install_date'])) : "-");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, ($row['warranty_start_date'] != NULL) ? date("d-m-Y", strtotime($row['warranty_start_date'])) : "-");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, ($row['warranty_expire_date'] != NULL) ? date("d-m-Y", strtotime($row['warranty_expire_date'])) : "-");
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, $row_customer['branch_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, $row_customer['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, $row_customer['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, $row_district['province_name_th']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, $row['team_number'] . " - " . $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, $initial_symptoms);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, $symptom_name);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, $reason_name);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, $fixed_remark);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));


    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, $status);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));



    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[19] . ($rowCell))->applyFromArray($styleTextCenter);

    $rowCell++;
}

/*-------------------------------------------------------------------------------------------------------------------------------*/

// $objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "รายงานซ่อม" . "_" . date("d-m-Y");
//
// Save Excel 2007 file
#echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx');

$objWriter->save('php://output');

exit();
