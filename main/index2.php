<?php

echo date("Y-m-d H:i");
session_start();

include("header.php");
$secure = "LM=VjfQ{6rsm&/h`";

$connection = connectDB($secure);
$today = date("Y-m-d");
$thismonth = date("m");
$thisyear = date("Y");


//////////////////////////////งานทั้งหมดปีนี้
//////////////////งานทั่วไป//////////
$sql_job = "SELECT sum(case when job_type = '1' then 1 else 0 end) AS CM_total
,sum(case when job_type = '3' then 1 else 0 end) AS IN_total
,sum(case when job_type = '4' then 1 else 0 end) AS OH_total
,sum(case when job_type = '5' then 1 else 0 end) AS OTH_total
,sum(case when job_type = '6' then 1 else 0 end) AS QT_total
FROM tbl_job WHERE Year(appointment_date) = '$thisyear' AND job_id NOT in(select job_id from tbl_group_pm_detail)";
$result_job  = mysqli_query($connection, $sql_job);
$row_job = mysqli_fetch_array($result_job);

/////////////////pmgroup////////////////////
$sql_group = "SELECT COUNT(group_pm_id) as groupnum FROM tbl_group_pm 
WHERE Year(group_date) = '$thisyear'";
$result_group  = mysqli_query($connection, $sql_group);
$row_group = mysqli_fetch_array($result_group);


/////////รายได้รายปี////////
$sql_income = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE YEAR(b.appointment_date) = '$thisyear'";
$result_income  = mysqli_query($connection, $sql_income);
$row_income = mysqli_fetch_array($result_income);


$sql_spare = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE YEAR(b.appointment_date) = '$thisyear'";
$result_spare  = mysqli_query($connection, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);


/////////รายได้รายเดือน////////
//////////////////////////////CM
$sql_job_cm = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE Year(appointment_date) = '$thisyear' AND MONTH(appointment_date) = '$thismonth'AND job_type = 1";
$result_job_cm  = mysqli_query($connection, $sql_job_cm);
$row_job_cm = mysqli_fetch_array($result_job_cm);

$sql_income_cm = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth'AND b.job_type = 1";
$result_income_cm  = mysqli_query($connection, $sql_income_cm);
$row_income_cm = mysqli_fetch_array($result_income_cm);

$sql_spare_cm = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth' AND b.job_type = 1";
$result_spare_cm  = mysqli_query($connection, $sql_spare_cm);
$row_spare_cm = mysqli_fetch_array($result_spare_cm);


////////////////////////////PM
$sql_job_pm = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE Year(appointment_date) = '$thisyear' AND MONTH(appointment_date) = '$thismonth'AND job_type = 2 AND job_id NOT in(select job_id from tbl_group_pm_detail)";
$result_job_pm  = mysqli_query($connection, $sql_job_pm);
$row_job_pm = mysqli_fetch_array($result_job_pm);

/////////////////pmgroup////////////////////
$sql_group_pm = "SELECT COUNT(group_pm_id) as groupnum FROM tbl_group_pm 
WHERE Year(group_date) = '$thisyear' AND MONTH(group_date) = '$thismonth'";
$result_group_pm  = mysqli_query($connection, $sql_group_pm);
$row_group_pm = mysqli_fetch_array($result_group_pm);


$sql_income_pm = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth'AND b.job_type = 2";
$result_income_pm  = mysqli_query($connection, $sql_income_pm);
$row_income_pm = mysqli_fetch_array($result_income_pm);

$sql_spare_pm = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth' AND b.job_type = 2";
$result_spare_pm  = mysqli_query($connection, $sql_spare_pm);
$row_spare_pm = mysqli_fetch_array($result_spare_pm);



//////////////////////////////IN
$sql_job_in = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE Year(appointment_date) = '$thisyear' AND MONTH(appointment_date) = '$thismonth'AND job_type = 3";
$result_job_in  = mysqli_query($connection, $sql_job_in);
$row_job_in = mysqli_fetch_array($result_job_in);

$sql_income_in = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth'AND b.job_type = 3";
$result_income_in  = mysqli_query($connection, $sql_income_in);
$row_income_in = mysqli_fetch_array($result_income_in);


$sql_spare_in = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth' AND b.job_type = 3";
$result_spare_in  = mysqli_query($connection, $sql_spare_in);
$row_spare_in = mysqli_fetch_array($result_spare_in);



