<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];
// $job_id = $_POST['job_id'];
$job_list = array();

$sql = "SELECT * FROM tbl_job WHERE product_id = '$product_id' AND job_id NOT in(select job_id from  tbl_group_pm_detail) ORDER BY create_datetime ASC";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

while ($row = mysqli_fetch_assoc($rs)) {

    $i++;
    $job_id = $row['job_id'];
    $customer_branch_id = $row['customer_branch_id'];
    $branch_id = $row['care_branch_id'];
    $responsible_user_id = $row['responsible_user_id'];

    $sql_fixed = "SELECT *,b.type_name AS sym_name,c.type_name AS rea_name FROM tbl_fixed a
    LEFT JOIN tbl_symptom_type b ON a.symptom_type_id = b.symptom_type_id
    LEFT JOIN tbl_reason_type c ON a.reason_type_id = c.reason_type_id
     WHERE a.job_id = '$job_id'";
    $rs_fixed = mysqli_query($connect_db, $sql_fixed) or die($connect_db->error);
    $row_fixed = mysqli_fetch_assoc($rs_fixed);


    $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
    $rs_team = mysqli_query($connect_db, $sql_team) or die($connect_db->error);
    $row_team = mysqli_fetch_assoc($rs_team);

    $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
    $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
    $row_user = mysqli_fetch_assoc($rs_user);

    if ($row['job_type'] == 1) {
        $job_type = "CM";
    } elseif ($row['job_type'] == 2) {
        $job_type = "PM";
    } else if ($row['job_type'] == 3) {
        $job_type = "INSTALLATION";
    } else if ($row['job_type'] == 5) {
        $job_type = "งานอื่นๆ" . "</br>" . $row['sub_type_name'];
    } else if ($row['job_type'] == 4) {
        $job_type = 'OVERHAUL';
    } else if ($row['job_type'] == 6) {
        $job_type = 'เสนอราคา';
    }
    $contact = $row['contact_name'] . "</br>" .
        "ตำแหน่ง : " . $row['contact_position'] . "</br>" .
        "เบอร์ : " . $row['contact_phone'] . "</br>";
    $team = "ทีม : " . $row_team['branch_name'] . "</br>" . "ช่างผู้ดูแล : " . $row_user['fullname'];
    if ($row['start_service_time'] != null) {
        $start_time = "เริ่ม: " . date("d-m-Y H:i", strtotime($row['start_service_time'])) . "</br>";
    } else {
        if ($row['appointment_time_start'] != null) {
            $app_start = date("H:i", strtotime($row['appointment_time_start']));
        }
        if ($row['appointment_time_end'] != null) {
            $app_end = " - " . date("H:i", strtotime($row['appointment_time_end']));
        } else {
            $app_end = "ไม่ระบุ";
        }
        $start_time = "<font color='blue'>" . date("d-m-Y", strtotime($row['appointment_date'])) . " " . $app_start .  $app_end . "</font>";
    }
    if ($row['finish_service_time'] != null) {
        $finish_time = "สิ้นสุด: " . date("d-m-Y H:i", strtotime($row['finish_service_time']));
    }

    $temp = array(

        "job_id" => $row['job_id'],
        "job_no" => $row['job_no'],
        "time" => $start_time . $finish_time,
        "team" => $team,
        "sym_name" => $row_fixed['sym_name'],
        "rea_name" => $row_fixed['rea_name'],
        "type" => 1,
        "job_type" => $job_type,
        "create_datetime" => $row['create_datetime']
    );

    array_push($job_list, $temp);
}




