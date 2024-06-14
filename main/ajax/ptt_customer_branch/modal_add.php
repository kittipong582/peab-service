<?php include('header.php'); ?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="col">
        <div class="form-group">
            <label>ค้นหาจาก</label>
            <select class="form-control select2" id="search_opt" name="search_opt" data-width="100%">
                <option value="1">หมายเลข QR Code</option>
                <option value="2">รหัสสาขา</option>
                <option value="3">ชื่อ ลูกค้า / สาขา</option>
            </select>
        </div>
        <div class="ibox-content">
                <div id="loading_modal_add">
                    <div class="spiner-example">
                        <div class="sk-spinner sk-spinner-wave">
                            <div class="sk-rect1"></div>
                            <div class="sk-rect2"></div>
                            <div class="sk-rect3"></div>
                            <div class="sk-rect4"></div>
                            <div class="sk-rect5"></div>
                        </div>
                    </div>
                </div>
            </div>
        <div id="showData"></div>
    </div>
    </div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" onclick="GetTable()"><i class="fa fa-check"></i>&nbsp;บันทึก</button>
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>
<script>
    $(".select2").select2({
        width: "75%"
    });
    $(document).ready(function() { 
        $("#loading_modal_add").hide();
    });
</script>