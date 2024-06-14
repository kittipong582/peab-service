<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มประเภทงานอื่นๆ</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <label>
                <strong> ชื่อประเภท </strong>
            </label>
            <input type="text" class="form-control mb-3" id="oth_type_name" name="oth_type_name">

        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>


<?php include("import_script.php"); ?>

<script>
    $(document).ready(function() {
        $(".select2").select2({});
    });
</script>