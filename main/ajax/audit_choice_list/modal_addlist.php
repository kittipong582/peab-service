<?php
include("../../../config/main_function.php");

$topic_id  = $_POST['topic_id'];
?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่มหัวข้อรายการ</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <input type="text" hidden  class="form-control" value="<?php echo $topic_id ?>" id="topic_id "
                name="topic_id ">
            <div class="row">
                <div class="col-6">
                    <label class="font-normal">หัวข้อ</label>
                    <input type="text" class="form-control" id="checklist_name" name="checklist_name" placeholder="">
                </div>
                <div class="col-6">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="">
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
        <!-- <input type="text" hidden  class="form-control" value="<//?php echo $topic_id ?>" id="topic_id "
                name="topic_id "> -->
            <div>
                <button type="button" class="btn btn-primary add_item_btn" onclick="Add_row()"><i class="fa fa-plus">
                        เพิ่มรายการ</i>&nbsp;</button>
            </div><br>
            <div id="Show_item">

                <div class="row">
                    <div class="col-md-8 mb-3">
                        <label class="font-normal">รายการ</label>
                        <input type="text" class="form-control score_name_check" id="score_name" name="score_name[]"
                            placeholder="">
                    </div>
                    <input type="hidden" name="" id="row_num" value="1">
                    <div class="col-md-2 mb-3">
                        <label class="font-normal">คะแนน</label>
                        <input type="text" class="form-control score_check" id="score_1" name="score[]" placeholder="">
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitChoice(<?php echo $topic_id; ?>)"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>


<!-- <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitChoice()"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div> -->
<!-- </div> -->

<?php include("import_script.php") ?>
<script>
    $(document).ready(function () {

        $("#Show_item").on("click", ".btn-danger", function (e) {
            e.preventDefault();

            $(this).closest('.row').remove();
        });



    })
    function Add_row() {
        console.log($(this).index())
        var value_score = $('#row_num').val();
        let pointer = parseFloat(value_score) + 1;
        $('#row_num').val(pointer);

        $("#Show_item").append(`
            <div class="row" draggable="true" ondragstart="start()"  ondragover="dragover()" >
                <div class="col-md-8 mb-3">
                    <label class="font-normal">รายการ</label>
                    <input type="text" class="form-control score_name_check" id="score_name_`+ pointer + `" name="score_name[]" placeholder="">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="font-normal">คะแนน</label>
                    <input type="text" class="form-control score_check" id="score`+ pointer + `" name="score[]" placeholder="">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="invisible">Hidden Label</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-danger">ลบ</button>
                    </div>
                </div>
            </div>
        `);
        // $('#row_num').val(pointer);
    };




</script>