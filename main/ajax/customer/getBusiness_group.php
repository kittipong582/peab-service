<?php
include('../../../config/main_function.php');
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);


$sql = "SELECT * FROM tbl_business_group WHERE active_status = 1";
$rs = mysqli_query($connection, $sql) or die($connection->error);

$type_value = $_POST['type_value'];
$customer_id = $_POST['customer_id'];
$sql_type = "SELECT business_group_id FROM tbl_customer WHERE customer_id = '$customer_id'";
$rs_type = mysqli_query($connection, $sql_type);
$row_type = mysqli_fetch_row($rs_typ);

$con_selected = "";
?>

<label>กลุ่มธุรกิจ</label>
<select class="form-control select2" id="business_group" name="business_group">
    <option value="">กรุณาเลือก</option>
    <?php while ($row = mysqli_fetch_array($rs)) { ?>
        <option value="<?php echo $row['group_id'] ?>" <?php if ($row_type['business_group_id'] == $row['group_id']) {
                                                            echo "SELECTED";
                                                        } ?>><?php echo $row['group_name'] ?></option>
    <?php } ?>

</select>