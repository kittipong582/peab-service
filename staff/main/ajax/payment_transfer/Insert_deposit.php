<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$create_user_id = $_SESSION['user_id'];

$y = date('Y') + 543;
$y = substr($y, 2);
$m = date('m');
$d = date('d');
$deposit_no = $y . $m . $d;
$nums = "SELECT deposit_no FROM tbl_bank_deposit WHERE deposit_no LIKE '$deposit_no%' ORDER BY deposit_no DESC LIMIT 1";
$qry = mysqli_query($connect_db, $nums) or die($connect_db->error);
$rows = mysqli_fetch_assoc($qry);
if ($qry->num_rows < 1) {
    $rows['deposit_no'] = 0;
}
$maxId = explode($deposit_no, $rows['deposit_no']);
$list_order = ($maxId[1] + 1);
$list_order = str_pad($list_order, 3, "0", STR_PAD_LEFT);
$deposit_no = $deposit_no . $list_order;



$deposit_id = getRandomID(10, 'tbl_bank_deposit', 'deposit_id');
$deposit_date = date("Y-m-d", strtotime($_POST['deposit_date']));
$deposit_hour = $_POST['deposit_hour'];
$deposit_min = $_POST['deposit_min'];
$account_id = $_POST['account_id'];
$note = $_POST['note'];
$total_amount = $_POST['total_amount'];
$fee = $_POST['fee'];

$sql_insert = "INSERT INTO tbl_bank_deposit
SET  deposit_id = '$deposit_id'
    , create_user_id = '$create_user_id'
    ,account_id = '$account_id'
    ,deposit_date = '$deposit_date'
    ,deposit_hour = '$deposit_hour'
    ,deposit_min = '$deposit_min'
    ,deposit_no = '$deposit_no'
    ,deposit_amount = '$total_amount'
    ,fee = '$fee'
    ,note = '$note'
";

$rs_insert = mysqli_query($connect_db, $sql_insert);

$i = 1;
foreach ($_POST['amount'] as $key => $value) {
    $temp_array_u[$i]['amount'] = $value;
    $i++;
}


$all_payment_id = $_POST['all_payment_id'];

$a = 1;
foreach (explode(",", $all_payment_id) as $payment_id) {



    $amount = $temp_array_u[$a]['amount'];


    $sql_detail = "INSERT INTO tbl_bank_deposit_detail
                SET  deposit_id = '$deposit_id'
                    , payment_id = '$payment_id'
                    ,deposit_amount = '$amount'
                ";

    $rs_detail = mysqli_query($connect_db, $sql_detail);
    $a++;
}


if ($_FILES['image1'] != "") {

    $tmpFilePath_1 = $_FILES['image1']['tmp_name'];

    $file_1  = explode(".", $_FILES['image1']['name']);

    $count1 = count($file_1) - 1;

    $file_surname_1 = $file_1[$count1];

    $filename_images_1 = md5(date('mds') . rand(111, 999) . date("hsid") . rand(111, 999)) . "." . $file_surname_1;

    if ($file_surname_1 == 'jpg' || $file_surname_1 == 'jpeg' || $file_surname_1 == 'gif' || $file_surname_1 == 'png' || $file_surname_1 == 'JPG' || $file_surname_1 == 'JPEG' || $file_surname_1 == 'GIF' || $file_surname_1 == 'PNG') {

        if (move_uploaded_file($_FILES['image1']['tmp_name'], "../../../../main/upload/payment_img/" . $filename_images_1)) {

            $sql1 = "UPDATE tbl_bank_deposit SET deposit_file = '$filename_images_1'
                WHERE deposit_id = '$deposit_id'
                ;";

            $rs1 = mysqli_query($connect_db, $sql1) or die($connect_db->error);
        }
    }
}


if ($rs_insert) {
    $arr['result'] = 1;
} else {
    $arr['result'] = 0;
}
// $arr['result'] = 1;
echo json_encode($arr);