//////////////////////////////OH
$sql_job_oh = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE Year(appointment_date) = '$thisyear' AND MONTH(appointment_date) = '$thismonth'AND job_type = 4";
$result_job_oh  = mysqli_query($connection, $sql_job_oh);
$row_job_oh = mysqli_fetch_array($result_job_oh);

$sql_income_oh = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth'AND b.job_type = 4";
$result_income_oh  = mysqli_query($connection, $sql_income_oh);
$row_income_oh = mysqli_fetch_array($result_income_oh);

$sql_spare_oh = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE MONTH(b.appointment_date) = '$thismonth' AND b.job_type = 4";
$result_spare_oh  = mysqli_query($connection, $sql_spare_oh);
$row_spare_oh = mysqli_fetch_array($result_spare_oh);
/////////////////////////////////////////////////



/////////รายได้รายวัน////////
//////////////////////////////CM
$sql_job_cm2 = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE appointment_date = '$today'AND job_type = 1";
$result_job_cm2  = mysqli_query($connection, $sql_job_cm2);
$row_job_cm2 = mysqli_fetch_array($result_job_cm2);


$sql_income_cm2 = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 1";
$result_income_cm2  = mysqli_query($connection, $sql_income_cm2);
$row_income_cm2 = mysqli_fetch_array($result_income_cm2);


$sql_spare_cm2 = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 1";
$result_spare_cm2  = mysqli_query($connection, $sql_spare_cm2);
$row_spare_cm2 = mysqli_fetch_array($result_spare_cm2);


//////////////////////////////PM
$sql_job_pm2 = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE appointment_date = '$today' AND job_type = 2 AND job_id NOT in(select job_id from tbl_group_pm_detail)";
$result_job_pm2  = mysqli_query($connection, $sql_job_pm2);
$row_job_pm2 = mysqli_fetch_array($result_job_pm2);

/////////////////pmgroup////////////////////
$sql_group_pm2 = "SELECT COUNT(group_pm_id) as groupnum FROM tbl_group_pm 
WHERE group_date = '$today'";
$result_group_pm2  = mysqli_query($connection, $sql_group_pm2);
$row_group_pm2 = mysqli_fetch_array($result_group_pm2);


$sql_income_pm2 = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today'AND b.job_type = 2";
$result_income_pm2  = mysqli_query($connection, $sql_income_pm2);
$row_income_pm2 = mysqli_fetch_array($result_income_pm2);


$sql_spare_pm2 = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 2";
$result_spare_pm2  = mysqli_query($connection, $sql_spare_pm2);
$row_spare_pm2 = mysqli_fetch_array($result_spare_pm2);

//////////////////////////////IN
$sql_job_in2 = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE appointment_date = '$today' AND job_type = 3";
$result_job_in2 = mysqli_query($connection, $sql_job_in2);
$row_job_in2 = mysqli_fetch_array($result_job_in2);

$sql_income_in2 = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 3";
$result_income_in2  = mysqli_query($connection, $sql_income_in2);
$row_income_in2 = mysqli_fetch_array($result_income_in2);


$sql_spare_in2 = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 3";
$result_spare_in2  = mysqli_query($connection, $sql_spare_in2);
$row_spare_in2 = mysqli_fetch_array($result_spare_in2);

//////////////////////////////OH
$sql_job_oh2 = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE appointment_date = '$today' AND job_type = 4";
$result_job_oh2  = mysqli_query($connection, $sql_job_oh2);
$row_job_oh2 = mysqli_fetch_array($result_job_oh2);

$sql_income_oh2 = "SELECT SUM(a.income_amount*a.quantity) as total_income FROM tbl_job_income a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 4";
$result_income_oh2  = mysqli_query($connection, $sql_income_oh2);
$row_income_oh2 = mysqli_fetch_array($result_income_oh2);


$sql_spare_oh2 = "SELECT SUM(a.unit_price) as total_spare FROM tbl_job_spare_used a 
LEFT JOIN  tbl_job b ON a.job_id = b.job_id 
WHERE appointment_date = '$today' AND b.job_type = 4";
$result_spare_oh2  = mysqli_query($connection, $sql_spare_oh2);
$row_spare_oh2 = mysqli_fetch_array($result_spare_oh2);
/////////////////////////////////////////////////


