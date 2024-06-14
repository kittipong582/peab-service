<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$from_branch = $_POST['from_branch'];


?>

<div class="form-group">
    <div class="row">

        <div class="col-md-1 col-xs-1 col-sm-1 text-center"></div>
        <div class="col-md-2 col-xs-2 col-sm-2 text-center" ><label >รหัสอะไหล่</label></div>
        <div class="col-mb-3 col-xs-3 col-sm-3 text-center"><label >รายการอะไหล่</label></div>
        <div class="col-md-2 col-xs-2 col-sm-2 text-center"></div>
        <div class="col-mb-2 col-xs-2 col-sm-2 " style="padding-left: 6ex;"><label >จำนวนคงเหลือ</label></div>
        <div class="col-mb-2 col-xs-2 col-sm-2 " style="padding-left: 6ex;"><label>จำนวนโอนย้าย</label></div>

    </div>

    <div id="Addform_transfer" name="Addform_transfer">
    </div>
    <div id="counter" hidden>0</div>

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row('<?php echo $from_branch; ?>');"><i class="fa fa-plus"></i>
                เพิ่มรายการ
            </button>
        </div>
    </div>
</div>