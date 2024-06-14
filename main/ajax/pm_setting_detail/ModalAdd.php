<?php
session_start();
include("../../../config/main_function.php");
date_default_timezone_set("Asia/Bangkok");


$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);
$pm_setting_detail_id = mysqli_escape_string($connection, $_POST["pm_setting_id"]);


$sql = "SELECT * FROM  tbl_pm_setting_detail";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

// echo "$sql";
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มdetail</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="text" hidden name="pm_setting_id" value="<?php echo $pm_setting_detail_id; ?>">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="form-group">
                    <label><strong>detail</strong> <span class="text-danger">*</span></label>
                    <textarea class="form-control" name="detail" id="detail" cols="30" rows="10"></textarea>

                </div>
            </div>


        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<Script>
   $(document).ready(function () {
    // Initialize Summernote for textareas with the class 'summernote'
   
    // Initialize Select2 for elements with the class 'select2'
    $(".select2").select2({});
});


</Script>