//////////////////////////////ข้อมูลช่าง
$sql_user = "SELECT fullname,username FROM tbl_user WHERE active_status = 1 LIMIT 5";
$result_user  = mysqli_query($connection, $sql_user);


$all_job = $row_job['numjob'] + $row_group['groupnum']; ////////////////งานทั้งหมด


$sla_data = array(); ///////////////ลิสSLA
$hold_list = array(); ///////////////ลิสงานค้าง
///////////////////สาขา////////////
$sql_team = "SELECT branch_id,branch_name,team_number FROM tbl_branch WHERE active_status = 1 ";
$result_team  = mysqli_query($connection, $sql_team);
while ($row_team = mysqli_fetch_array($result_team)) {

    $branch_id = $row_team['branch_id'];
    $allsla_job = 0;
    ///////////////////////////////////////////งานค้าง//////////////////////////
    $sql_hold_job = "SELECT COUNT(job_id) as job_num FROM tbl_job
    WHERE job_type = 1 and start_service_time is not null and finish_service_time is null AND care_branch_id = '$branch_id'";
    $rs_hold_job = mysqli_query($connection, $sql_hold_job);
    while ($row_hold_job = mysqli_fetch_array($rs_hold_job)) {

        if ($row_hold_job['job_num'] != 0) {
            $temp1 = array(
                "team" => $row_team['team_number'] . " - " . $row_team['branch_name'],
                "count_job" => $row_hold_job['job_num'],
            );
            array_push($hold_list, $temp1);
        }
    }
    //////////////////////////////////////////////////////////////////////////

    /////////////////////////////////////////////SLA////////////////////////and timediff(finish_service_time,create_group_datetime) > TIME('48:00:00')
    //////////////////งานทั่วไป//////////
    $sql_job1 = "SELECT COUNT(job_id) AS numjob FROM tbl_job WHERE care_branch_id = '$branch_id' and job_id NOT in(select job_id from tbl_group_pm_detail)";
    $result_job1  = mysqli_query($connection, $sql_job1);
    $row_job1 = mysqli_fetch_array($result_job1);

    /////////////////pmgroup////////////////////
    $sql_group1 = "SELECT COUNT(group_pm_id) as groupnum FROM tbl_group_pm a
    LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
    WHERE  b.branch_id = '$branch_id'";
    $result_group1  = mysqli_query($connection, $sql_group1);
    $row_group1 = mysqli_fetch_array($result_group1);

    $all_job1 = $row_job1['numjob'] + $row_group1['groupnum']; ////////////////งานทั้งหมด

    //////////////////slaงานทั่วไป//////////
    $sql_slajob = "SELECT COUNT(job_id) AS numjob FROM tbl_job 
    WHERE start_service_time is not null AND finish_service_time is not null AND care_branch_id = '$branch_id' and job_id NOT in(select job_id from tbl_group_pm_detail) and timediff(finish_service_time,create_datetime) < TIME('48:00:00')";
    $result_slajob  = mysqli_query($connection, $sql_slajob);
    $row_slajob = mysqli_fetch_array($result_slajob);

    /////////////////slapmgroup////////////////////
    $sql_slagroup = "SELECT COUNT(group_pm_id) as groupnum FROM tbl_group_pm a
    LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
    WHERE start_service_time is not null AND finish_service_time is not null AND b.branch_id = '$branch_id' and timediff(finish_service_time,create_group_datetime) < TIME('48:00:00')";
    $result_slagroup  = mysqli_query($connection, $sql_slagroup);
    $row_slagroup = mysqli_fetch_array($result_slagroup);

    $allsla_job = $row_slajob['numjob'] + $row_slagroup['groupnum'];

    $percent = $allsla_job != 0 ? ($allsla_job / $all_job1) * 100 : 0;
    $temp = array(
        "team" => $row_team['team_number'] . " - " . $row_team['branch_name'],
        "percent" => $percent
    );
    // 
    array_push($sla_data, $temp);
    ////////////////////////////////////////////////////////////////////////////////////
    // echo $allsla_job;
    // echo " + ทั้งหมด  ";
    // echo $all_job1;
    // echo "<br/>";
}
// array_multisort($sla_data, SORT_DESC, $sla_data['percent']);
// sort(array_column($sla_data, 'percent'));

