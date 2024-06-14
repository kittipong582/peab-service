<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



$sub_job_type_id = mysqli_real_escape_string($connect_db, $_POST['sub_job_type_id']);
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มงานย่อย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">

            <input type="text" hidden name="sub_job_type_id" value="<?php echo $sub_job_type_id; ?>">
            <label for="sub_type_name">
                <strong> ชื่องานย่อย </strong>
            </label>
            <input type="text" class="form-control mb-3" id="sub_type_name" name="sub_type_name">



            <label for="job_type">
                ประเภทงาน
            </label>
            <font color="red">**</font><br>
            <select class="form-control select2" name="job_type" id="job_type" style="width: 100%;">
                <option value="">กรุณาเลือกประเภท</option>
                <option value="1">CM</option>
                <option value="2">PM</option>
                <option value="3">Installation</option>
                <option value="5">งานอื่นๆ</option>



            </select>
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