<?php

session_start();

include ('../../../../config/main_function.php');

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];

// set_time_limit(0);
/** PHPExcel */
require ('../../../PHPExcel-1.8/Classes/PHPExcel.php');
// /** PHPExcel_IOFactory - Reader */

require ('../../../PHPExcel-1.8/Classes/PHPExcel/IOFactory.php');

$order_list = 0;

$filename = $_FILES["uploadfile"]["name"];
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

    $customer_group_id = $v[0];
    $spare_part_id = $v[1];
    $unit_price = $v[4];

    if ($customer_group_id != "") {
        if (isset($unit_price)) {

            $sql3 = "UPDATE tbl_customer_group_part_price
    SET unit_price = '$unit_price'
   WHERE customer_group_id = '$customer_group_id' AND spare_part_id = '$spare_part_id'
    ";

            $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);
            // echo $sql3;
        }
    } else {

        $sql_chk = "SELECT COUNT(spare_part_id) AS num_chk FROM tbl_customer_group_part_price WHERE spare_part_id = '$spare_part_id' AND customer_group_id = '$customer_group'";
        $result_chk = mysqli_query($connect_db, $sql_chk);
        $row_chk = mysqli_fetch_array($result_chk);
        // echo $sql_chk;
        if ($row_chk['num_chk'] == 1) {
            // echo "test1";

            if (isset($unit_price)) {
                $sql3 = "UPDATE tbl_customer_group_part_price
            SET unit_price = '$unit_price'
           WHERE customer_group_id = '$customer_group' AND spare_part_id = '$spare_part_id'
            ";

                $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);
                // echo $sql3;
            }
        } else {
            if (isset($unit_price)) {
                // echo "test2";
                $sql3 = "INSERT INTO tbl_customer_group_part_price
            SET unit_price = '$unit_price'
           , customer_group_id = '$customer_group'
           ,spare_part_id = '$spare_part_id'
            ";

                $rs3 = mysqli_query($connect_db, $sql3) or die($connect_db->error);
            }
        }
    }

    if ($rs3) {
    } else {
        $arr['result'] = 0;
    }
   

    $sql_log = "INSERT INTO tbl_customer_group_part_price_log SET 
    create_user_id = '$user_id',
    customer_group_id = '$customer_group',
    spare_part_id = '$spare_part_id',
    spare_part_price = '$unit_price',
    log_type = '1'";
    $res_log = mysqli_query($connect_db, $sql_log) or die($connect_db->error);
}

if ($rs3) {
    $arr['result'] = 1;
}









echo json_encode($arr);
