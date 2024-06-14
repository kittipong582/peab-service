<?php

session_start();

include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$thiscount_month = date('t');
$array_data = array();
for ($i = 1; $i <= $thiscount_month; $i++) {


    $sday =  date('Y') . "-" . date('m') . "-" . $i;
    $eday = date('Y') . "-" . date('m') . "-" . $i;



    $sql_total = "SELECT COUNT(group_pm_id) as total,group_date FROM tbl_group_pm a
    LEFT JOIN tbl_user g ON a.create_user_id = g.user_id
WHERE group_date = '$sday' ";
    $result_total  = mysqli_query($connect_db, $sql_total);
    $row_total = mysqli_fetch_array($result_total);

    /////งาน
    $sql = "SELECT COUNT(group_pm_id) as total_sum,group_date FROM tbl_group_pm a
    LEFT JOIN tbl_user g ON a.create_user_id = g.user_id
WHERE group_date = '$sday' and start_service_time is not null and finish_service_time is not null ";
    $result  = mysqli_query($connect_db, $sql);
    $row = mysqli_fetch_array($result);



    $temp3 = array(
        "date" => $sday,
        "total_sum" => ($row['total_sum'] == '') ? 0 : $row['total_sum'],
        "total_job" => ($row_total['total'] == '') ? 0 : $row_total['total']
    );

    array_push($array_data, $temp3);
}

echo json_encode($array_data);
