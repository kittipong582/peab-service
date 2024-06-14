<?php
require("../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
date_default_timezone_set("Asia/Bangkok");
$current_datetime = date("Y-m-d H:i:s");
$starttime = microtime(true);
function clean($string)
{

    return preg_replace('/[^\p{L}\p{M}\p{Z}\p{N}\p{P}]/u', ' ', $string);
}

$date = date('d/m/Y');
$time = date('H:i');

$job_id = $_POST['job_id'];


$sql_chk = "SELECT receipt_no,team_number FROM tbl_job a 
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id 
LEFT JOIN tbl_branch c ON c.branch_id = b.branch_id 
WHERE a.job_id = '$job_id'";
$rs_chk = mysqli_query($connect_db, $sql_chk);
$row_chk = mysqli_fetch_assoc($rs_chk);

if ($row_chk['receipt_no'] == null) {

    

    $sql_chk_group = "SELECT COUNT(job_id) as num_job,group_pm_id FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
    $rs_chk_group = mysqli_query($connect_db, $sql_chk_group);
    $row_chk_group = mysqli_fetch_assoc($rs_chk_group);


    /////////////reciecve_no////////////////
    $year = $row_chk['team_number'] . "-" . substr(date("Y") + 543, 2) . date("m");
    $format =  $year;

    $sql1    = "SELECT (CASE WHEN (SELECT COUNT(receipt_no) AS count_this_month FROM tbl_job WHERE receipt_no LIKE '$format%') > 0 
                   THEN LPAD((MAX(substring(receipt_no, -3))+1),3,0) ELSE '001' END) AS NextCode 
            FROM tbl_job WHERE receipt_no LIKE '$format%'";
    $rs1     = mysqli_query($connect_db, $sql1);
    $row1 = mysqli_fetch_array($rs1);
    $reciecve_no = $format . $row1['NextCode'];


    if ($row_chk_group['num_job'] == 0) {



        $sql_update = "UPDATE tbl_job SET receipt_no = '$reciecve_no' ,receipt_datetime ='$current_datetime' WHERE job_id = '$job_id'";
        $rs_update =  mysqli_query($connect_db, $sql_update);

      

        if ($rs_update) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    } else {

        $sql_loop = "SELECT job_id FROM tbl_group_pm_detail WHERE group_pm_id = '{$row_chk_group['group_pm_id']}'";

        $rs_loop = mysqli_query($connect_db, $sql_loop);
        while ($row_loop = mysqli_fetch_assoc($rs_loop)) {

            $sql_update = "UPDATE tbl_job SET 
            receipt_no = '$reciecve_no' ,
            receipt_datetime ='$current_datetime' 
            WHERE job_id = '{$row_loop['job_id']}'";


            $rs_update =  mysqli_query($connect_db, $sql_update);
            // echo $sql_update;
        }



        if ($rs_update) {
            $arr['result'] = 1;
        } else {
            $arr['result'] = 0;
        }
    }
} else {
    $arr['result'] = 1;
}
mysqli_close($connect_db);
$arr['sql'] = $sql_update;
echo json_encode($arr);
