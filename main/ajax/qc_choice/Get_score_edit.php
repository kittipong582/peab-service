<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

// $checklist_id  = $_POST['checklist_id'];
$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$sql = "SELECT * FROM tbl_qc_score WHERE checklist_id = '$checklist_id' ORDER BY list_order ASC";
$res = mysqli_query($connection, $sql);


?>



<input type="text" hidden class="form-control" value="<?php echo $checklist_id ?>" id="checklist_id ">

<div class="form-group">
    <div>
        <button type="button" class="btn btn-primary add_item_btn" onclick="Add_row()"><i class="fa fa-plus">
                เพิ่มรายการ</i>&nbsp;</button>
    </div><br>
    <div id="Show_item">
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <div class="row">
                <div class="col-md-8 mb-3">
                    <label class="font-normal">รายการ</label>
                    <input type="text" class="form-control score_name_check" id="score_name" name="score_name[]"
                        value="<?php echo $row['score_name'] ?>">
                </div>
                <input type="hidden" name="" id="row_num" value="1">
                <div class="col-md-2 mb-3">
                    <label class="font-normal">คะแนน</label>
                    <input type="text" class="form-control score_check" id="score_1" name="score[]"
                        value="<?php echo $row['score'] ?>">
                </div>
                <div class="col-md-2 mb-3">
                    <label class="invisible">Hidden Label</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-danger">ลบ</button>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>


<?php include ("import_script.php") ?>
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