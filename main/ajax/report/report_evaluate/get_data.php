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

// echo $sql_job;
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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleHeaderNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),
    'font'  => array(
        'bold'  => true,
        'size'  => 10,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);

$styleTextNoBorder = array(
    //'fill' => array('type' => PHPExcel_Style_Fill::FILL_SOLID,'color' => array('rgb' => 'ffff00')),

    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
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
    'font'  => array(
        'size'  => 9,
        'name'  => 'Arial',
    ),
    'alignment' => array(
        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_RIGHT,
        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
    )
);



$columnCharacter = array(
    'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T',
    'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP',
    'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH', 'BI', 'BJ', 'BK',
    'BL', 'BM', 'BN', 'BO', 'BP', 'BQ', 'BR', 'BS', 'BT', 'BU', 'BV', 'BW', 'BX', 'BY', 'BZ'
);

/*------------------------------------------------------------------------------------------------------------------------------*/
$sql_top = "SELECT GROUP_CONCAT(detail) AS detail_top , MAX(list_order) AS max_list FROM tbl_job_evaluate ORDER BY list_order ASC";
$res_top = mysqli_query($connection, $sql_top);
$row_top = mysqli_fetch_assoc($res_top);
$topic = explode(',', $row_top['detail_top']);

// หัวตาราง
$rowCell = 1;

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, 'เลขที่งาน');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[0])->setWidth(16);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell, 'ประเภท');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[1])->setWidth(20);

$objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, 'ลูกค้า');
$objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));
$objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[2])->setWidth(40);

$count = $row_top['max_list'] + 3;
$top_count = 0;

for ($i = 3; $i < $count; $i++) {
    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$i] . $rowCell, $topic[$top_count]);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$i] . $rowCell . ':' . $columnCharacter[$i] . ($rowCell));
    $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[$i])->setWidth(20);
    $top_count++;
}

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $topic[0]);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));
// $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[3])->setWidth(20);

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $topic[1]);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));
// $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[4])->setWidth(20);

// $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $topic[2]);
// $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));
// $objPHPExcel->getActiveSheet()->getColumnDimension($columnCharacter[5])->setWidth(20);

# code...
// $objPHPExcel->getActiveSheet()->getRowDimension('4')->setRowHeight(3);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[$i - 1] . ($rowCell))->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[$i - 1] . ($rowCell))->applyFromArray($styleHeader);



$rowCell = 2;

// echo $sql_main;

$customer_id = mysqli_real_escape_string($connection, $_POST['customer_id']);
$type_select = mysqli_real_escape_string($connection, $_POST['type_select']);

if ($customer_id != 'x') {
    $cus_condition = "e.customer_id = '$customer_id'";
} else {
    $cus_condition = "";
}

if ($type_select != 'x') {
    ($cus_condition) != "" ? $con_type = " AND " : $con_type = "";
    $type_condition = $con_type . "b.job_type = '$type_select'";
} else {
    $type_condition = "";
}

$sql = "SELECT 
b.job_no
,b.job_type
,e.customer_name
,GROUP_CONCAT(c.detail) AS detail
,GROUP_CONCAT(a.evaluate_score) AS score
FROM tbl_job_evaluate_record a
LEFT JOIN tbl_job b ON b.job_id = a.job_id
LEFT JOIN tbl_job_evaluate c ON c.evaluate_id = a.evaluate_id
LEFT JOIN tbl_customer_branch d ON d.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer e ON e.customer_id = d.customer_id
WHERE $cus_condition $type_condition
GROUP BY a.job_id;
";
$res = mysqli_query($connection, $sql);

while ($row = mysqli_fetch_assoc($res)) {

    $score = explode(',', $row['score']);

    if ($row['job_type'] == 1) {
        $type_text = "CM";
    }elseif ($row['job_type'] == 2) {
        $type_text = "PM";
    }elseif ($row['job_type'] == 3) {
        $type_text = "Installation";
    }elseif ($row['job_type'] == 4) {
        $type_text = "overhaul";
    }elseif ($row['job_type'] == 5) {
        $type_text = "อื่นๆ";
    }elseif ($row['job_type'] == 6) {
        $type_text = "เสนอราคา";
    }

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[0] . $rowCell, $row['job_no']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[0] . $rowCell . ':' . $columnCharacter[0] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[1] . $rowCell,$type_text);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[1] . $rowCell . ':' . $columnCharacter[1] . ($rowCell));

    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[2] . $rowCell, $row['customer_name']);
    $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[2] . $rowCell . ':' . $columnCharacter[2] . ($rowCell));

    $cunt_score = 0;
    for ($j = 3; $j < $count; $j++) {
        
        if ($score[$cunt_score] == 5) {
            $score_text = "พึงพอใจมากที่สุด";
        }elseif ($score[$cunt_score] == 4) {
            $score_text = "พึงพอใจมาก";
        }elseif ($score[$cunt_score] == 3) {
            $score_text = "พึงพอใจปานกลาง";
        }elseif ($score[$cunt_score] == 2) {
            $score_text = "พึงพอใจน้อย";
        }elseif ($score[$cunt_score] == 1) {
            $score_text = "พึงพอใจน้อยที่สุด";
        }

     
        $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[$j] . $rowCell, $score_text);
        $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[$j] . $rowCell . ':' . $columnCharacter[$j] . ($rowCell));
        $cunt_score++;
    }

    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[3] . $rowCell, $score[0]);
    // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[3] . $rowCell . ':' . $columnCharacter[3] . ($rowCell));

    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[4] . $rowCell, $score[1]);
    // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[4] . $rowCell . ':' . $columnCharacter[4] . ($rowCell));

    // $objPHPExcel->setActiveSheetIndex(0)->setCellValue($columnCharacter[5] . $rowCell, $score[2]);
    // $objPHPExcel->setActiveSheetIndex(0)->mergeCells($columnCharacter[5] . $rowCell . ':' . $columnCharacter[5] . ($rowCell));

    $objPHPExcel->getActiveSheet()->getStyle($columnCharacter[0] . $rowCell . ':' . $columnCharacter[$j-1] . ($rowCell))->applyFromArray($styleTextCenter);

    $rowCell++;
}


/*-------------------------------------------------------------------------------------------------------------------------------*/

$objPHPExcel->setActiveSheetIndex(0);
//ตั้งชื่อไฟล์
$file_job = "รายงานการการประเมิน";
//
// Save Excel 2007 file
#echo date('H:i:s') . " Write to Excel2007 format\n";
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
ob_end_clean();
// We'll be outputting an excel file
header('Content-type: application/vnd.ms-excel');
// It will be called file.xls
header('Content-Disposition: attachment;filename="' . $file_job . '.xlsx');

$objWriter->save('php://output');

exit();
