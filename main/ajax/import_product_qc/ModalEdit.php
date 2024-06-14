<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$lot_id = mysqli_real_escape_string($connection, $_POST['lot_id']);

$sql = "SELECT * FROM tbl_product_waiting WHERE lot_id = '$lot_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขสินค้า QC</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
    <div class="col-6 ">
        <label class="font-normal">Customer Order No.</label>
        <input type="text" class="form-control" id="update_topic_datail" name="update_topic_datail" value="<?php echo $row['topic_datail']; ?>">
    </div>
    <div class="col-6 ">
        <label class="font-normal">รหัสสินค้า</label>
        <input type="text" class="form-control" id="update_topic_datail" name="update_topic_datail" value="<?php echo $row['topic_datail']; ?>">
    </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="UpdateList('<?php echo $topic_id ?>')"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>