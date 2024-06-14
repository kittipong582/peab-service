<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$user_level = $_SESSION['user_level'];
$check_branch = $_POST['check_plan'];
$i = $_POST['Count_Row'];
$row = $_POST['row'];
$start_help_date = $_POST['start_help_date'];
$distance_date = $_POST['distance_date'];
$appointment_date = $_POST['appointment_date'];
$plan_times = $_POST['plan_times'];

for ($i; $i <= $plan_times; $i++) {
    if ($start_help_date == "") {
        $date = '';
    }

    if ($i == 1) {
        $date = date("d-m-Y", strtotime($start_help_date));
    } else {
        $day = "+" . $distance_date * ($i - 1) . " days";
        $date = date("d-m-Y", strtotime($start_help_date . $day));
    }



    $sql_team = "SELECT * FROM tbl_branch WHERE branch_id = '$check_branch' and active_status = 1 order by branch_name";
    $rs_team  = mysqli_query($connection, $sql_team);
    $row_team = mysqli_fetch_array($rs_team);

?>

    <div class="row mb-3 new_pm_multi_form">
        <input type="hidden" readonly id="branch_care_id_<?php echo $i ?>" value="<?php echo $check_branch ?>" name="branch_care_id[]" class="form-control branch_care_id">
        <input type="hidden" id="row" name="row" value="<?php echo $i ?>">
        <input type="hidden" id="date" name="date" value="<?php echo $date ?>">
        <div class="mb-3 col-3">
            <label>วันที่</label>
            <font color="red">**</font>
            <div class="input-group date">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="text" id="appointment_date_<?php echo $i ?>" name="appointment_date[]" onchange="check_job_pm(this.value,'<?php echo $i ?>'),get_date(this.value,'<?php echo $i ?>')" class="form-control datepicker" readonly value="<?php echo $date; ?>" autocomplete="off">
            </div>
        </div>

        <div class="mb-3 col-3">
            <label>ทีมดูแล</label>
            <div class="input-group">
                <input type="text" id="branch_care_<?php echo $i ?>" value="<?php echo $row_team['branch_name'] ?>" readonly name="branch_care[]" class="form-control branch_care">
                <?php if ($user_level != 1 && $user_level != 2) { ?>
                    <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care_PM('<?php echo $i ?>')" class="btn btn-primary">เลือกทีมอื่น</button></span>
                <?php } ?>
            </div>

        </div>

        <div class="mb-3 col-2 user_list" id="user_list_<?php echo $i ?>">
            <label>ช่างผู้ดูแล</label>

            <select class="form-control select2" id="" onchange="" name="">
                <option value="<?php echo null ?>">ไม่ระบุ</option>
            </select>
        </div>

        <div class="mb-3 col-2">
            <label>เวลา</label>
            <select name="PMhours[]" id="PMhours_<?php echo $i ?>" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="<?php echo null ?>">--</option>
                <?php $t = 0;
                $h = 2;
                while ($t <= 23) {
                    $time = sprintf("%0" . $h . "d", $t); ?>
                    <option value="<?php echo $time ?>"><?php echo $time ?></option>

                <?php $t++;
                } ?>
            </select>
        </div>
        <div class="mb-3 col-1">
            <label>นาที</label>
            <select name="PMminutes[]" id="PMminutes_<?php echo $i ?>" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="<?php echo null ?>">--</option>
                <?php $t = 0;
                $h = 2;
                while ($t <= 59) {
                    $time = sprintf("%0" . $h . "d", $t); ?>
                    <option value="<?php echo $time ?>"><?php echo $time ?></option>

                <?php $t++;
                } ?>
            </select>
        </div>
        <div class=" mb-3 col-1 text-right">
            <label></label><br>
            <button class="btn btn-sm btn-danger delete-contact" type="button">ลบ</button>
        </div>

        <div class="mb-3 col-8" id="alert_text_<?php echo $i ?>">

        </div>
        <div class="mb-3 col-2">
            <label>เวลาดำเนินการเสร็จ</label>
            <select name="PMhoure[]" id="PMhoure_1" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="<?php echo null ?>">--</option>
                <?php $tt = 0;
                $h = 2;
                while ($tt <= 23) {
                    $time = sprintf("%0" . $h . "d", $tt); ?>
                    <option value="<?php echo $time ?>"><?php echo $time ?></option>

                <?php $tt++;
                } ?>
            </select>
        </div>
        <div class="mb-3 col-1">
            <label>นาที</label>
            <select name="PMminutee[]" id="PMminutee_1" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="<?php echo null ?>">--</option>
                <?php $tt = 0;
                $h = 2;
                while ($tt <= 59) {
                    $time = sprintf("%0" . $h . "d", $tt); ?>
                    <option value="<?php echo $time ?>"><?php echo $time ?></option>

                <?php $tt++;
                } ?>
            </select>
        </div>


    </div>
<?php } ?>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        var row = <?php echo $i ?>;
        var customer_branch_id = $('#customer_branch_id').val();
        var date = $('#appointment_date_' + row).val();

        $.ajax({
            url: 'ajax/job/PM/Check_Pm_job.php',
            type: 'POST',
            dataType: 'json',
            data: {
                date: date,
                customer_branch_id: customer_branch_id
            },
            success: function(data) {

                $('#alert_text_' + row).html(data.alert_text);

            }
        });


    });
</script>