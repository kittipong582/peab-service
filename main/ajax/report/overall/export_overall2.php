<?php
session_start();
include('../../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

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

$job_type = $_POST['job_type'];
$product_type = $_POST['product_type'];
$status = $_POST['status'];
$team = $_POST['team'];
$staff = $_POST['staff'];
$type_date = $_POST['type_date'];

$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));


$condition = "";

$condition2 = "";
if ($job_type == '1') {
    $condition .= "AND a.job_type = 1";
} elseif ($job_type == '2') {
    $condition .= "AND a.job_type =2";
} elseif ($job_type == '3') {
    $condition .= "AND a.job_type =3";
} elseif ($job_type == '4') {
    $condition .= "AND a.job_type =4";
} elseif ($job_type == '5') {
    $condition .= "AND a.job_type =5";
} elseif ($job_type == '6') {
    $condition .= "AND a.job_type =6";
}


if ($status == 'x') {
    $condition .= '';
} else if ($status == '1') {
    $condition .= ' AND a.start_service_time IS NULL ';
} else if ($status == '2') {
    $condition .= ' AND a.start_service_time IS NOT NULL and a.finish_service_time IS NULL';
} else if ($status == '3') {
    $condition .= ' AND hold_status = 1';
} else if ($status == '4') {

    $condition .= ' AND a.finish_service_time IS NOT NULL and a.close_datetime IS NULL';
} else if ($status == '5') {

    $condition .= ' AND a.close_datetime IS NOT NULL ';
}


if ($team != "x") {
    $condition .= " AND f.branch_id = '$team' ";
}


if ($staff != "x") {
    $condition .= " AND g.user_id = '$staff' ";
}

switch ($type_date) {
    case "1":
        $condition .= " AND a.appointment_date BETWEEN '$start_date' AND  '$end_date'";
        break;
    case "2":
        $condition .= " AND a.create_datetime BETWEEN '$start_date' AND  '$end_date'";
}



$sql = "SELECT a.*,
b.sub_type_name,
c.branch_code,
c.branch_name AS cus_branch_name,
d.customer_name,
d.customer_code,
f.branch_name,
g.fullname,
h.serial_no,
k.type_name as product_type_name,
h.warranty_type,
h.warranty_expire_date,
i.brand_name,j.model_name,
k.type_name,
k.type_code,
c.district_id,
a.job_title as job_title,
a.initial_symptoms as initial_symptoms,
m.type_name as reason,
n.type_name as symptom
FROM tbl_job a 
LEFT JOIN tbl_sub_job_type b ON a.sub_job_type_id = b.sub_job_type_id 
LEFT JOIN tbl_customer_branch c ON a.customer_branch_id = c.customer_branch_id 
LEFT JOIN tbl_customer d ON c.customer_id = d.customer_id 
LEFT JOIN tbl_branch f ON a.care_branch_id = f.branch_id 
LEFT JOIN tbl_user g ON a.responsible_user_id = g.user_id 
LEFT JOIN tbl_product h ON a.product_id = h.product_id 
LEFT JOIN tbl_product_brand i ON h.brand_id = i.brand_id 
LEFT JOIN tbl_product_model j ON h.model_id = j.model_id 
LEFT JOIN tbl_product_type k ON h.product_type = k.type_id
LEFT JOIN tbl_fixed l ON a.job_id = l.job_id
LEFT JOIN tbl_reason_type m ON l.reason_type_id = m.reason_type_id
LEFT JOIN tbl_symptom_type n ON l.symptom_type_id = n.symptom_type_id
    WHERE a.cancel_datetime IS NULL $condition 
    ORDER BY a.job_no DESC";

//echo $sql;
$rs = mysqli_query($connection, $sql);

// ///////////////////////////////////////////////////////////////////////////



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

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ประเภทงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(15);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'กิจกรรม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, 'ประเภทงานย่อย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(25);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, 'รหัสสาขา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, 'ลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(25);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, 'ชื่อร้าน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[6])->setWidth(35);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, 'เขตพื้นที่');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[7])->setWidth(35);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, 'ในประกัน/นอกประกัน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[8])->setWidth(35);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, 'วันที่เปิดงาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[9])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, 'วันที่นัดหมาย');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[10])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, 'check in');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[11])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, 'check out');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, 'SLA');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[13])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, 'ประเภทเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[14])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, 'หมายเลขเครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[15])->setWidth(30);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, 'เครื่อง');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[16])->setWidth(40);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, 'อาการแจ้งซ่อม');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[17])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, 'สาเหตุของปัญหา');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[18])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, 'วิธีแก้ไข');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[19])->setWidth(20);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, 'ทีมที่ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[20])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, 'ช่างผู้ดูแล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[21])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, 'สถานะ');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[22])->setWidth(16);


