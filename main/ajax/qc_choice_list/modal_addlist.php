<?php
include("../../../config/main_function.php");

$topic_id  = $_POST['topic_id'];
?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม Qc</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <div class="form-group">
        <input type="text" hidden class="form-control" value="<?php echo $topic_id ?>" id="topic_id "
                name="topic_id ">
            <div class="row">
                <div class="col-5">
                    <label class="font-normal">Qc</label>
                    <input type="text" class="form-control" id="checklist_name" name="checklist_name" placeholder="">
                </div>
                <div class="col-5">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description" placeholder="">
                </div>
                <div class="col-2">
                    <label class="font-normal">เลือก</label>
                    <select class="select2 w-100" name="checklist_type" id="checklist_type">
                    <option value="x">กรุณาเลือก</option>
                        <option value="1">CheckBox</option>
                        <option value="2">Dropdown</option>
                    </select>
                </div>
            </div>
        </div>

       
<div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitChoice('<?php echo $topic_id ?>')"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div> 
</div>
       
</div>




<?php include("import_script.php") ?>
<script>
   
</script>