<?php

session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$year = mysqli_real_escape_string($connection, $_POST['year']);

?>
<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-title">
            <div class="row" style="margin-top: 10px;">
                <div class="col-3">
                    <div class="form-group">
                        <label>เดือน</label>
                        <select class="form-control select2" name="select_month" id="select_month" onchange="load_graph_month()">
                            <?php
                            echo $sql_m = "SELECT DISTINCT(YEAR(appointment_date)) AS job_year , MONTH(appointment_date) AS job_month FROM `tbl_job` WHERE YEAR(appointment_date) ='$year' ORDER BY `job_month` asc;";
                            $res_m = mysqli_query($connection, $sql_m);
                            while ($row_m = mysqli_fetch_assoc($res_m)) {
                            ?>
                                <option value="<?php echo $row_m['job_month'] ?>"><?php echo  $row_m['job_month']; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group">
                        <label>ประเภทงาน</label>
                        <select class="form-control select2" name="job_type" id="job_type" onchange="load_graph_month()">
                            <option value="1">CM</option>
                            <option value="2">PM</option>
                            <option value="3">IN</option>
                            <option value="4">OH</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="ibox-tools">
            </div>
        </div>
    </div>
</div>