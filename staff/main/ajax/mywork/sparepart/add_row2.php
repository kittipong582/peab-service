<?php
session_start();
include("../../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$job_id = $_POST['job_id'];

$sql_op = "SELECT * FROM tbl_job a
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
WHERE a.job_id = '$job_id'";
$result_op  = mysqli_query($connection, $sql_op);
$row_op = mysqli_fetch_array($result_op);


$sql_spare = "SELECT * FROM tbl_branch_stock b 
LEFT JOIN tbl_spare_part c ON b.spare_part_id = c.spare_part_id
WHERE  b.branch_id = '{$row_op['branch_id']}'";
$result  = mysqli_query($connection, $sql_spare);


$sql_wtt = "SELECT * FROM tbl_warranty_type WHERE active_status = 1";
$result_wtt  = mysqli_query($connection, $sql_wtt);
?>

<div name="div_ax[]" id="div_<?php echo $i; ?>" value="<?php echo $i; ?>">

    <div class="ibox mb-3 d-block border-black">
        <div class="ibox-content">
            <div class="row">

                <input type="hidden" id="spare_used_id_<?php echo $i; ?>" name="spare_used_id[]" value="<?php echo getRandomID(5, 'tbl_job_spare_used', 'spare_used_id'); ?>">

                <div class="col-8">
                    <div class="form-group">
                        <button style="width:50px;" type="button" class="btn btn-xs btn-danger" name="button" onclick="desty2('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                    </div>
                </div>

                <!-- <div class="col-1">
                    <input class="icheckbox_square-green" type="checkbox" name="chkbox[]" id="chkbox_<?php echo $i; ?>" value="chkbox">

                    <input type="hidden" id="insurance_status_<?php echo $i; ?>" name="insurance_status[]" value="0" style="position: absolute; opacity: 0;">

                </div> -->

                <div class="col-4">
                    <label>ประกัน</label>
                    <select class='form-control select2' name='insurance_status[]' id='insurance_status_<?php echo $i; ?>'>
                        <?php while ($row_wtt = mysqli_fetch_array($result_wtt)) { ?>
                            <option value='<?php echo $row_wtt['warranty_type_id'] ?>'><?php echo $row_wtt['warranty_type_name'] ?></option>

                        <?php } ?>
                    </select>
                </div>
            </div>

            <br>

            <div class="row">
                <div class="col-12">
                    <select name="spare_part[]" id="spare_part_<?php echo $i; ?>" style="width:50%;" onchange="select_part(this.value,'<?php echo $i ?>','<?php echo $row_op['branch_id'] ?>');" class="form-control select2 spare_part">
                        <option value="">กรุณาเลือกอะไหล่</option>
                        <?php while ($row_spare = mysqli_fetch_array($result)) { ?>
                            <option value="<?php echo $row_spare['spare_part_id'] ?>"><?php echo $row_spare['spare_part_code'] . " " . $row_spare['spare_part_name'] ?></option>
                        <?php } ?>


                    </select>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col-6">
                    <label>ที่พร้อมใช้งาน</label>
                    <input type="text" class="form-control Onhand" readonly name="Onhand[]" id="Onhand_<?php echo $i; ?>" value="">

                </div>

                <div class="col-6">
                    <label>จำนวนที่ใช้</label>
                    <input type="text" class="form-control quantity" name="quantity[]" id="quantity_<?php echo $i; ?>" value="">

                </div>


                <input type="hidden" class="form-control" readonly name="cost[]" id="cost_<?php echo $i; ?>" value="">


            </div>
        </div>
    </div>
</div><br>