$sla_array = array();
foreach ($sla_data as $key => $row) {
    $sla_array[$key] = $row['percent'];
}
array_multisort($sla_array, SORT_ASC, $sla_data);
?>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3 class="font-bold"> รายปี </h3>
            </div>

            <div class="ibox-content ">
                <div class="row">
                    <div class="col-2 mb-2">
                        <h4>งาน CM: <?php echo number_format($row_job['CM_total']); ?></h4>
                    </div>
                    <div class="col-2 mb-2">
                        <h4>งาน PM: <?php echo number_format($row_group['groupnum']); ?></h4>
                    </div>
                    <div class="col-2 mb-2">
                        <h4>งาน Installation: <?php echo number_format($row_job['IN_total']); ?></h4>
                    </div>
                    <div class="col-2 mb-2">
                        <h4>งาน Overhual: <?php echo number_format($row_job['OH_total']); ?></h4>
                    </div>
                    <div class="col-2 mb-2">
                        <h4>งานอื่นๆ: <?php echo number_format($row_job['OTH_total']); ?></h4>
                    </div>
                    <div class="col-2 mb-2">
                        <h4>งานเสนอราคา: <?php echo number_format($row_job['QT_total']); ?></h4>
                    </div>

                    <div class="col-6 mb-2">
                        <hr>
                        <h4>รายได้รวม : <?php echo number_format($row_income['total_income'] + $row_spare['total_spare'], 2) ?></h4>
                    </div>
                    <div class="col-6 mb-2">
                        <hr>
                        <h4>รายได้ค่าอะไหล่ : <?php echo number_format($row_spare['total_spare'], 2) ?></h4>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-12">
        <div class="ibox">
            <div class="ibox-title">
                <div class="row">
                    <div class="col-6">
                        <h3 class="font-bold"> รายเดือน </h3>
                    </div>

                    <div class="col-6">
                        <h3 class="font-bold"> รายวัน </h3>
                    </div>
                </div>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="col-6">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>งาน</th>
                                        <th>จำนวนงาน </th>
                                        <th>รายได้ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CM</td>
                                        <td><?php echo $row_job_cm['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_cm['total_income'] + $row_spare_cm['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>PM</td>
                                        <td><?php echo $row_job_pm['numjob'] + $row_group_pm['groupnum'] ?></td>
                                        <td><?php echo number_format(($row_income_pm['total_income'] + $row_spare_pm['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>ติดตั้ง</td>
                                        <td><?php echo $row_job_in['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_in['total_income'] + $row_spare_in['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>OH</td>
                                        <td><?php echo $row_job_oh['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_oh['total_income'] + $row_spare_oh['total_spare']), 2) ?></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="col-6">

                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover">
                                <thead>
                                    <tr>

                                        <th>งาน</th>
                                        <th>จำนวนงาน </th>
                                        <th>รายได้ </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>CM</td>
                                        <td><?php echo $row_job_cm2['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_cm2['total_income'] + $row_spare_cm2['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>PM</td>
                                        <td><?php echo $row_job_pm2['numjob'] + $row_group_pm2['groupnum'] ?></td>
                                        <td><?php echo number_format(($row_income_pm2['total_income'] + $row_spare_pm2['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>ติดตั้ง</td>
                                        <td><?php echo $row_job_in2['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_in2['total_income'] + $row_spare_in2['total_spare']), 2) ?></td>

                                    </tr>
                                    <tr>
                                        <td>OH</td>
                                        <td><?php echo $row_job_oh2['numjob'] ?></td>
                                        <td><?php echo number_format(($row_income_oh2['total_income'] + $row_spare_oh2['total_spare']), 2) ?></td>

                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-6">
        <div class="ibox">
            <div class="ibox-title">
                <h3 class="font-bold">งาน CM ค้าง</h3>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table_job_hold">
                            <thead>
                                <tr>

                                    <th>สาขา</th>
                                    <th>จำนวนงานค้าง </th>

                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($hold_list as $row_backlog) { ?>
                                    <tr>
                                        <td><?php echo $row_backlog['team']; ?></td>
                                        <td><?php echo $row_backlog['count_job'] ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <div class="col-6">
        <div class="ibox">
            <div class="ibox-title">
                <h3 class="font-bold">SLA(%)</h3>
            </div>
            <div class="ibox-content">
                <div class="row">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover" id="table_job_sla">
                            <thead>
                                <tr>
                                    <th>สาขา</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($sla_data as $row_sla) {
                                    if ($row_sla['percent'] > 0) { ?>
                                        <tr>
                                            <td><?php echo $row_sla['team'] ?></td>
                                            <td><?php echo number_format($row_sla['percent'], 2) . ' %' ?></td>
                                        </tr>
                                <?php }
                                } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3 class="font-bold">กราฟ แสดง PM planVs actual รายวัน</h3>
            </div>
            <div class="ibox-content">

                <div id="chart-container">
                    <canvas id="barChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12">
        <div class="ibox">
            <div class="ibox-title">
                <h3 class="font-bold">กราฟ แสดง PM planVs actual รายเดือน</h3>
            </div>
            <div class="ibox-content">

                <div id="chart-container2">
                    <canvas id="barChart2"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<?php include('import_script.php'); ?>

<script>
    $('.chosen-select').chosen({
        no_results_text: "Oops, nothing found!",
        width: "100%"
    });

    $(".select2").select2({});

    $(document).ready(function() {
        $('#table_job_hold').DataTable({
            scrollY: '150px',
            scrollCollapse: true,
            paging: false,
            searching: false,
        });

        $('#table_job_sla').DataTable({
            scrollY: '150px',
            scrollCollapse: true,
            paging: false,
            searching: false,
            "ordering": false
        });

        load_graph1();
        load_graph2();
    });


    function load_graph1() {

        $.post('ajax/index/get_Graph1.php', {

            },
            function(array_data) {

                var data_result = JSON.parse(array_data);

                var date = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['date'];
                    date.push(data);
                }
                var job_pass = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_sum'];
                    job_pass.push(data);
                }

                var total_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    total_job.push(data);
                }

                var barData = {
                    labels: date,
                    datasets: [{
                            label: "จำนวนที่ทำ",
                            backgroundColor: 'rgba(26,179,148,0.5)',
                            borderColor: "rgba(26,179,148,0.5)",
                            pointBackgroundColor: "rgba(26,179,148,0.5)",
                            pointBorderColor: "#fff",
                            data: job_pass
                        },

                        {
                            label: "จำนวนทั้งหมด",
                            backgroundColor: 'rgba(220,220,220,0.5)',
                            borderColor: "rgba(220,220,220,1)",
                            pointBackgroundColor: "rgba(220,220,220,1)",
                            pointBorderColor: "#fff",
                            data: total_job
                        }
                    ],
                };

                var barOptions = {
                    responsive: true,
                };
                $('#barChart').remove();
                $('#chart-container').append('<canvas id="barChart"><canvas>');
                var ctx2 = document.getElementById("barChart").getContext("2d");
                new Chart(ctx2, {
                    type: 'line',
                    data: barData,
                    options: barOptions

                });
            });
    }


    function load_graph2() {

        $.post('ajax/index/get_Graph2.php', {

            },
            function(array_data) {

                var data_result = JSON.parse(array_data);

                var date = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['date'];
                    date.push(data);
                }

                var job_pass = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_sum'];
                    job_pass.push(data);
                }

                var total_job = [];
                for (var i = 0; i < data_result.length; i++) {
                    var data = data_result[i]['total_job'];
                    total_job.push(data);
                }

                var barData = {

                    labels: date,
                    datasets: [{
                            label: "จำนวนที่ทำ",
                            backgroundColor: 'rgba(26,179,148,0.5)',
                            borderColor: "rgba(26,179,148,0.5)",
                            pointBackgroundColor: "rgba(26,179,148,0.5)",
                            pointBorderColor: "#fff",
                            data: job_pass
                        },

                        {
                            label: "จำนวนทั้งหมด",
                            backgroundColor: 'rgba(220,220,220,0.5)',
                            borderColor: "rgba(220,220,220,1)",
                            pointBackgroundColor: "rgba(220,220,220,1)",
                            pointBorderColor: "#fff",
                            data: total_job
                        }
                    ],

                };

                var barOptions = {
                    responsive: true,
                };
                $('#barChart2').remove();
                $('#chart-container2').append('<canvas id="barChart2"><canvas>');
                var ctx3 = document.getElementById("barChart2").getContext("2d");
                new Chart(ctx3, {
                    type: 'line',
                    data: barData,
                    options: barOptions

                });
            });
    }
</script>

</body>

</html>