<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$user_id = $_POST['user_id'];


?>

<div class="form-group">

    <div id="Addform_ax" name="Addform_ax">
    </div>
    <div id="counter" hidden>0</div>

    <div class="row">
        <div class="col-md-12">
            <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row('<?php echo $user_id; ?>');"><i class="fa fa-plus"></i>
                เพิ่มรายการ
            </button>
        </div>
    </div>
</div>