<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$start_date = strtotime($_POST['start_date']);
$end_date = strtotime($_POST['end_date']);

$datediff =  $end_date - $start_date;

$days_remain = round($datediff / (60 * 60 * 24));
if ($days_remain <= 0) {
    $text = "เกิน " . $days_remain . " วัน";
} else {

    $text = "ระยะห่าง " . $days_remain . " วัน";
}

if (!empty($end_date) && !empty($start_date)) {
    $arr['text'] = "<div class='col-12'><label></label></div><div class='col-12'><label>$text</label></div>";
}else{
    $arr['text'] = "";
}
echo json_encode($arr);
