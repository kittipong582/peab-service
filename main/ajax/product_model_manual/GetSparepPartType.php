<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$spare_type_id = mysqli_real_escape_string($connect_db, $_POST['spare_type']);

$sql_part = "SELECT * FROM tbl_spare_part WHERE spare_type_id = '$spare_type_id'";
$res_part = mysqli_query($connect_db, $sql_part);

?>
<label for="">ชื่ออะไหล่</label>
<select name="spare_part_id" id="spare_part_id" class="form-select" style="width: 100%;" >
    <?php while ($row_part = mysqli_fetch_assoc($res_part)) { ?>
        <option value="<?php echo $row_part['spare_part_id']; ?>"><?php echo $row_part['spare_part_name']; ?></option>
    <?php } ?>
</select>