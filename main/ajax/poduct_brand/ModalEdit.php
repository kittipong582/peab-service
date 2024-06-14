<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);

$sql = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-edit"  enctype="multipart/form-data">
    <input type="text" hidden id="brand_id" name="brand_id" value="<?php echo $brand_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขยี่ห้อ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <label for="brand_name">
            ชื่อยี่ห้อ
        </label>
        <input type="text" class="form-control mb-3" id="brand_name" name="brand_name" value="<?php echo $row['brand_name']; ?>">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>