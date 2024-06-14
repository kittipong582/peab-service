<?php
session_start();
set_time_limit(0);
include ("../../../config/main_function.php");

include ("vendor/autoload.php");
include ("config/spreadsheet.php");

$connection = connectDB("LM=VjfQ{6rsm&/h`");
date_default_timezone_set("Asia/Bangkok");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

$create_user_id = $_SESSION['user_id'];

$Success = 0;
$Fail = 0;

$list = array();
$date = date("Y-m-d");
$datetime = date("Y-m-d H:i:s");
$allowedFileType = [
    'application/vnd.ms-excel',
    'text/xls',
    'text/xlsx',
    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet'
];

if ($_FILES["file_upload"]["name"] != "") {
    if (in_array($_FILES["file_upload"]["type"], $allowedFileType)) {
        $file = explode(".", $_FILES['file_upload']['name']);
        $file_surname = end($file);
        $filename_excel = md5(date("dmYhis") . rand(1000, 9999)) . "." . $file_surname;
        $targetPath = "../../upload/excel/" . $filename_excel;
        if (move_uploaded_file($_FILES["file_upload"]["tmp_name"], $targetPath)) {

            $i = 0;
            $spreadsheet = IOFactory::load($targetPath);
            $worksheet = $spreadsheet->getActiveSheet();
            $lastRow = $worksheet->getHighestRow();

            for ($row = 2; $row <= $lastRow; $row++) {
                ++$i;
                $list[$i]["list"] = trim((string) $worksheet->getCell('A' . $row)->getValue());
                $list[$i]["confirm_date"] = trim((string) $worksheet->getCell('B' . $row)->getValue());
                
                $list[$i]["branch_code"] = trim((string) $worksheet->getCell('C' . $row)->getValue());
                $list[$i]["serial_no"] = trim((string) $worksheet->getCell('F' . $row)->getValue());
                $list[$i]["error"] = "";
            }
            // var_dump($list);

            foreach ($list as $x => $row) {
                $temp_error = "";
                $branch_code = $row["branch_code"];
                $serial_no = $row["serial_no"];


                if ($branch_code == "" || $serial_no == "") {
                    $check_blank = false;
                    $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "";
                } else {
                    $check_blank = true;
                }


                if ($check_blank == true) {

                    $queue_id = getRandomID(10, "tbl_customer_queue", "queue_id");

                    $sql_check = "SELECT MAX(queue_no) AS Max_listorder FROM tbl_customer_queue";
                    $res_check = mysqli_query($connection, $sql_check);
                    $row_check = mysqli_fetch_assoc($res_check);

                    if ($row_check >= 1) {
                        $list_order = $row_check['Max_listorder'] + 1;
                    } else {
                        $list_order = 1;
                    }

                    $sql_branch = "SELECT customer_branch_id,branch_code FROM tbl_customer_branch WHERE branch_code = '$branch_code'";
                    $res_branch = mysqli_query($connection, $sql_branch);
                    $row_branch = mysqli_fetch_assoc($res_branch);

                    if (($row_branch['customer_branch_id'] == '')) {
                        $Fail++;
                        $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Customer branch ID is empty";
                        $list[$x]["error"] = $temp_error;
                    }

                    $sql_insert = "INSERT INTO tbl_customer_queue SET 
                        queue_id = '$queue_id',
                        queue_no = '$list_order',
                        create_user_id = '$create_user_id', 
                        branch_code = '$branch_code',
                        customer_branch_id  = '{$row_branch['customer_branch_id']}',
                        serial_no = '$serial_no'";
                    $insert = mysqli_query($connection, $sql_insert);
                    if ($insert) {
                        $Success++;
                    } else {
                        $Fail++;
                        $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Import Fail";
                        $list[$x]["error"] = $temp_error;
                    }
                } else {
                    $Fail++;
                    $list[$x]["error"] = $temp_error;
                }
            }

            // if (unlink($targetPath)) {
            //     $Delete = 1;
            // } else {
            //     $Delete = 0;
            // }

            if ($Success > 0) {
                $result = 1;
            } else {
                $result = 0;
                $msg = "Upload fail (0).";
            }
        } else {
            $result = 0;
            $msg = "Upload fail (1).";
        }
    } else {
        $result = 0;
        $msg = "Uploads are limited to files with extensions (.xlsx, .xls) only.";
    }
} else {
    $result = 0;
    $msg = "Upload fail (2).";
}
// var_dump($list);
if ($Fail > 0) {

    $excelSheet = new Spreadsheet();
    $sheet = $excelSheet->getActiveSheet();

    $excelSheet->getDefaultStyle()->getFont()->setName('TH Sarabun New');
    $excelSheet->getDefaultStyle()->getFont()->setSize(12);

    $rowCell = 1;
    $columnCharacter = array("A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z");
    $columnHeaderName = array(
        "ลำดับ",
        "ลูกค้าอนุมัติ",
        "รหัสร้าน",
        "S/N",
        "Error",
    );
    $num_header = count($columnHeaderName);
    $c = 0;
    for ($i = 0; $i < $num_header; $i++) {
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[$c] . $rowCell, $columnHeaderName[$c]);
        $c++;
    }
    $excelSheet->getActiveSheet()->getStyle("A" . $rowCell . ":" . $columnCharacter[($c - 1)] . $rowCell)->applyFromArray($styleHead);
    $excelSheet->getActiveSheet()->setAutoFilter("A" . $rowCell . ":" . $columnCharacter[($c - 1)] . $rowCell);
    // var_dump($list);
    $rowCell = 2;
    foreach ($list as $key => $import) {


            $excelSheet->getActiveSheet()->setCellValue($columnCharacter[0] . $rowCell, ($import["list"] != "" ? $import["list"] : ""));
            $excelSheet->getActiveSheet()->setCellValue($columnCharacter[1] . $rowCell, ($import["confirm_date"] != "" ? $import["confirm_date"] : ""));
            $excelSheet->getActiveSheet()->setCellValue($columnCharacter[2] . $rowCell, ($import["branch_code"] != "" ? $import["branch_code"] : ""));
            $excelSheet->getActiveSheet()->setCellValue($columnCharacter[3] . $rowCell, ($import["serial_no"] != "" ? $import["serial_no"] : ""));
            $excelSheet->getActiveSheet()->setCellValue($columnCharacter[4] . $rowCell, ($import["error"] != "" ? $import["error"] : ""));
            $rowCell++;
    
    }



    $filename = "Form Import queue Qc Error (" . date("Y-m-d His") . ")" . ".xlsx";
    $writer = new Xlsx($excelSheet);
    $writer = IOFactory::createWriter($excelSheet, 'Xlsx');
    $writer->save("../../upload/excel_output_queue/" . $filename);
}
$arr['file'] = $filename;
$arr['list'] = $list;
$arr['success'] = $Success;
$arr['fail'] = $Fail;
$arr['result'] = $result;
$arr['msg'] = $msg;
echo json_encode($arr);
