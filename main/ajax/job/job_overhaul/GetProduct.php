<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];

$sql = "SELECT * FROM tbl_product WHERE current_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);

?>

<label>เครื่องลูกค้า</label>
<font color="red">**</font>
<select id="" name="" onchange="getproduct_detail(this.value)" class="form-control select2 mb-3">
    <option value="">กรุณาเลือกเครื่อง</option>
    <?php while ($row = mysqli_fetch_array($result)) {

        if ($row['product_type'] == 1) {
            $product_type = 'เครื่องชง';
        } else if ($row['product_type'] == 2) {
            $product_type = 'เครื่องบด';
        } else if ($row['product_type'] == 3) {
            $product_type = 'เครื่องปั่น';
        }

        $brand_id = $row['brand_id'];
        $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
        $result_brand  = mysqli_query($connect_db, $sql_brand);
        $row_brand = mysqli_fetch_array($result_brand);

        $model_id = $row['model_id'];
        $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
        $result_model  = mysqli_query($connect_db, $sql_model);
        $row_model = mysqli_fetch_array($result_model); ?>
        <option value="<?php echo $row['product_id'] ?>"><?php echo "[".$row['serial_no'] . "] - " . $row_brand['brand_name'] . " รุ่น " . $row_model['model_name'] ?></option>
    <?php } ?>
</select>