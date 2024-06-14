<?php

session_start();

include('../../../config/main_function.php');

$connection = connectDB("LM=VjfQ{6rsm&/h`");

$withdraw_date = $_POST['withdraw_date'];
$withdraw_date = str_replace('/', '-', $withdraw_date);

$branch_id = $_POST['branch_id'];
$ax_ref_no = $_POST['ax_ref_no'];
$import_id = mysqli_real_escape_string($connection, $_POST['import_id']);
$withdraw_date = date('Y-m-d', strtotime($withdraw_date));
$remark = mysqli_real_escape_string($connection, $_POST['remark']);
$create_user_id = $_SESSION['user_id'];
// set_time_limit(0);
/** PHPExcel */
require('../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */

require('../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

$order_list = 0;

$fileImport = $_FILES["uploadfile"]["tmp_name"];
$inputFileType = PHPExcel_IOFactory::identify($fileImport);
$objReader = PHPExcel_IOFactory::createReader($inputFileType);
$objReader->setReadDataOnly(true);
$objPHPExcel = $objReader->load($fileImport);
foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {

    $worksheets[$worksheet->getTitle()] = $worksheet->toArray();
}

$worksheets = array_shift($worksheets);
array_shift($worksheets);

$errorList = array();
$listOfInserted = array();

$sheet = $objPHPExcel->setActiveSheetIndex(0);


$year = date('y') + 43;
$month = date('m');
$job_ex = $year . $month;

$sql_conut = "SELECT count(*) as count1 FROM tbl_import_stock";
$rs_conut  = mysqli_query($connection, $sql_conut) or die($connection->error);
$row_conut = mysqli_fetch_assoc($rs_conut);
//  echo $sql_conut;

$count_no = $row_conut['count1'] + 1;
$import_no = "IM" . $year . $month . str_pad($count_no, 4, "0", STR_PAD_LEFT);


$sql = "INSERT INTO tbl_import_stock
SET   import_id = '$import_id'
    ,import_no = '$import_no'
    ,create_user_id  = '$create_user_id '
    ,ax_ref_no = '$ax_ref_no'
    ,ax_withdraw_date = '$withdraw_date'
    ,note = '$remark'
    ,receive_branch_id = '$branch_id' 
    ;";
$rs = mysqli_query($connection, $sql) or die($connection->error);



foreach ($worksheets as $key => $v) {

    $spare_part_code = $v[0];
    $quantity = $v[1];

    $sql_fine_spare = "SELECT spare_part_id FROM tbl_spare_part WHERE spare_part_code = '$spare_part_code'";
    $result_fine_spare = mysqli_query($connection, $sql_fine_spare);
    $rows_fine_spare = mysqli_fetch_assoc($result_fine_spare);
    $ax = $rows_fine_spare['spare_part_id'];

    $nums = "SELECT MAX(list_order) AS list_import_id FROM tbl_import_stock_detail 
    WHERE import_id = '$import_id'";
    $qry = mysqli_query($connection, $nums);
    $rows = mysqli_fetch_assoc($qry);
    if ($rows['list_import_id'] < 0) {
        $rows['list_import_id'] = 0;
    }
    // substr ตัดคำ
    $maxId = substr($rows['list_import_id'], 0);
    $maxId = ($maxId + 1);
    $nextId = $maxId;
    $list_order = $nextId;

    if ($ax != "") {

        $sql_detail = "INSERT INTO tbl_import_stock_detail
                SET  import_id = '$import_id'
                    ,spare_part_id = '$ax'
                    , quantity = '$quantity'
                    , list_order = '$list_order'
                ";

        $rs_detail = mysqli_query($connection, $sql_detail) or die($connection->error);
    }
}

if ($rs) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}

echo json_encode($arr);
