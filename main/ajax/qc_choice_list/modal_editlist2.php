<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$checklist_id = mysqli_real_escape_string($connection, $_POST['checklist_id']);
$score_id = mysqli_real_escape_string($connection, $_POST['score_id']);

$sql = "SELECT * FROM tbl_audit_checklist WHERE checklist_id = '$checklist_id'";
$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);

$sql_score = "SELECT * FROM tbl_audit_score WHERE checklist_id = '$checklist_id'";
$res_score = mysqli_query($connection, $sql_score);

?>
<div class="modal-header">
    <h4 class="modal-title">แก้ไขหัวข้อรายการ</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-edit" method="POST" enctype="multipart/form-data">
        <input type="hidden" id="checklist_id" name="checklist_id" value="<?php echo $checklist_id ?>">
        <input type="hidden" id="score_id" name="score_id" value="<?php echo $score_id ?>">
        <div class="form-group">
            <div class="row">
                <div class="col-6">
                    <label class="font-normal">หัวข้อ</label>
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
               
                  
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-12" id="news_content_<?php echo $row["list_order"]; ?>">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <i class="fa fa-file-video-o"></i> วิดิโอ (Internal)
                                       
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <video style="max-height:500px;" controls>
                                                    <source src="../../image/<?php echo $row["content_video"]; ?>"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6 col-md-6 col-sm-12" id="news_content_<?php echo $row["list_order"]; ?>">
                                <div class="panel panel-info">
                                    <div class="panel-heading">
                                        <i class="fa fa-file-video-o"></i> วิดิโอ (Internal)
                                        
                                    </div>
                                    <div class="panel-body">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-12">
                                                <video style="max-height:500px;" controls>
                                                    <source src="../../image/<?php echo $row["content_video"]; ?>"
                                                        type="video/mp4">
                                                </video>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-2 mb-3">
                                <label class="invisible">Hidden Label</label>
                                <div class="input-group">
                                    <button type="button" class="btn btn-danger">ลบ</button>
                                </div>
                            </div>
                        </div>
                  
               
            </div>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="Update()"><i
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
        <div id="checklist_content_<?php echo $row["list_order"]; ?>"controls>
    <div class="row">
        <div class="col-md-8 mb-3>
            <label class="font-normal">รายการ</label>
            <input type="text" class="form-control score_name_check" id="score_name_`+ pointer + `" name="score_name[]" placeholder="">
        </div>
        <div class="col-md-2 mb-3">
            <label class="font-normal">คะแนน</label>
            <input type="text" class="form-control score_check" id="score_`+ pointer + `" name="score[]" placeholder="">
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
        // $('#row_num').val(pointer);
    };


</script>