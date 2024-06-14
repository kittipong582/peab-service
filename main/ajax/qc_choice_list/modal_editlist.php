<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$topic_id = mysqli_real_escape_string($connection, $_POST['topic_id']);
$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$score_id = mysqli_real_escape_string($connection, $_POST['score_id']);


$sql = "SELECT * FROM tbl_qc_checklist WHERE topic_id = '$topic_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

$sql_score = "SELECT * FROM tbl_qc_score WHERE checklist_id = '$checklist_id'ORDER BY list_order ASC";
$res_score = mysqli_query($connection, $sql_score);

?>
<style>
    .dragging-over {
        border: 2px dashed #ccc;
        opacity: 0.5;
    }
</style>

<div class="modal-header">
    <h4 class="modal-title">แก้ไข Qc</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-edit" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <input type="hidden" id="topic_id" name="topic_id" value="<?php echo $topic_id ?>">
            <input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $checklist_id ?>">

            <div class="row">
                <div class="col-6">
                    <label class="font-normal">Qc</label>
                    <input type="text" class="form-control" id="checklist_name" name="checklist_name"
                        value="<?php echo $row['checklist_name'] ?>">
                </div>
                <div class="col-6">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description"
                        value="<?php echo $row['description'] ?>">
                </div>
            </div>
        </div>

        <hr>

        <div class="form-group">
            <div id="Show_item">
                <div>
                    <button type="button" class="btn btn-primary add_item_btn" onclick="Add_row()"><i
                            class="fa fa-plus"> เพิ่มรายการ</i>&nbsp;</button>
                </div>
                <br>
                <?php while ($row_score = mysqli_fetch_assoc($res_score)) { ?>
                    <input type="hidden" id="score_id" name="score_id" value="<?php echo $row_score['score_id']; ?>">
                    <div draggable="true" ondragstart="start()" ondragover="dragover()" ondragend="dragend()"
                        class="dragover">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="font-normal">รายการ</label>
                                <input type="text" class="form-control score_name_check" id="score_name" name="score_name[]"
                                    placeholder="" value="<?php echo $row_score['score_name'] ?>">

                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="" id="row_num" value="1">
                                <label class="font-normal">คะแนน</label>
                                <input type="text" class="form-control score_check" id="score" name="score[]" placeholder=""
                                    value="<?php echo $row_score['score'] ?>">
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="invisible">Hidden Label</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-danger">ลบ</button>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Update(<?php echo $topic_id; ?>)"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>


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
        <div draggable="true" ondragstart="start()" ondragover="dragover()" ondragend="dragend()"
                        class="dragover">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="font-normal">รายการ</label>
                                <input type="text" class="form-control score_name_check" id="score_name`+ pointer + `" name="score_name[]">

                            </div>
                            <div class="col-md-2 mb-3">
                                <input type="hidden" name="" id="row_num" value="1">
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
                    </div>
`);

    };
    function start() {
        row = event.target;
        row.classList.add('dragging-over');
    }

    function dragover() {
        var e = event;
        e.preventDefault();

        let children = Array.from(e.target.parentNode.parentNode.children);

        if (children.indexOf(e.target.parentNode) > children.indexOf(row))
            e.target.parentNode.after(row);
        else
            e.target.parentNode.before(row);
        console.log(children)
        row.classList.add('dragging-over');
    }


    function dragend() {
        row.classList.remove('dragging-over');
    }

</script>