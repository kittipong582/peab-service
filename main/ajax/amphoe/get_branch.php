<?php

include('../../../config/main_function.php');

$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$province_id = $_POST['province_id'];

// /////////////////////จำนวนไว้เช็ค1
// $sql_num_amphoe = "SELECT COUNT(amphoe_id) As amphoe_num FROM tbl_amphoe WHERE ref_province = '$province_id'";
// $rs_num_amphoe = mysqli_query($connection, $sql_num_amphoe) or die($connection->error);
// $row_num_amphoe = mysqli_fetch_assoc($rs_num_amphoe);

//////////////////////จำนวนไว้เช็ค2

$array_data = [];
$sql_amphoe = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id'";
$rs_amphoe = mysqli_query($connection, $sql_amphoe) or die($connection->error);
while ($row_amphoe = mysqli_fetch_assoc($rs_amphoe)) {

    $amphoe_id = $row_amphoe['amphoe_id'];

    $sql_num = "SELECT * FROM tbl_branch_care
        WHERE amphoe_id = '$amphoe_id'";
    $rs_num = mysqli_query($connection, $sql_num) or die($connection->error);
    $row_num = mysqli_fetch_assoc($rs_num);

    array_push($array_data, $row_num['branch_id']);
}

$num_array = array_unique($array_data);

///////////////////ถ้าจำนวนเช็ค1กับ2เท่ากัน
if (count($num_array) == 1) {

    $sql_amphoe = "SELECT * FROM tbl_amphoe WHERE ref_province = '$province_id'";
    $rs_amphoe = mysqli_query($connection, $sql_amphoe) or die($connection->error);
    $row_amphoe = mysqli_fetch_assoc($rs_amphoe);
    $amphoe_id = $row_amphoe['amphoe_id'];

    $sql_check = "SELECT * FROM tbl_branch_care
    WHERE amphoe_id = '$amphoe_id'";
    $rs_check = mysqli_query($connection, $sql_check) or die($connection->error);
    $row_check = mysqli_fetch_assoc($rs_check);

    $check = $row_check['branch_id']; //////////////////////ไว้เช็ค selected ตรงสาขา
} else {
    $check = ''; //////////////////////ไว้เช็ค selected ตรงสาขา
}

?>

<label>สาขา</label>
<select class="form-control select2" name="branch_province" id="branch_province" onchange="save_amphoe(this.value)">

    <option value="">- - -</option>
    <?php $sql_type = "SELECT * FROM tbl_branch ORDER BY active_status = 1";
    $rs_type = mysqli_query($connection, $sql_type) or die($connection->error);
    while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>

        <option value="<?php echo $row_type['branch_id'] ?>" <?php if ($row_type['branch_id'] ==  $check) {
                                                                    echo 'SELECTED';
                                                                } ?>><?php echo $row_type['branch_name'] ?></option>

    <?php } ?>


</select>