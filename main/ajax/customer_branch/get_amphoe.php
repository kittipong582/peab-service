<?php

include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$ref_province = $_POST['ref_province'];

?>

<label for="">ตำบล/แขวง <font class="text-danger">*</font></label>
<select class="form-control select2" name="province_id" id="province_id" onchange="get_district(this.value);">
    <option value="">โปรดระบุ</option>
    <?php
    $sql_province = "SELECT * FROM tbl_amphoe WHERE ref_province = '$ref_province'  ORDER BY amphoe_name_th ASC";
    $rs_province  = mysqli_query($connection, $sql_province);
    while ($row_province = mysqli_fetch_array($rs_province)) { ?>
        <option value="<?php echo $row_province['amphoe_id']; ?>" ><?php echo $row_province['amphoe_name_th']; ?></option>
    <?php } ?>
</select>