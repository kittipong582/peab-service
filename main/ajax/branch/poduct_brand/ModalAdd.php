
<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_type_id = getRandomID(10, 'tbl_spare_type', 'spare_type_id');

?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มประเภทอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="text" hidden name="spare_type_id" value="<?php echo $spare_type_id; ?>">
        <label for="spare_type_name">
            ชื่อประเภทอะไหล่
        </label>
        <input type="text" class="form-control mb-3" id="spare_type_name" name="spare_type_name">
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>