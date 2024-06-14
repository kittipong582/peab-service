<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

    $area_id = mysqli_real_escape_string($connection, $_POST['area_id']);

    $sql = "SELECT * FROM tbl_zone_oh WHERE area_id = '$area_id'";
    $res = mysqli_query($connection, $sql) or die($connection->error);
    $row = mysqli_fetch_assoc($res);
?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขเขต (OH)</h4>
</div>
<div class="modal-body">
    <form id="form_edit" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>เขต</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="area_name" id="area_name" value="<?php echo $row['area_name'] ?>">
                    <input type="hidden" name="area_id" id="area_id" value="<?php echo $area_id ?>">
                </div>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" onclick="Update();">บันทึก</button>
</div>

<?php mysqli_close($connection); ?>