<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$warranty_type_id  = mysqli_real_escape_string($connect_db, $_POST['warranty_type_id']);
$sql = "SELECT * FROM tbl_warranty_type WHERE warranty_type_id  = '$warranty_type_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="warranty_type_id" name="warranty_type_id" value="<?php echo $warranty_type_id ; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขประเภท</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <label>
            ชื่อ
        </label>
        <input type="text" class="form-control mb-3" id="warranty_type_name" name="warranty_type_name" value="<?php echo $row['warranty_type_name']; ?>">

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