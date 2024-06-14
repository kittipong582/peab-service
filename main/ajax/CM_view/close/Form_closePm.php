<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$type = $_POST['type'];


$sql_last = "SELECT * FROM tbl_job WHERE job_id = '$job_id'";
$rs_last = mysqli_query($connect_db, $sql_last);
$row_last = mysqli_fetch_assoc($rs_last);
?>

<input id="job_id" name="job_id" value="<?php echo $job_id ?>" type="hidden">
<?php if ($type == 1) { ?>
    <div class="col-12 mb-3">
        <textarea class="summernote" id="close_note" name="close_note"></textarea>
    </div>

<?php } else { ?>

    <input type="hidden" id="check_help" name="check_help" value="0">
    <div class="row">
        <div class="mb-3 col-4">
            <label>วันที่</label>
            <div class="input-group date">
                <span class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                </span>
                <input type="text" id="start_help_date" name="start_help_date" class="form-control datepicker" readonly value="<?php echo date("d-m-Y", strtotime($row_last['finish_service_time'])) ?>" autocomplete="off">
            </div>
        </div>

        <div class="mb-3 col-3">
            <label>จำนวนครั้ง</label>
            <div class="input-group">
                <input type="text" id="plan_times" name="plan_times" class="form-control ">
            </div>
        </div>

        <div class="mb-3 col-3">
            <label>ระยะห่าง (วัน)</label>

            <input type="text" id="distance_date" name="distance_date" class="form-control">
        </div>
        <div class="mb-3 col-2">
            <label></label><br>
            <button class="btn btn-sm btn-primary" type="button" onclick="create_plan()">
                สร้างแผนงาน
            </button>
        </div>
    </div>

    <hr>

    <div>
        <input type="hidden" id="check_plan" name="check_plan">
    </div>

    <div id="PMcounter" hidden>1</div>

    <div id="form_contact"></div>


<?php } ?>