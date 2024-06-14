<?php

include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$ref_amphoe = $_POST['ref_amphoe'];

?>

<label for="">ตำบล/แขวง <font class="text-danger">*</font></label>
<select class="form-control select2" name="district_id" id="district_id" onchange="get_zipcode(this.value)">
    <option value="">โปรดระบุ</option>
    <?php
    $sql_district = "SELECT * FROM tbl_district WHERE ref_amphoe = '$ref_amphoe'  ORDER BY district_name_th ASC";
    $rs_district  = mysqli_query($connection, $sql_district);
    while ($row_district = mysqli_fetch_array($rs_district)) { ?>
        <option value="<?php echo $row_district['district_id']; ?>"><?php echo $row_district['district_name_th']; ?></option>
    <?php } ?>
</select>