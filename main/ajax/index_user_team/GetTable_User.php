<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$team_branch2 = $_POST['team_branch2'];
$team_month2 = $_POST['team_month2'];
$thaimonth = array("00" => "", "01" => "มกราคม", "02" => "กุมภาพันธ์", "03" => "มีนาคม", "04" => "เมษายน", "05" => "พฤษภาคม", "06" => "มิถุนายน", "07" => "กรกฎาคม", "08" => "สิงหาคม", "09" => "กันยายน", "10" => "ตุลาคม", "11" => "พฤศจิกายน", "12" => "ธันวาคม");
$engmonth = array("00" => "", "01" => "January", "02" => "February", "03" => "March", "04" => "April", "05" => "May", "06" => "June", "07" => "July", "08" => "August", "09" => "September", "10" => "October", "11" => "November", "12" => "December");
$thismonth = date('m');
$thisyear = date('Y');

$condition_team = "";
if ($team_branch2 != "") {
    $condition_team = "and branch_id = '$team_branch2'";
}

$condition_month = "";
if ($team_month2 != "") {
    $condition_month = "AND  MONTH(b.appointment_date) = '$team_month2' and YEAR(b.appointment_date) = '$thisyear'";
    $condition_month1 = "AND  MONTH(appointment_date) = '$team_month2' and YEAR(appointment_date) = '$thisyear'";
    $condition_month2 = "AND  MONTH(group_date) = '$team_month2' and YEAR(group_date)= '$thisyear'";
}


$data_list = array();
$sql_user = "SELECT username,fullname,user_id,branch_id FROM tbl_user WHERE active_status = 1  AND admin_status != 9 $condition_team ORDER BY username";
$rs_user = mysqli_query($connect_db, $sql_user);
while ($row_user = mysqli_fetch_assoc($rs_user)) {

    $sql_team = "SELECT team_number FROM tbl_branch WHERE branch_id = '{$row_user['branch_id']}' and active_status = 1";
    $rs_team = mysqli_query($connect_db, $sql_team);
    $row_team = mysqli_fetch_assoc($rs_team);


    /////////รายได้รายปี////////
    $sql_income = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
        LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
        WHERE b.responsible_user_id = '{$row_user['user_id']}' $condition_month";
    $result_income  = mysqli_query($connect_db, $sql_income);
    $row_income = mysqli_fetch_array($result_income);


    $sql_spare = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
        LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
        WHERE b.responsible_user_id = '{$row_user['user_id']}' $condition_month";
    $result_spare  = mysqli_query($connect_db, $sql_spare);
    $row_spare = mysqli_fetch_array($result_spare);

    $sql_sum = "SELECT SUM(CASE WHEN job_type = '1' THEN 1 ELSE 0 END) AS SUM_CM, SUM(CASE WHEN job_type = '3' THEN 1 ELSE 0 END) AS SUM_IN, SUM(CASE WHEN job_type = '4' THEN 1 ELSE 0 END) AS SUM_OH 
    FROM tbl_job 
    WHERE responsible_user_id = '{$row_user['user_id']}' AND job_id NOT in(select job_id from  tbl_group_pm_detail) $condition_month1";
    $rs_sum = mysqli_query($connect_db, $sql_sum);
    $row_sum = mysqli_fetch_assoc($rs_sum);


    $sql_sum_pm = "SELECT COUNT(group_pm_id) AS SUM_PM FROM tbl_group_pm 
    WHERE responsible_user_id = '{$row_user['user_id']}' $condition_month2";
    $rs_sum_pm = mysqli_query($connect_db, $sql_sum_pm);
    $row_sum_pm = mysqli_fetch_assoc($rs_sum_pm);

    $temp = array(
        "team_number" => $row_user['username'],
        "team" =>  $row_user['fullname'],
        "branch" => $row_team['team_number'],
        "CM" => $row_sum['SUM_CM'],
        "PM" => $row_sum_pm['SUM_PM'],
        "IN" => $row_sum['SUM_IN'],
        "OH" => $row_sum['SUM_OH'],
        "JOB" => $row_sum['SUM_CM'] + $row_sum_pm['SUM_PM'] + $row_sum['SUM_IN'] + $row_sum['SUM_OH'],
        "total_income" => $row_spare['total_spare'] + $row_income['total_income']
    );
    array_push($data_list, $temp);
}




?>



<div style="overflow-y:scroll;height: 250px;">
    <table class="table table-striped table-bordered table-hover" id="table_user">
        <thead>
            <tr>
                <th style="width:6%;" class="text-center">รหัส</th>
                <th style="width:15%;" class="text-center">ชื่อ</th>
                <th style="width:15%;" class="text-left">คลัง</th>
                <th style="width:10%;" class="text-center">CM</th>
                <th style="width:10%;" class="text-center">PM</th>
                <th style="width:10%;" class="text-center">ติดตั้ง</th>
                <th style="width:10%;" class="text-center">OH</th>
                <th style="width:10%;" class="text-center">รวม</th>
                <th style="width:15%;" class="text-center">รายได้</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($data_list as $row) {

            ?>
                <tr>

                    <td class="text-left"><?php echo $row['team_number']; ?></td>
                    <td class="text-center"><?php echo $row['team']; ?></td>
                    <td class="text-center"><?php echo $row['branch']; ?></td>
                    <td class="text-center"><?php echo ($row['CM'] == "") ? 0 :  number_format($row['CM']); ?></td>
                    <td class="text-center"><?php echo ($row['PM'] == "") ? 0 :  number_format($row['PM']); ?></td>
                    <td class="text-center"><?php echo ($row['IN'] == "") ? 0 :  number_format($row['IN']); ?></td>
                    <td class="text-center"><?php echo ($row['OH'] == "") ? 0 :  number_format($row['OH']); ?></td>
                    <td class="text-center"><?php echo ($row['JOB'] == "") ? 0 :  number_format($row['JOB']); ?></td>
                    <td class="text-center"><?php echo ($row['total_income'] == "") ? 0 : number_format($row['total_income']); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>