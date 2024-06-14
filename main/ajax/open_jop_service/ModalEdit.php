<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$service_id = mysqli_real_escape_string($connect_db, $_POST['service_id']);

$sql = "SELECT * FROM tbl_oth_open_job_service WHERE service_id = '$service_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="service_id" name="service_id" value="<?php echo $service_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขการบริการ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <label for="service_name">
        ค่าบริการ
        </label>
        <input type="text" class="form-control mb-3" id="service_name" name="service_name"
            value="<?php echo $row['service_name']; ?>">

            <label for="unit">
            หน่วย
        </label>
        <input type="text" class="form-control mb-3" id="unit" name="unit"
            value="<?php echo $row['unit']; ?>">

            <label for="unit_cost">
            ต้นทุนต่อหน่วย
        </label>
        <input type="text" class="form-control mb-3" id="unit_cost" name="unit_cost"
            value="<?php echo $row['unit_cost']; ?>">
    </div>

    <!-- <label for="spare_part_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label> -->

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>