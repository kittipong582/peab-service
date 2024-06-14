<?php
include("../../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];

$sql = "SELECT * FROM tbl_overhaul WHERE current_customer_branch_id IS NULL AND current_branch_id = '$branch_id' and active_status = 1";
$result  = mysqli_query($connect_db, $sql);

// echo $sql;
?>

<label>เครื่องทดแทน</label>

<select id="overhaul_id" name="overhaul_id" onchange="select_overhaul(this.value)" class="form-control select2 mb-3">
    <option value="">กรุณาเลือกเครื่อง</option>
    <?php while ($row = mysqli_fetch_array($result)) {


        $brand_id = $row['brand_id'];
        $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
        $result_brand  = mysqli_query($connect_db, $sql_brand);
        $row_brand = mysqli_fetch_array($result_brand);

        $model_id = $row['model_id'];
        $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
        $result_model  = mysqli_query($connect_db, $sql_model);
        $row_model = mysqli_fetch_array($result_model); ?>
        <option value="<?php echo $row['overhaul_id'] ?>"><?php echo $row['serial_no'] . " - " . $row_brand['brand_name'] . " - " . $row_model['model_name'] ?></option>
    <?php } ?>
</select>