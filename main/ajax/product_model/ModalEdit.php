<?php
include ("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$model_id = mysqli_real_escape_string($connect_db, $_POST['model_id']);

$sql = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="model_id" name="model_id" value="<?php echo $model_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขรุ่น</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>

    <div class="modal-body">
        <div class="row">

            <div class="col-6">

                <label for="model_name">
                    รหัสรุ่น
                </label>
                <input type="text" class="form-control mb-3" id="model_code" value="<?php echo $row['model_code']; ?>"
                    name="model_code">
            </div>

            <div class="col-6">
                <label for="model_name">
                    ชื่อรุ่น
                </label>
                <input type="text" class="form-control mb-3" id="model_name" name="model_name"
                    value="<?php echo $row['model_name']; ?>">
            </div>
            <div class="col-12">       
                        <label for="upload_file">
                            รูปรุ่น
                        </label>    
                    <input type="file" id="file_name"  name="file_name" class="form-control" >
            </div>
        </div>

    </div>

    <!-- <label for="spare_part_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label> -->

    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>