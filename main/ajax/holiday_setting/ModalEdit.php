<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$holiday_id = mysqli_real_escape_string($connect_db,$_POST['holiday_id']);
$sql = "SELECT * FROM tbl_holiday WHERE holiday_id = '$holiday_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

?>

<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title">แก้ไขวันหยุด</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="hidden" id="holiday_id" name="holiday_id"
            value="<?php echo $holiday_id ?>">
        <div class="row">
            <div class="col-6 mb-3">
                <label for="holiday_name">
                    ชื่อวันหยุด
                </label>
                <input type="text" class="form-control mb-3" name="holiday_name" id="holiday_name" value="<?php echo $row['holiday_name'] ?>" >
            </div>
            <div class="col-6 mb-3">
                <label for="holiday_datetime">
                    วันที่หมดอายุ
                </label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input class="form-control datepicker" type="text" id="holiday_datetime" readonly name="holiday_datetime" value="<?php echo date("d-m-Y", strtotime($row['holiday_datetime'])) ?>" autocomplete="off">
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="note">หมายเหตุ</label>
                <textarea class="form-control mb-3" name="note" id="note" rows="10"><?php echo $row['note'] ?></textarea>
            </div>
        </div>
        
        
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>