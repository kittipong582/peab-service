<?php

include("../../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$form_id = $_POST['form_id'];

$sql = "SELECT * FROM tbl_oh_form WHERE form_id = '$form_id'";
$rs  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($rs);



?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เเก้ไขฟอร์ม</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" class="form-control" id="form_id" name="form_id" value="<?php echo $form_id ?>" readonly>
        <div class="row">
            <div class="col-2 mb-3">
                <label>ข้อ</label>
                <input type="text" class="form-control" name="list_order" value="<?php echo $row['list_order'] ?>" readonly>
            </div>

            <div class="col-4 mb-3">
                <label>หัวข้อ</label><br>
                <input type="text" class="form-control" id="form_name" name="form_name" value="<?php echo $row['form_name'] ?>">


            </div>

            <div class="col-4 mb-3">
                <label>ประเภท</label><br>
                <select class="form-control select2" id="form_type" name="form_type" style="width: 100%;" onchange="able_chk(this.value)">
                    <option value="">กรุณาเลือก</option>
                    <option value="1" <?php echo ($row['form_type'] == 1) ? 'SELECTED' : ''; ?>> 2 ตัวเลือก</option>
                    <option value="2" <?php echo ($row['form_type'] == 2) ? 'SELECTED' : ''; ?>>บันทึก 2 ค่า</option>
                    <option value="3" <?php echo ($row['form_type'] == 3) ? 'SELECTED' : ''; ?>>หมายเหตุอย่างเดียว</option>
                </select>
            </div>


            <div class="col-2 mb-3">
                <label>มีหมายเหตุ</label><br>
                <input type="checkbox" class="icheckbox_square-green chkbox  <?php echo $dis_status ?>" <?php echo ($row['have_remark'] == 1) ? 'CHECKED' : ''; ?> name="have_remark" id="have_remark">
                <input type="hidden" class="icheckbox_square-green chkbox" value="<?php echo $row['have_remark'] ?>" name="remark_val" id="remark_val">
                <label></label>

            </div>

            <div class="col-6 mb-3">
                <label>ข้อความตัวเลือกหน้า</label><br>
                <input type="text" class="form-control" id="choice1" name="choice1" value="<?php echo $row['choice1'] ?>">
                <label></label>

            </div>

            <div class="col-6 mb-3">
                <label>ข้อความตัวเลือกหลัง</label><br>
                <input type="text" class="form-control" id="choice2" name="choice2" value="<?php echo $row['choice2'] ?>">
                <label></label>

            </div>



        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update_OH();">บันทึก</button>
    </div>
</form>


<?php include("import_script.php"); ?>

<script>
    $(document).ready(function() {
        $(".select2").select2({});

        able_chk();
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

    function able_chk() {

        var check_val = $('#form_type').val();
        if (check_val == 1) {
            // document.getElementById("have_remark").disabled = false;
            $(".icheckbox_square-green").removeClass("disabled");
            $("#have_remark").prop('disabled', false);
            $('#remark_val').val('0');
            $("#choice2").prop('readonly', false);
            $("#choice1").prop('readonly', false);
        } else if (check_val == 2) {
            // document.getElementById("have_remark").disabled = true;
            $("#have_remark").prop('disabled', true);
            $(".icheckbox_square-green").removeClass("checked");
            $('#remark_val').val('0');
            $(".icheckbox_square-green").addClass("disabled");
            $("#choice2").prop('readonly', false);
            $("#choice1").prop('readonly', false);
        } else if (check_val == 3) {

            $("#have_remark").prop('disabled', true);
            $('#remark_val').val('1');
            $(".icheckbox_square-green").addClass("checked");
            $(".icheckbox_square-green").addClass("disabled");

            $("#choice2").prop('readonly', true);
            $('#choice2').val('');
            $("#choice1").prop('readonly', true);
            $('#choice1').val('');
        }

    }
</script>