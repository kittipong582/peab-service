<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

    // var_dump($_POST);
$job_type = $_POST['job_type'];
// $product_type = $_POST['product_type'];

$sql = "SELECT COUNT(list_order) as Form_num FROM tbl_job_evaluate WHERE job_type = '$job_type' ";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);

$choice_num = $row['Form_num'] + 1;
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มฟอร์ม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" class="form-control" id="job_type" name="job_type" value="<?php echo $job_type ?>"
            readonly>

        <div class="row">
            <div class="col-2 mb-3">
                <label>ข้อ</label>
                <input type="text" class="form-control" name="list_order" value="<?php echo $choice_num ?>" readonly>
            </div>

            <div class="col-9 mb-3">
                <label>หัวข้อแบบประเมินความพึ่งพอใจ</label><br>
                <input type="text" class="form-control" id="detail" name="detail" value="">


            </div>

            <!-- <div class="col-4 mb-3">
                <label>ประเภท</label><br>
                <select class="form-control select2" id="form_type" name="form_type" style="width: 100%;"
                    onchange="able_chk(this.value)">
                    <option value="">กรุณาเลือก</option>
                    <option value="1"> 2 ตัวเลือก</option>
                    <option value="2">บันทึก 2 ค่า</option>
                </select>
            </div>


            <div class="col-2 mb-3">
                <label>มีหมายเหตุ</label><br>
                <input type="checkbox" class="icheckbox_square-green chkbox" disabled value="0" name="have_remark"
                    id="have_remark">
                <label></label>

            </div>

            <div class="col-6 mb-3">
                <label>ข้อความตัวเลือกหน้า</label><br>
                <input type="text" class="form-control" id="choice1" name="choice1" value="">
                <label></label>

            </div>

            <div class="col-6 mb-3">
                <label>ข้อความตัวเลือกหลัง</label><br>
                <input type="text" class="form-control" id="choice2" name="choice2" value="">
                <label></label>

            </div> -->



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


$('.chkbox').iCheck({
    checkboxClass: 'icheckbox_square-green',
    radioClass: 'iradio_square-green',
}).on('ifChanged', function(e) {
    if (this.checked) {

        $(this).val('1');

    } else {

        $(this).val('0');

    }
});


function able_chk(check_val) {

    if (check_val == 1) {
        // document.getElementById("have_remark").disabled = false;
        $(".icheckbox_square-green").removeClass("disabled");
        $("#have_remark").prop('disabled', false);
    } else {
        // document.getElementById("have_remark").disabled = true;
        $("#have_remark").prop('disabled', true);
        $(".icheckbox_square-green").addClass("disabled");
    }

}
</script>