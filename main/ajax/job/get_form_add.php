<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_type = $_POST['job_type'];
$sn = $_POST['sn'];
$st = $_POST['st'];
$branch_code = $_POST['branch_code'];
$customer_branch_id = $_POST['customer_branch_id'];
$sub_job = '';
if ($sn != '') {
    $sub_job = 44;
}

if ($job_type == 1) {
?>
    <div class="row">
        <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <br>
            <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = '$job_type' and active_status = 1";
                $result_sub  = mysqli_query($connect_db, $sql_sub);
                while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                    <option value="<?php echo $row_sub['sub_job_type_id'] ?>" <?php echo ($sub_job == $row_sub['sub_job_type_id']) ? 'selected' : ''; ?>><?php echo $row_sub['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <font color="red">**</font><br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="1" <?php echo ($st == '1') ? "selected" : ""; ?>>หมายเลข Serial No</option>
                <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="search_box" name="search_box" value="<?php echo $sn; ?>" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>
<?php } else if ($job_type == 2) { ?>



    <div class="row">

        <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <font color="red">**</font><br>
            <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = '$job_type'";
                $result_sub  = mysqli_query($connect_db, $sql_sub);
                while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                    <option value="<?php echo $row_sub['sub_job_type_id'] ?>"><?php echo $row_sub['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <font color="red">**</font><br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="1">หมายเลข Serial No</option>
                <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="search_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search_PM" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>
<?php } else if ($job_type == 3) { ?>


    <div class="row">

        <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <font color="red">**</font><br>
            <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = '$job_type'";
                $result_sub  = mysqli_query($connect_db, $sql_sub);
                while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                    <option value="<?php echo $row_sub['sub_job_type_id'] ?>"><?php echo $row_sub['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <font color="red">**</font><br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <!-- <option value="1">หมายเลข Serial No</option> -->
                <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="search_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>

<?php } else if ($job_type == 4) { ?>


    <?php if ($branch_code != "") {
    ?>
        <div class="row">
            <div class="col-4 mb-3">
                <strong>ค้นหาจาก</strong>
                <font color="red">**</font><br>
                <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 " disabled>
                    <option value="1">หมายเลข Serial No</option>
                    <option value="2">ชื่อ/รหัส ลูกค้า </option>
                    <option value="3" <?php echo (($st - 1) == '3') ? "selected" : ""; ?>>รหัสสาขา/ชื่อสาขา </option>
                </select>
            </div>

            <div class="col-4 mb-3">
                <strong></strong><br>
                <div class="input-group">
                    <input type="text" id="search_box" name="search_box" class="form-control" disabled value="<?php echo $branch_code; ?>">
                    <input type="hidden" id="search_box2" name="search_box2" class="form-control" disabled value="<?php echo $customer_branch_id; ?>">
                    <span class="input-group-append"><button type="button" id="btn_search_oh" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
                </div>
            </div>
        </div>
    <?php } else {
    ?>
        <div class="row">
            <div class="col-4 mb-3">
                <strong>ค้นหาจาก</strong>
                <font color="red">**</font><br>
                <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="1">หมายเลข Serial No</option>
                    <option value="2">ชื่อ/รหัส ลูกค้า </option>
                    <option value="3">รหัสสาขา/ชื่อสาขา </option>
                </select>
            </div>

            <div class="col-4 mb-3">
                <strong></strong><br>
                <div class="input-group">
                    <input type="text" id="search_box" name="search_box" class="form-control">
                    <span class="input-group-append"><button type="button" id="btn_search_oh" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
                </div>
            </div>
        </div>
    <?php } ?>


<?php } else if ($job_type == 5) { ?>


    <div class="row">
        <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <font color="red"> **</font><br>
            <select name="sub_job_type" id="sub_job_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = 5  and active_status = 1";
                $result_sub  = mysqli_query($connect_db, $sql_sub);
                while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                    <option value="<?php echo $row_sub['sub_job_type_id'] ?>"><?php echo $row_sub['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="1">หมายเลข Serial No</option>
                <option value="2">รหัสลูกค้า/ชื่อลูกค้า </option>
                <option value="3">รหัสสาขา/ชื่อสาขา</option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="searchoth_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search_oth" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>

<?php } else if ($job_type == 6) { ?>

    <div class="row">
        <div class="mb-3 col-3">
            <strong>ประเภทลูกค้า</strong>
            <br>
            <select id="job_customer_type" onchange="customer_type(this.value)" name="job_customer_type" class="form-control select2">
                <option value="1">ลูกค้าเดิม</option>
                <option value="2">ลูกค้าทั่วไป</option>
            </select>
        </div>

        <div class="col-4 mb-3" id="type_box">
            <strong>ค้นหาจาก</strong>
            <br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="2">รหัส/ชื่อลูกค้า </option>
                <option value="1">หมายเลข Serial No</option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3" id="type_search">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="searchqt_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search_qt" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>

<?php } else if ($job_type == 7) { ?>

    <div class="row">

        <!-- <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <br>
            <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub = "SELECT * FROM tbl_sub_job_type WHERE job_type = '$job_type' and active_status = 1";
                $result_sub  = mysqli_query($connect_db, $sql_sub);
                while ($row_sub = mysqli_fetch_array($result_sub)) { ?>
                    <option value="<?php echo $row_sub['sub_job_type_id'] ?>"><?php echo $row_sub['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div> -->
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <font color="red">**</font><br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="search_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>

<?php } else if ($job_type == 8) { ?>
    <div class="row">
        <div class="col-4 mb-3">
            <strong>ประเภทงานย่อย</strong>
            <font color="red">**</font><br>
            <select name="sub_job_type_id" id="sub_job_type_id" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="">กรุณาเลือก</option>
                <?php $sql_sub_g = "SELECT * FROM tbl_sub_job_type WHERE job_type = '2'";
                $result_sub_g  = mysqli_query($connect_db, $sql_sub_g);
                while ($row_sub_g = mysqli_fetch_array($result_sub_g)) { ?>
                    <option value="<?php echo $row_sub_g['sub_job_type_id'] ?>"><?php echo $row_sub_g['sub_type_name'] ?></option>
                <?php } ?>
            </select>
        </div>
        <div class="col-4 mb-3">
            <strong>ค้นหาจาก</strong>
            <font color="red">**</font><br>
            <select name="search_type" id="search_type" style="width: 100%;" class="form-control select2 mb-3 ">
                <option value="2">ชื่อลูกค้า/เบอร์โทร </option>
                <option value="3">รหัสสาขา/ชื่อสาขา </option>
            </select>
        </div>

        <div class="col-4 mb-3">
            <strong></strong><br>
            <div class="input-group">
                <input type="text" id="search_box" name="search_box" class="form-control">
                <span class="input-group-append"><button type="button" id="btn_search_PM_group" class="btn btn-primary"><i class="fa fa-search"></i></button></span>
            </div>
        </div>
    </div>

<?php } ?>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {

        $('#search_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $('#search_box').val() != "") {
                Search();
            }
        });

        $('#btn_search').on('click', function() {
            if ($('#search_box').val() != "") {
                Search();
            }
        });

        $('#btn_search_PM').on('click', function() {
            if ($('#search_box').val() != "") {
                SearchPM();
            }
        });

        $('#btn_search_PM_group').on('click', function() {
            if ($('#search_box').val() != "") {
                SearchPMGroup();
            }
        });




        $('#searchoth_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $('#searchoth_box').val() != "") {
                SearchOth();
            }
        });

        $('#btn_search_oth').on('click', function() {
            if ($('#searchoth_box').val() != "") {
                SearchOth();
            }
        });


        $('#searchoh_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $('#searchoh_box').val() != "") {
                SearchOH();
            }
        });

        $('#btn_search_oh').on('click', function() {
            if ($('#searchoh_box').val() != "") {
                SearchOH();
            }
        });


        $('#searchqt_box').keypress(function(event) {
            var keycode = (event.keyCode ? event.keyCode : event.which);
            if (keycode == '13' && $('#searchqt_box').val() != "") {
                Searchqt();
            }
        });

        $('#btn_search_qt').on('click', function() {
            if ($('#searchqt_box').val() != "") {
                Searchqt();
            }
        });
    });
</script>