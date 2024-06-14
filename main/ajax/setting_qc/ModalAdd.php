<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$type_id = $_POST['type_id'];
//echo $type_id;
?>
<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <input type="text" hidden id="type_id" name="type_id" value="<?php echo $type_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle"><strong>เพิ่ม</strong></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
                <label>หัวข้อ</label>
                <input type="text" class="form-control" id="checklist_name" name="checklist_name">
            </div>
            <div class="col-6 mb-3">
                <label>เลือก Checkbox,Dropdown</label>
                <select class="form-control select2" id="checklist_type" name="checklist_type">
                    <option value="x" selected>กรุณาเลือก</option>
                    <option value="1">Checkbox</option>
                    <option value="2">Dropdown</option>
                </select>
            </div>
        </div>

    </div>
    <div class="modal-footer">
        <button class="btn btn-primary px-7" type="button" id="submit" onclick="Add()">บันทึก</button>
    </div>
</form>

<?php include('import_script.php'); ?>
<script>
    $(document).ready(function () {

    });
    function Add() {

        var checklist_name = $('#checklist_name').val();

        var formData = new FormData($("#form-add")[0]);

        if (checklist_name == "") {
            swal({
                title: 'เกิดข้อผิดพลาด',
                text: 'กรุณากรอกข้อมูลให้ครบถ้วน',
                type: 'error'
            });
            return false;
        }

        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            closeOnConfirm: false
        }, function () {

            $.ajax({
                type: 'POST',
                url: 'ajax/setting_qc/Add.php',
                data: formData,
                processData: false,
                contentType: false,
                dataType: 'json',
                success: function (data) {
                    if (data.result == 1) {
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false
                        });
                        setTimeout(function () {
                            swal.close();
                        }, 500);
                        $("#modal").modal('hide');
                        GetTable();
                    } else if (data.result == 2) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'จำนวนอะไหล่ไม่พอ กรุณากรอกใหม่ !!',
                            type: 'warning'
                        });
                        return false;
                    }

                }
            })
        });

    }
</script>