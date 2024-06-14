<?php

include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_part_id = getRandomID(10, 'tbl_spare_part', 'spare_part_id');
$sql = "SELECT * FROM tbl_spare_type WHERE active_status = '1' ORDER BY spare_type_name ASC";
$result  = mysqli_query($connect_db, $sql);
?>

<form action="" method="post" id="form-add" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เพิ่มอะไหล่</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <input type="text" hidden name="spare_part_id" value="<?php echo $spare_part_id; ?>">
        <div class="text-center mb-3">
            <label for="spare_part_image">
                รูปอะไหล่
                <p><img src="upload/No-Image.png" id="show_file" class="w-50"></p>
            </label>
            <input type="file" hidden name="spare_part_image" id="spare_part_image" onchange="ImageReadURL(this,value,'#show_file','upload/No-Image.png');">
        </div>
        <label for="spare_type_id">
            ประเภทอะไหล่ <font class="text-danger">*</font>
        </label>
        <select class="form-control mb-3 select2" style="width: 100%;" name="spare_type_id" id="spare_type_id">
            <option value="">กรุณาเลือก</option>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <option value="<?php echo $row['spare_type_id']; ?>"><?php echo $row['spare_type_name']; ?></option>
            <?php } ?>
        </select>
        <label for="spare_part_name">
            ชื่ออะไหล่ <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_name" name="spare_part_name">
        <label for="spare_part_code">
            บาร์โค้ดอะไหล่ 
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_barcode" name="spare_part_barcode">
        <label for="spare_part_makker">
            Makker Code 
        </label>
        <input type="text" class="form-control mb-3" id="makker_code" name="makker_code">
        <label for="spare_part_code">
            รหัสอะไหล่ <font class="text-danger">*</font>
            <font class="text-danger" style="display: none;" id="alert_code">ไม่สามารถใช้งานรหัสนี้ได้</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_code" name="spare_part_code" onchange="checkSpareCode('<?php echo $spare_part_id; ?>',value)">
        <input type="text" id="check_code" value="0" hidden>
        <label for="spare_part_unit">
            หน่วยนับอะไหล่ <font class="text-danger">*</font>
        </label>
        <input type="text" class="form-control mb-3" id="spare_part_unit" name="spare_part_unit">
        <label for="default_cost">
            ราคาขาย <font class="text-danger">*</font>
        </label>
        <input type="number" class="form-control mb-3" id="default_cost" name="default_cost">

        <label for="manufacturer">
            ผู้ผลิต 
        </label>
        <input type="text" class="form-control mb-3" id="manufacturer" name="manufacturer">
        <label for="spare_part_des">
            คำอธิบาย
        </label>
        <textarea rows="3" class="form-control mb-3" id="spare_part_des" name="spare_part_des"></textarea>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
    </div>
</form>

<!-- <?php include('import_script.php'); ?>

<script>
    $(document).ready(function() {

        $(".select2").select2({});
    });
</script> -->