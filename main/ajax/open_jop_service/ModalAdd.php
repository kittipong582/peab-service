
<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
// $service_id =mysqli_real_escape_string($connect_db, $_POST['service_id']);
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มการบริการ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <!-- <input type="text" hidden name="brand_id" value="<?php echo $service_id; ?>"> -->
        <label for="service_name">
            ค่าบริการ
        </label>
        <input type="text" class="form-control mb-3" id="service_name" name="service_name">

        <label for="unit">
            หน่วย
        </label>
        <input type="text" class="form-control mb-3" id="unit" name="unit">

        <label for="unit_cost">
        ต้นทุนต่อหน่วย
        </label>
        <input type="text" class="form-control mb-3" id="unit_cost" name="unit_cost">
    </div>
    
        <!-- <label for="model_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label> -->
        
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>