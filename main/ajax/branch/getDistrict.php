<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$district = $_POST['amphoe_id'];
?>

<label>เขต/ตำบล</label>
<font color="red">**</font><br>
<select class="form-control select2" name="district" id="district" >

    <option value="all">ทั้งหมด</option>
    <?php $sql_type = "SELECT * FROM tbl_district WHERE ref_amphoe = '$district'";
    $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);

    while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

        <option value="<?php echo $row_type['district_id'] ?>"><?php echo $row_type['district_name_th'] ?></option>

    <?php }  ?>

</select>