$sql_chk = "SELECT * FROM tbl_group_pm a
LEFT JOIN tbl_user g ON a.responsible_user_id = g.user_id
WHERE a.group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 
LEFT JOIN tbl_job a ON a.job_id = c.job_id 
WHERE  a.product_id = '$product_id')  ORDER BY a.create_group_datetime ASC";
$rs_chk = mysqli_query($connect_db, $sql_chk) or die($connect_db->error);
while ($row_chk = mysqli_fetch_assoc($rs_chk)) {


    $branch_id = $row_chk['branch_id'];
    $responsible_user_id = $row_chk['responsible_user_id'];

    $sql_detail = "SELECT b.* FROM tbl_group_pm_detail a 
    LEFT JOIN tbl_job b ON a.job_id = b.job_id
    WHERE a.group_pm_id = '{$row_chk['group_pm_id']}' ORDER BY job_no LIMIT 1 ";
    $rs_detail = mysqli_query($connect_db, $sql_detail);
    while ($row_detail = mysqli_fetch_assoc($rs_detail)) {
        $job_no = $row_detail['job_no'];
        $contact = $row_detail['contact_name'] . "</>" .
            "ตำแหน่ง : " . $row_detail['contact_position'] . "</br>" .
            "เบอร์ : " . $row_detail['contact_phone'] . "</br>";

        if ($row_detail['start_service_time'] != null) {
            $start_time = "เริ่ม: " . date("d-m-Y H:i", strtotime($row_detail['start_service_time'])) . "</br>";
        } else {
            if ($row_detail['appointment_time_start'] != null) {
                $app_start = date("H:i", strtotime($row_detail['appointment_time_start']));
            }
            if ($row_detail['appointment_time_end'] != null) {
                $app_end = " - " . date("H:i", strtotime($row_detail['appointment_time_end']));
            } else {
                $app_end = "ไม่ระบุ";
            }
            $start_time = "<font color='blue'>" . date("d-m-Y", strtotime($row_detail['appointment_date'])) . " " . $app_start .  $app_end . "</font>" . "</br>";
        }
        if ($row_detail['finish_service_time'] != null) {
            $finish_time = "สิ้นสุด: " . date("d-m-Y H:i", strtotime($row_detail['finish_service_time']));
        }
    }


    $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$branch_id'";
    $rs_team = mysqli_query($connect_db, $sql_team) or die($connect_db->error);
    $row_team = mysqli_fetch_assoc($rs_team);

    $sql_user = "SELECT * FROM tbl_user WHERE user_id = '$responsible_user_id'";
    $rs_user = mysqli_query($connect_db, $sql_user) or die($connect_db->error);
    $row_user = mysqli_fetch_assoc($rs_user);


    $team = "ทีม : " . $row_team['branch_name'] . "</br>" . "ช่างผู้ดูแล : " . $row_user['fullname'];


    $temp = array(

        "job_id" => $row_chk['group_pm_id'],
        "job_no" => $job_no,
        "time" => $start_time . $finish_time,
        "team" => $team,
        "sym_name" => $row_fixed['sym_name'],
        "rea_name" => $row_fixed['rea_name'],
        "type" => 2,
        "job_type" => "PM Group",
        "create_datetime" => $row_chk['create_group_datetime']
    );

    array_push($job_list, $temp);
}



array_multisort(array_column($job_list, 'create_datetime'), SORT_DESC, $job_list);
?>

<div class="table-responsive">

    <table class="table history_tbl table-striped table-hover table-bordered">

        <thead>

            <tr>

                <th style="width: 2ex;">#</th>

                <th style="width: 10ex;">ประเภทงาน</th>

                <th style="width: 10ex;">เลขที่งาน</th>

                <th style="width: 20ex;" class="text-left">วันที่บริการ</th>

                <th style="width: 25ex;" class="text-left">ช่างผู้ดูแล</th>

                <th style="width: 25ex;" class="text-left">ปัญหาการซ่อม</th>


            </tr>

        </thead>

        <tbody>

            <?php



            $i = 0;
            foreach ($job_list as $row) {
                $i++;
            ?>
                <tr id="tr_<?php echo $row['job_id']; ?>">

                    <td><?php echo $i; ?></td>

                    <td class="text-center">

                        <?php echo  $row['job_type']; ?>

                    </td>

                    <td class="text-center">

                        <?php echo  "<a href='view_cm.php?id=" . $row['job_id'] . "&&type=" . $row['type'] . "'  target='_blank'>" . $row['job_no'] . "</a>"; ?>
                        <br><?php echo date("d-m-Y", strtotime($row['create_datetime'])) ?>
                    </td>

                    <td class="text-left">

                        <?php echo $row['time']; ?>

                    </td>

                    <td class="text-left">

                        <?php echo $row['team']; ?>

                    </td>

                    <td class="text-left">

                        <?php
                        if ($row['job_type'] == 1) {
                            echo "อาการ: " . $row['sym_name'] . "</br>" .
                                "ปัญหา: " . $row['rea_name'];
                        } ?>
                    </td>

                </tr>
            <?php } ?>
        </tbody>

    </table>

</div>

<script>
    $(document).ready(function() {


    });
</script>