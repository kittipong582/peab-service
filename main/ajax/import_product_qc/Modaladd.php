<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

// $lot_id = mysqli_real_escape_string($connection, $_POST['lot_id']);

$sql = "SELECT * FROM tbl_product_waiting WHERE lot_id = '$lot_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

$lot_id = getRandomID2(10, "tbl_product_waiting", "lot_id");


?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่มสินค้า QC</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<form id="frm_add" method="POST" enctype="multipart/form-data">
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 md-3" style="margin-top: 10px;">
                <input type="text" hidden id="lot_id" name="lot_id" value="<?php echo $lot_id ?>">
                <label><strong>Customer Order No.</strong> <span class="text-danger">**</span></label>
                <input type="text" class="form-control" id="ref_number" name="ref_number">
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12 md-3" style="margin-top: 10px;">
                <label><strong>รหัสสินค้า</strong> <span class="text-danger">**</span></label>
                <input type="text" class="form-control" id="model_code" name="model_code">
            </div>
        </div>

        <div class="row"> 
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;">
                <label><strong>ล็อต</strong> <span class="text-danger">**</span></label>
                <input type="text" class="form-control" id="lot_no" name="lot_no">
            </div>
            <div class="col-lg-12 col-md-12 col-sm-12" style="margin-top: 10px;">
                <label><strong>จำนวนรวม</strong> <span class="text-danger">**</span></label>
                <input type="text" class="form-control" id="quantity" name="quantity">
            </div>
        </div>
    </div>

</form>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="AddList()">บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>