<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$sub_job_type_id = mysqli_real_escape_string($connect_db, $_POST['sub_job_type_id']);

$sql = "SELECT * FROM tbl_sub_job_type WHERE sub_job_type_id = '$sub_job_type_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="sub_job_type_id" name="sub_job_type_id" value="<?php echo $sub_job_type_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขงานย่อย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">

        ชื่องาน
        </label>
        <input type="text" class="form-control mb-3" id="sub_type_name" name="sub_type_name" value="<?php echo $row['sub_type_name']; ?>">

        <label for="job_type">
            ประเภทงาน
        </label>
        <font color="red">**</font><br>
        <select name="job_type" id="job_type" style="width: 100%;" class="form-control select2 mb-3 ">

            <option value="">กรุณาเลือกประเภท</option>
            <option value="1" <?php if ($row['job_type'] == 1) {
                                    echo 'selected';
                                } ?>>CM</option>
            <option value="2" <?php if ($row['job_type'] == 2) {
                                    echo 'selected';
                                } ?>>PM</option>
            <option value="3" <?php if ($row['job_type'] == 3) {
                                    echo 'selected';
                                } ?>>Installation</option>
            <option value="5" <?php if ($row['job_type'] == 5) {
                                    echo 'selected';
                                } ?>>งานอื่นๆ</option>



        </select>

    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>

<?php include("import_script.php"); ?>

<script>
    $(document).ready(function() {
        $(".select2").select2({});
    });
</script>