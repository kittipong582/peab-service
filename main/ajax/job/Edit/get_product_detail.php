<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_branch_id = $_POST['customer_branch_id'];

///////////////////product id branch /////////////////////
$sql_product = "SELECT * FROM tbl_product WHERE current_branch_id = '$customer_branch_id'";
$result_product  = mysqli_query($connect_db, $sql_product);

?>


<label>เครื่อง</label><br>
<select id="product_select" name="product_select" style="width: 35%;" class="form-control select2" onchange="Get_detailProduct(this.value)">

    <option value="">เลือกเครื่อง</option>
    <?php while ($row_product = mysqli_fetch_array($result_product)) {



        $brand_id = $row['brand_id'];
        $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '{$row_product['brand_id']}'";
        $result_brand  = mysqli_query($connect_db, $sql_brand);
        $row_brand = mysqli_fetch_array($result_brand);

        $model_id = $row['model_id'];
        $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '{$row_product['model_id']}'";
        $result_model  = mysqli_query($connect_db, $sql_model);
        $row_model = mysqli_fetch_array($result_model);
    ?>

        <option value="<?php echo $row_product['product_id'] ?>"><?php echo "[" . $row_product['serial_no'] . "] - <b>ยี่ห้อ:</b> " . $row_brand['brand_name'] . " - <b>รุ่น:</b> " . $row_model['model_name'] ?></option>

    <?php  } ?>

</select>