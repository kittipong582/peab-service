<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$lot_id = mysqli_real_escape_string($connect_db, $_POST['id']);
$user_id = $_SESSION['user_id'];
$job_qc_id = getRandomID2(10, 'tbl_job_qc', 'job_qc_id');
?>

<form action="" method="POST" id="form_add_qc" enctype="multipart/form-data">
    <input type="text" hidden name="lot_id" id="lot_id" value="<?php echo $lot_id ?>">
    <input type="text" hidden name="user_id" id="user_id" value="<?php echo $user_id ?>">
    <input type="text" hidden id='job_qc_id' name='job_qc_id' value="<?php echo $job_qc_id ?>">
    <div class="row">
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-content">


                    <div class="row mb-3">
                        <div class="col-12">
                            <!-- <label>เลือกเครื่อง</label> -->
                            <div>
                                <?php
                                $sql_product = "SELECT a.*,b.model_code,model_name,c.product_type FROM tbl_product_waiting a LEFT JOIN tbl_product_model b ON a.model_code = b.model_code LEFT JOIN tbl_product c ON b.model_id = b.model_id WHERE lot_id = '$lot_id'";
                                $rs_product = mysqli_query($connect_db, $sql_product) or die($connect_db->error);
                                $row_product = mysqli_fetch_assoc($rs_product);
                                ?>

                                <h3>
                                    รหัสสินค้า :
                                    <?php echo $row_product['model_code'] ?>
                                    <input type="text" hidden name="model_code" id="model_code" value="<?php echo $row_product['model_code'] ?>">
                                    <input type="text" hidden  name="product_type" id="product_type" value="<?php echo $row_product['product_type'] ?>">
                                </h3>
                                <h3>
                                    ชื่อสินค้า :
                                    <?php echo $row_product['model_name'] ?>
                                </h3>

                                <h3 hidden>
                                    จำวน :
                                    <?php echo $row_product['remain_quantity'] ?>
                                </h3>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label>วันที่นัดหมาย</label>
                            <font color="red">**</font>
                            <div class="input-group date">
                                <span class="input-group-addon">
                                    <i class="fa fa-calendar"></i>
                                </span>
                                <input type="text" id="appointment_date" name="appointment_date" class="form-control datepicker" value="" autocomplete="off">
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label>Series No.</label>
                            <font color="red">**</font>
                            <div class="input-group">
                                <input type="text" name="series_no" id="series_no" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label>สถานะเครื่อง</label>
                            <font color="red">**</font>
                            <div class="input-group w-100">
                                <select class="select2 w-100" name="machine_status" id="machine_status">
                                    <option value="" disabled selected>-- เลือกสถานะ --</option>
                                    <?php
                                    $sql = "SELECT * FROM tbl_machine_status WHERE active_status = '1'";
                                    $res = mysqli_query($connect_db, $sql);
                                    while ($row = mysqli_fetch_assoc($res)) {
                                    ?>
                                        <option value="<?php echo $row['status_value']; ?>"><?php echo $row['status_name']; ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12" id="Add_branch_form" name="Add_branch_form">
                            <div id="staff_counter" hidden>0</div>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-12">
                            <label>รายชื่อช่าง</label>
                            <button type="button" class="btn btn-sm btn-primary mb-2 btn-block" onclick="add_row_staff();"><i class="fa fa-plus"></i> เพิ่ม</button>

                            <div class="d-flex">
                                <select class="form-control select2 mb-3" style="width: 100%;" name="responsible_user_id[]" id="responsible_user_id">
                                    <option value="">กรุณาเลือกช่าง</option>
                                    <?php
                                    $sql_staff = "SELECT a.*,b.branch_name FROM tbl_user a LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id WHERE  a.active_status = 1 ORDER BY branch_name ASC;";
                                    $result_staff = mysqli_query($connect_db, $sql_staff);
                                    while ($row = mysqli_fetch_assoc($result_staff)) {
                                    ?>
                                        <option value="<?php echo $row['user_id'] ?>">
                                            <?php echo $row['branch_name'] . ' - ' . $row['fullname']; ?>
                                        </option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12" id="Add_staff_form" name="Add_staff_form">
                            <div id="staff_counter" hidden>0</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</form>
<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Submit(<?php echo $lot_id ?>)">บันทึก</button>
</div>
<script>
    $(document).ready(function() {
        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });
        $(".select2").select2({

        });
    });

    function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }

    function desty_product(i) {
        document.getElementById('row_product_' + i).remove();

    }
</script>