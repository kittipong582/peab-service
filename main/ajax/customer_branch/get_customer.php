<?php
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$search_type = $_POST['search_type'];
$search_text = $_POST['search_text'];

$con = '';
if ($search_type == 1) {
    $con = "AND customer_name LIKE '%$search_text%'";
} else if ($search_type == 2) {

    $con = "AND customer_code LIKE '%$search_text%'";
}

$sql_customer = "SELECT * FROM tbl_customer WHERE active_status = 1 $con";
$rs_customer  = mysqli_query($connection, $sql_customer);

?>

<label>ลูกค้า</label>
<select class="form-control select2" id="customer_id" name="customer_id">
    <option value="">กรุณาเลือก</option>
    <?php while ($row_customer = mysqli_fetch_array($rs_customer)) {
    ?>
        <option value="<?php echo $row_customer['customer_id']; ?>"><?php echo $row_customer['customer_code'] . " " . $row_customer['customer_name'] ?></option>

    <?php } ?>
</select>