<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$spare_part_id = mysqli_real_escape_string($connect_db, $_POST['spare_part_id']);

$sql = "SELECT * FROM tbl_spare_part WHERE spare_part_id = '$spare_part_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$spare_part_image = ($row['spare_part_image'] != "") ? $row['spare_part_image'] : 'No-Image.png';

$sql_type = "SELECT * FROM tbl_spare_type WHERE active_status = '1' ORDER BY spare_type_name ASC";
$result_type  = mysqli_query($connect_db, $sql_type);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <input type="text" hidden id="spare_part_id" name="spare_part_id" value="<?php echo $spare_part_id; ?>">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">แก้ไขอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="text-center mb-3">
            <label for="spare_part_image">
                รูปอะไหล่
                <p><img src="upload/<?php echo $spare_part_image; ?>" id="show_file" class="w-50"></p>
            </label>
            <input type="file" hidden name="spare_part_image" id="spare_part_image" onchange="ImageReadURL(this,value,'#show_file','upload/<?php echo $spare_part_image; ?>');">
        </div>
        <label for="spare_type_id">
            ประเภทอะไหล่ <font class="text-danger">*</font>
        </label>
        <select class="form-control mb-3" name="spare_type_id" id="spare_type_id">
            <?php while ($row_type = mysqli_fetch_array($result_type)) { ?>
                <option value="<?php echo $row_type['spare_type_id']; ?>" <?php echo ($row_type['spare_type_id'] == $row['spare_type_id']) ? 'selected' : ''; ?>><?php echo $row_type['spare_type_name']; ?></option>
            <?php } ?>
        </select>
        <label for="spare_part_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_name" name="spare_part_name" value="<?php echo $row['spare_part_name']; ?>">
        <label for="spare_part_code">
            บาร์โค้ดอะไหล่ <font class="text-danger">*</font>
            <font class="text-danger" style="display: none;" id="alert_code">ไม่สามารถใช้งานรหัสนี้ได้</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_barcode" value="<?php echo $row['spare_barcode']; ?>" name="spare_part_barcode">
        <label for="spare_part_makker">
            Makker Code <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="makker_code" name="makker_code" value="<?php echo $row['makker_code']; ?>">
        <label for="spare_part_code">
            รหัสอะไหล่ <font class="text-danger">*</font>
            <font class="text-danger" style="display: none;" id="alert_code">ไม่สามารถใช้งานรหัสนี้ได้</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_code" name="spare_part_code" value="<?php echo $row['spare_part_code']; ?>" onchange="checkSpareCode('<?php echo $spare_part_id; ?>',value)">
        <input type="text" id="check_code" value="1" hidden>
        <label for="spare_part_unit">
            หน่วยนับอะไหล่ <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_unit" name="spare_part_unit" value="<?php echo $row['spare_part_unit']; ?>">
        <label for="default_cost">
            ราคาทั่วไป <font class="text-danger">*</font>
        </label>
        <input type="number" class="form-control mb-3" id="default_cost" name="default_cost" value="<?php echo $row['default_cost']; ?>">
        <label for="manufacturer">
            ผู้ผลิต <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="manufacturer" name="manufacturer" value="<?php echo $row['manufacturer']; ?>">
        <label for="spare_part_unit">
            คำอธิบาย
        </label>
        <textarea rows="3" class="form-control mb-3" id="spare_part_des" name="spare_part_des"><?php echo $row['spare_part_des']; ?></textarea>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Update();">บันทึก</button>
    </div>
</form>