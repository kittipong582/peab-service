<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_type = $_POST['job_type'];

$sql = "SELECT * FROM tbl_sub_job_type WHERE job_type = '$job_type' AND active_status = 1";
$result  = mysqli_query($connect_db, $sql);


?>


<div class="form-group">
    <label>ชื่องาน</label>
    <select class="form-control select2" id="sub_title" name="sub_title" data-width="100%">
        <option value="x">ทั้งหมด </option>
        <?php while ($row = mysqli_fetch_array($result)) { ?>
            <option value="<?php echo $row['sub_job_type_id']; ?>"><?php echo $row['sub_type_name']; ?></option>
        <?php } ?>
    </select>
</div>