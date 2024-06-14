<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

include('../import_product_qc/vendor/autoload.php');

$styleHead = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
$styleHeadLaber = [
    'font' => [
        'bold' => true,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
];

$styleTextCenter = [
    'font' => [
        'bold' => false,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
    ],
];

$styleTextLeft = [
    'font' => [
        'bold' => false,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT,
    ],
];
$styleTextCRight = [
    'font' => [
        'bold' => false,
    ],
    'alignment' => [
        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_RIGHT,
    ],
];
$styleTextBorders = [
    'borders' => [
        'allBorders' => [
            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        ],
    ],
];
/////////////////////////////////////////////////////////////////////////////
$temp_start_date = explode("/", $_POST['start_date']);
$start_date = date("Y-m-d", strtotime($temp_start_date[0] . "-" . $temp_start_date[1] . "-" . $temp_start_date[2]));

$temp_end_date = explode("/", $_POST['end_date']);
$end_date = date("Y-m-d", strtotime($temp_end_date[0] . "-" . $temp_end_date[1] . "-" . $temp_end_date[2]));

$sql = "SELECT a.*,b.branch_name,b.branch_code,c.customer_name,c.phone,d.fullname,d.mobile_phone,e.start_datetime,e.close_datetime,e.group_id
FROM tbl_job_audit a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.customer_branch_id 
LEFT JOIN tbl_customer c ON c.customer_id = a.customer_id 
LEFT JOIN tbl_user d ON d.user_id = a.create_user_id
LEFT JOIN tbl_job_audit_group e ON a.group_id = e.group_id
WHERE e.start_datetime BETWEEN '$start_date' AND '$end_date'
GROUP BY a.group_id";

$res = mysqli_query($connect_db, $sql);


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

$excelSheet = new Spreadsheet();
$sheet = $excelSheet->getActiveSheet();

$rowCell = 1;
$columnCharacter = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
$columnHeaderName = array(
    "วันที่ทำรายการ", "ผู้ทำรายการ", "สาขา", "คะแนน"
);
$num_header = count($columnHeaderName);
$c = 0;
for ($i = 0; $i < $num_header; $i++) {
    $excelSheet->getActiveSheet()->setCellValue($columnCharacter[$c] . $rowCell, $columnHeaderName[$c]);
    $c++;
}

$rowCell = 2;

// $sql_score = "SELECT COUNT(rec.score) AS total_score , SUM(rec.score) AS aws_score ,form.audit_name
// FROM tbl_audit_record rec
// LEFT JOIN tbl_job_audit job ON rec.job_id = job.job_id
// LEFT JOIN tbl_audit_form form ON job.audit_id = form.audit_id
// GROUP BY rec.job_id";
// $res_score = mysqli_query($connect_db, $sql_score);

// while ($row_score =  mysqli_fetch_assoc($res_score)) {
//   echo $aws = $row_score["audit_name"] . ' : ' .$row_score["aws_score"] . ' / ' . $row_score['total_score'];
// }


while ($row = mysqli_fetch_array($res)) {

    $sql_score = "SELECT COUNT(rec.score) AS total_score , SUM(rec.score) AS aws_score ,form.audit_name
    FROM tbl_audit_record rec
    LEFT JOIN tbl_job_audit job ON rec.job_id = job.job_id
    LEFT JOIN tbl_audit_form form ON job.audit_id = form.audit_id
    WHERE job.group_id = '{$row["group_id"]}'
    GROUP BY rec.job_id";
    $res_score = mysqli_query($connect_db, $sql_score);
    $aws = '';
    while ($row_score =  mysqli_fetch_assoc($res_score)) {
        $aws .= $row_score["audit_name"] . ' : ' . $row_score["aws_score"] . ' / ' . $row_score['total_score'] . "\n";
    }

    $excelSheet->getActiveSheet()->setCellValue("A" . $rowCell, ($row["appointment_date"] != "" ? date("d/m/Y", strtotime($row["appointment_date"])) : ""));
    $excelSheet->getActiveSheet()->setCellValue("B" . $rowCell, ($row["fullname"] != "" ? $row["fullname"] : ""));
    $excelSheet->getActiveSheet()->setCellValue(
        "C" . $rowCell,
        ($row["customer_name"] != "" ? $row["customer_name"] : "")
            . "\n" . ($row["phone"] != "" ? $row["phone"] : "")
            . "\n" . ($row["branch_code"] != "" ? $row["branch_code"] : "")
            . "\n" . ($row["branch_name"] != "" ? $row["branch_name"] : "")
    );

    $excelSheet->getActiveSheet()->setCellValue("D" . $rowCell, $aws);

    $excelSheet->getActiveSheet()->getStyle("A" . $rowCell . ":B" . $rowCell)->getAlignment()->setVertical('top');
    $excelSheet->getActiveSheet()->getStyle("C" . $rowCell)->getAlignment()->setWrapText(true);
    $excelSheet->getActiveSheet()->getStyle("D" . $rowCell)->getAlignment()->setWrapText(true)->setVertical('top');

    $rowCell++;
}
$excelSheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(TRUE);
$excelSheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(TRUE);
$excelSheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(TRUE);
$excelSheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(TRUE);

$filename = "รายงาน Audit วันที่ " . date("d-m-y", strtotime($start_date)) . " - " . date("d-m-y", strtotime($end_date)) . ".xlsx";
$writer = new Xlsx($excelSheet);
$writer = IOFactory::createWriter($excelSheet, 'Xlsx');
$callStartTime = microtime(true);
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment; filename="' . $filename . '"');
$writer->save('php://output');
