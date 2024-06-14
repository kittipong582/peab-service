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

            for ($row = 3; $row <= $lastRow; $row++) {
                ++$i;
                $list[$i]["lot_no"] = trim((string) $worksheet->getCell('H' . $row)->getValue());
                $list[$i]["model_code"] = trim((string) $worksheet->getCell('F' . $row)->getValue());
                $list[$i]["ref_number"] = trim((string) $worksheet->getCell('E' . $row)->getValue());
                $list[$i]["quantity"] = trim((string) $worksheet->getCell('K' . $row)->getValue());
                $list[$i]["import_quantity"] = trim((string) $worksheet->getCell('K' . $row)->getValue());
                $list[$i]["remain_quantity"] = trim((string) $worksheet->getCell('K' . $row)->getValue());
                $list[$i]["error"] = "";
            }
            // var_dump($list);

            foreach ($list as $x => $row) {
                $temp_error = "";
                $lot_no = $row["lot_no"];
                $model_code = $row["model_code"];
                $ref_number = $row["ref_number"];
                $quantity = $row["quantity"];
                $import_quantity = $row["import_quantity"];
                $remain_quantity = $row["remain_quantity"];

                if ($lot_no == "" || $model_code == "" || $ref_number == "" || $quantity == "" || $import_quantity == "" || $remain_quantity == "") {
                    $check_blank = false;
                    $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Blank Reqired Column";
                } else {
                    $check_blank = true;
                }

                // if ($model_code != "") {
                //     $sql_model = "SELECT p.model_code
                //     FROM tbl_product_waiting p
                //     WHERE p.model_code = '$model_code';";
                //     $rs_model = mysqli_query($connection, $sql_model);
                //     $cmt_model = mysqli_num_rows($rs_model);
                //     $row_model = mysqli_fetch_array($rs_model);
                //     if ($cmt_model == 0 && $row_model["model_code"] == "") {
                //         $check_model = true;
                //     } else {
                //         $check_model = false;
                //         $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Duplicate ref No";
                //     }
                // }




                if (preg_match('/^\d+(\.\d+)?$/', $quantity)) {
                    $check_q = true;
                } else {
                    $check_q = false;
                    $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Incorrect Data Format";
                }
                if (preg_match('/^\d+(\.\d+)?$/', $import_quantity)) {
                    $check_ipq = true;
                } else {
                    $check_ipq = false;
                    $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Incorrect Data Format";
                }
                if (preg_match('/^\d+(\.\d+)?$/', $remain_quantity)) {
                    $check_rmq = true;
                } else {
                    $check_rmq = false;
                    $temp_error = $temp_error . ($temp_error != "" ? " | " : "") . "Incorrect Data Format";
                }

                if ($check_blank == true && $check_q == true && $check_ipq == true && $check_rmq == true) {

                    $lot_id = getRandomID2(10, "tbl_product_waiting", "lot_id");

                    $sql_insert = "INSERT INTO tbl_product_waiting SET 
                        lot_id = '$lot_id',
                        lot_no = '$lot_no',
                        create_user_id = '$create_user_id', 
                        model_code = '$model_code',
                        ref_number = '$ref_number',
                        quantity = '$quantity',
                        import_quantity = '$import_quantity',
                        remain_quantity	 = '$remain_quantity'";
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
        "Customer Order No.",
        "รหัสสินค้า",
        "ล๊อต",
        "จำนวนรวม",
        "import_quantity",
        "remain_quantity",
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
       
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[0] . $rowCell, ($import["ref_number"] != "" ? $import["ref_number"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[1] . $rowCell, ($import["model_code"] != "" ? $import["model_code"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[2] . $rowCell, ($import["ref_number"] != "" ? $import["ref_number"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[3] . $rowCell, ($import["quantity"] != "" ? $import["quantity"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[4] . $rowCell, ($import["import_quantity"] != "" ? $import["import_quantity"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[5] . $rowCell, ($import["remain_quantity"] != "" ? $import["remain_quantity"] : ""));
        $excelSheet->getActiveSheet()->setCellValue($columnCharacter[6] . $rowCell, ($import["error"] != "" ? $import["error"] : ""));
        $rowCell ++;
    }

    $filename = "Form Import Product Qc Error (" . date("Y-m-d His") . ")" . ".xlsx";
    $writer = new Xlsx($excelSheet);
    $writer = IOFactory::createWriter($excelSheet, 'Xlsx');
    $writer->save("../../upload/excel_output/" . $filename);
}
$arr['file'] = $filename;
$arr['list'] = $list;
$arr['success'] = $Success;
$arr['fail'] = $Fail;
$arr['result'] = $result;
$arr['msg'] = $msg;
echo json_encode($arr);
