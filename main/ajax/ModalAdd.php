<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title">เพิ่มวันหยุด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="holiday_name">
                    ชื่อวันหยุด
                </label>
                <input type="text" class="form-control mb-3" name="holiday_name" id="holiday_name" value="" >
            </div>
            <div class="col-6 mb-3">
                <label for="holiday_datetime">
                    วันหยุดที่
                </label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input class="form-control datepicker" type="text" id="holiday_datetime" readonly name="holiday_datetime" value="" autocomplete="off">
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="note">หมายเหตุ</label>
                <textarea class="form-control mb-3" name="note" id="note" rows="10"></textarea>
            </div>
        </div>
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>