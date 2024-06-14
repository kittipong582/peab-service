<?php
@include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$queue_id = mysqli_real_escape_string($connect_db, $_POST['queue_id']);

$sql = "SELECT * FROM tbl_customer_queue WHERE queue_id = '$queue_id'";
$res = mysqli_query($connect_db, $sql) or die($connection->error);
$row = mysqli_fetch_assoc($res);


$sql_area = "SELECT * FROM tbl_zone_oh WHERE active_status = 1";
$res_area = mysqli_query($connect_db, $sql_area) or die($connection->error);
?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไข ภาค</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <input type="hidden" name="queue_id" id="queue_id" value="<?php echo $queue_id ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <strong>ภาค</strong>
                <font color="red">**</font>
                <select name="area_id" id="area_id" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">กรุณาเลือก</option>
                    <?php while ($row_area = mysqli_fetch_assoc($res_area)) { ?>
                        <option value="<?php echo $row_area['area_id'] ?>"<?php echo ($row_area['area_id'] == $row ['area_id'] ? "selected" : ""); ?>>
                            <?php echo $row_area['area_name'] ?>
                        </option>
                    <?php } ?>
                </select>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" onclick="Update_Zone()">บันทึก</button>
</div>