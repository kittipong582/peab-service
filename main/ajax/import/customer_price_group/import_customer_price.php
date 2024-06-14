<?php

session_start();

include('../../../../config/main_function.php');

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



// set_time_limit(0);
/** PHPExcel */
require('../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */

require('../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

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
$customer_group = $_POST['customer_group_id'];

foreach ($worksheets as $key => $v) {

    $customer_code = $v[0];


    $sql = "UPDATE tbl_customer
    SET customer_group = '$customer_group'
    WHERE customer_code = '$customer_code'
    ";
    if (mysqli_query($connect_db, $sql)) {
    } else {
        $arr['result'] = 0;
    }
}

if (mysqli_query($connect_db, $sql)) {
    $arr['result'] = 1;
}

echo json_encode($arr);
