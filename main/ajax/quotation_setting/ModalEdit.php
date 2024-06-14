<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$qs_id = mysqli_real_escape_string($connect_db, $_POST['qs_id']);

$sql = "SELECT * FROM tbl_quotation_setting WHERE qs_id = '$qs_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="qs_id" name="qs_id" value="<?php echo $qs_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขงานย่อย</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <label>
            ชื่อประเภท
        </label>
        <input type="text" class="form-control mb-3" id="qs_name" name="qs_name" value="<?php echo $row['qs_name']; ?>">



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