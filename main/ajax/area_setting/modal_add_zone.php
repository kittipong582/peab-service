<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

    
$area_id = getRandomID2(10, 'tbl_zone_oh', 'area_id ');
?>
<div class="modal-header">
    <h4 class="modal-title">เขต (OH)</h4>
</div>
<div class="modal-body">
    <form id="form_add" method="post" enctype="multipart/form-data">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>เขต</strong> <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="area_name" id="area_name">
                    <input type="hidden" name="area_id" id="area_id" value="<?php echo $area_id ?>">
                </div>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-success" onclick="AddArea();">บันทึก</button>
</div>

<?php mysqli_close($connection); ?>