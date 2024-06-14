<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


$checklist_id = getRandomID2(10, 'tbl_qc_checklist', 'checklist_id');
$topic_qc_id = mysqli_real_escape_string($connection, $_POST['topic_qc_id']);
?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่มรายการตรวจเช็ค</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="frm_choice_add" method="POST" enctype="multipart/form-data">
        <input type="text" hidden id='checklist_id' name='checklist_id' value="<?php echo $checklist_id ?>">
        <input type="text" hidden id='topic_qc_id' name='topic_qc_id' value="<?php echo $topic_qc_id ?>">
        <div class="row mb-3">
            <div class="col-12">
                <label class="font-normal">ชื่อหัวข้อ</label>
                <input type="text" class="form-control" id="checklist_name" name="checklist_name" placeholder="">
            </div>
        </div>
        <div class="row mb-3">
        <div class="col-6">
                <label class="font-normal">วิธีการ QC</label>
                <input type="text" class="form-control" id="" name="description" placeholder="">
            </div>
            <div class="col-6">
                <label class="font-normal">เกณฑ์การยอมรับ QC ผ่าน</label>
                <input type="text" class="form-control" id="" name="description_way" placeholder="">
            </div>
        </div>

        <div class="row mb-3">
        <div class="col-6">
                <label class="font-normal">จำนวนครั้ง QC</label>
                <input type="text" class="form-control" id="" name="description_acceptance" placeholder="">
            </div>
            <div class="col-6">
                <label class="font-normal">ใช้เวลา QC (นาที)</label>
                <input type="text" class="form-control" id="" name="description_time" placeholder="">
            </div>
        </div>


        <div class="form-group">
            <div class="form-group">
                <label class="font-normal">ประเภทตัวเลือก</label>
                <select class="form-control select2" id="checklist_type" name="checklist_type"
                    onchange="GetTableChoice()" data-width="100%">
                    <option value="1">ช่องกรอกข้อมูล</option>
                    <option value="2">ตัวเลือก</option>
                    <option value="3">เครื่องหมายเช็ค</option>
                </select>
            </div>
        </div>

        <div id="ShowTable"></div>

    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="SubmitAddChoiceList()"><i
            class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
<script>
    $(".select2").select2();

    function GetTableChoice() {
    let checklist_type = $("#checklist_type").val();
    let checklist_id = $("#checklist_id").val();
    if (checklist_type == '2') {
        $("#ShowTable").show();
        $("#ShowTable").load("ajax/qc_choice/GetTable_choice.php", {
            checklist_id: checklist_id
        });
    } else if (checklist_type == '3') {
        $("#ShowTable").show();
        $("#ShowTable").load("ajax/qc_choice/Get_score.php", {
            checklist_id: checklist_id
        });
    } else {
        $("#ShowTable").hide();
    }
}

    function AddChoice() {
        let checklist_id = $("#checklist_id").val();
        let choice_detail = $("#choice_detail").val();
        if (choice_detail == "") {
            swal({
                title: 'กรุณากรอกข้อมูล',
                text: '',
                type: 'warning',
                showConfirmButton: false,
                timer: 1000
            }, function () {
                swal.close();
                $("#choice_detail").focus();
            });
            return false;
        }
        $.ajax({
            type: "POST",
            url: "ajax/qc_choice/add_choice.php",
            data: {
                checklist_id: checklist_id,
                choice_detail: choice_detail
            },
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    GetTableChoice()
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.result == 9) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }

    function DeleteChoice(choicelist_id) {

        $.ajax({
            type: "POST",
            url: "ajax/qc_choice/delete_choice.php",
            data: {
                choicelist_id: choicelist_id
            },
            dataType: "json",
            success: function (data) {
                if (data.result == 1) {
                    GetTableChoice()
                } else if (data.result == 0) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                } else if (data.result == 9) {
                    swal({
                        title: 'แจ้งเตือน',
                        text: 'ไม่สามารถติดต่อเซิฟเวอร์ได้ กรุณาลองใหม่อีกครั้ง',
                        type: 'warning',
                        showConfirmButton: false,
                        timer: 1500
                    });
                }
            }
        });
    }
</script>