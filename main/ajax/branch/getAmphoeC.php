<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$province_id = $_POST['province_id'];

?>

<label>แขวง/อำเภอ</label>
<font color="red">**</font><br>
<select class="form-control select2" name="amphoe" id="amphoe" onchange="GetDistrict(this.value)">

    <option value="all">ทั้งหมด</option>
    <?php $sql_type = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id'";
    $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
    while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

        <option value="<?php echo $row_type['amphoe_id'] ?>" ><?php echo $row_type['amphoe_name_th'] ?></option>

    <?php } ?>


</select>