$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, 'รายได้');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[23])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, 'เงินสด');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[24])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, 'เงินโอน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[25])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, 'วางบิล');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[26])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, 'เลข SO');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[27])->setWidth(16);




$objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(11);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;


while ($row = mysqli_fetch_assoc($rs)) {

    $sql_district = "SELECT c.province_name_th FROM tbl_district a 
    LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
    LEFT JOIN tbl_province c ON b.ref_province = c.province_id
    WHERE a.district_id = '{$row['district_id']}'";
    $rs_district = mysqli_query($connection, $sql_district);
    $row_district = mysqli_fetch_array($rs_district);

    $total_income = 0;
    $sql_income = "SELECT income_amount,quantity FROM tbl_job_income WHERE job_id = '{$row['job_id']}'";
    $rs_income = mysqli_query($connection, $sql_income);
    while ($row_income = mysqli_fetch_array($rs_income)) {

        $total_income += ($row_income['income_amount'] * $row_income['quantity']);
    }

    $product = "ยี่ห้อ: " . $row['brand_name'] . " รุ่น: " . $row['model_name'];
    ////////////////////ประกัน
    $now = strtotime("today");
    $expire_date = strtotime($row['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain <= 0) {
        $warranty_remain = "หมดประกัน";
    } else {
        $warranty_remain = "ในประกัน";
    }


    $cash = 0;
    $transfer = 0;
    $bill = 0;
    $sql_payment = "SELECT cash_amount,transfer_amount,customer_cost FROM tbl_job_payment_file WHERE job_id = '{$row['job_id']}'";
    $rs_payment = mysqli_query($connection, $sql_payment);
    while ($row_payment = mysqli_fetch_array($rs_payment)) {

        $cash += $row_payment['cash_amount'];
        $transfer += $row_payment['transfer_amount'];
        $bill += $row_payment['customer_cost'];
    }


    if ($row['job_type'] == 1) {
        $job_type = "CM";
    } elseif ($row['job_type'] == 2) {
        $job_type = "PM";
    } else if ($row['job_type'] == 3) {
        $job_type = "INSTALLATION";
    } else if ($row['job_type'] == 5) {
        $job_type = "งานอื่นๆ";
    } else if ($row['job_type'] == 4) {
        $job_type = 'OVERHAUL';
    } else if ($row['job_type'] == 6) {
        $job_type = 'เสนอราคา';
    }

    $h = ($row['start_service_time'] == "") ? '' : (date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time'])));
    $m = ($row['start_service_time'] == "") ? '' : ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
    $working_time = $h . "." . number_format(abs($m));


    $h_late = ($row['start_service_time'] == "") ? '' : (date('H', strtotime($row['start_service_time'])) - date('H', strtotime($row['appointment_time_start'])));
    $m_late = ($row['start_service_time'] == "") ? '' : ((date('i', strtotime($row['start_service_time'])) - date('i', strtotime($row['appointment_time_start']))) / 60) * 10;
    $late_time = ($h_late <= 0) ? '0' : $h_late . "." . number_format(abs($m_late));



    if ($row['cancel_datetime'] != null) {
        $job_status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {
        $job_status = "ปิดงาน" . " " . " " . str_replace("&nbsp;", "", strip_tags($row['close_note'])) . " ";
    } else if ($row['finish_service_time'] != null) {
        $job_status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
        $stajob_statustus = "กำลังดำเนินการ" . " " . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {
        $job_status = "เปิดงาน";
    }

    $datetime1 = strtotime($row['create_datetime']);
    $datetime2 = strtotime($row['finish_service_time']);
    $interval = abs($datetime2 - $datetime1);
    $minutes = round($interval / 60);
    $sla_status = "";
    if ($datetime2 != NULL) {
        if ($minutes > 2880) {
            $sla_status = $minutes . "  (inactive)";
        } else {
            $sla_status = $minutes . "  (active)";
        }
    }

    //order_no
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    //ประเภทงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, $job_type);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    //ประเภทงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['job_title']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $row['sub_type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $row['branch_code']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    //ลูกค้า
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    //ชื่อร้าน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[6] . $rowCell, $row['cus_branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[6] . $rowCell . ':' . $columnCharacter[6] . ($rowCell));

    //ที่อยู่ร้าน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[7] . $rowCell, $row_district['province_name_th']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[7] . $rowCell . ':' . $columnCharacter[7] . ($rowCell));

    //////////////ประกัน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[8] . $rowCell, $warranty_remain);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[8] . $rowCell . ':' . $columnCharacter[8] . ($rowCell));

    //  วันที่เปิดงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[9] . $rowCell, ($row['create_datetime'] == "") ? "-" : date("d/m/Y", strtotime($row['create_datetime'])));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[9] . $rowCell . ':' . $columnCharacter[9] . ($rowCell));

    //วันที่นัดหมาย
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[10] . $rowCell, ($row['appointment_date'] == "") ? "-" : $row['appointment_date']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[10] . $rowCell . ':' . $columnCharacter[10] . ($rowCell));



    //check_in
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[11] . $rowCell, $row['start_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[11] . $rowCell . ':' . $columnCharacter[11] . ($rowCell));


    //check_out
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[12] . $rowCell, $row['finish_service_time']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[12] . $rowCell . ':' . $columnCharacter[12] . ($rowCell));


    //SLA
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[13] . $rowCell, $sla_status);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[13] . $rowCell . ':' . $columnCharacter[13] . ($rowCell));



    //ประเภทเครื่อง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[14] . $rowCell, $row['product_type_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[14] . $rowCell . ':' . $columnCharacter[14] . ($rowCell));

    //หมายเลขเครื่อง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[15] . $rowCell, $row['serial_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[15] . $rowCell . ':' . $columnCharacter[15] . ($rowCell));

    //เครื่อง
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[16] . $rowCell, $product);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[16] . $rowCell . ':' . $columnCharacter[16] . ($rowCell));

    //อาการแจ่งซ่อม
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[17] . $rowCell, $row['initial_symptoms']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[17] . $rowCell . ':' . $columnCharacter[17] . ($rowCell));

    //อาการเสีย
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[18] . $rowCell, $row['symptom']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[18] . $rowCell . ':' . $columnCharacter[18] . ($rowCell));

    //วิธีแก้
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[19] . $rowCell, $row['reason']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[19] . $rowCell . ':' . $columnCharacter[19] . ($rowCell));

    //ทีมงาน
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[20] . $rowCell, $row['branch_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[20] . $rowCell . ':' . $columnCharacter[20] . ($rowCell));

    //ชาสงดูแล
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[21] . $rowCell, $row['fullname']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[21] . $rowCell . ':' . $columnCharacter[21] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[22] . $rowCell, $job_status);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[22] . $rowCell . ':' . $columnCharacter[22] . ($rowCell));


    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[23] . $rowCell, number_format($total_income, 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[23] . $rowCell . ':' . $columnCharacter[23] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[24] . $rowCell, number_format($cash, 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[24] . $rowCell . ':' . $columnCharacter[24] . ($rowCell));
    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[25] . $rowCell, number_format($transfer, 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[25] . $rowCell . ':' . $columnCharacter[25] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[26] . $rowCell, number_format($bill, 2));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[26] . $rowCell . ':' . $columnCharacter[26] . ($rowCell));

    //สถานะ
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[27] . $rowCell, $row['so_no']));
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[27] . $rowCell . ':' . $columnCharacter[27] . ($rowCell));



    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[27] . ($rowCell))->applyFromArray($styleTextCenter)->getAlignment()->setWrapText(true);

    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[1] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[3] . $rowCell . ':' . $columnCharacter[7] . ($rowCell))->applyFromArray($styleTextCenter);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[8] . $rowCell . ':' . $columnCharacter[9] . ($rowCell))->applyFromArray($styleTextLeft);
    // $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[10] . $rowCell . ':' . $columnCharacter[16] . ($rowCell))->applyFromArray($styleTextCenter);



    $rowCell++;
}

// /*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_name = "ReportOverall" . "_" . date("d-m-Y H:i:s");
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