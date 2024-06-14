<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$brand_id = $_POST['brand_id']
?>

<label>โมเดล</label>
<select class="form-control select2 mb-3 " style="width: 100%;" name="search_model" id="search_model">
    <option value="">เลือกโมเดล</option>
    <?php $sql_brand = "SELECT * FROM tbl_product_model WHERE brand_id = '$brand_id' AND active_status = '1'";
    $result_brand  = mysqli_query($connect_db, $sql_brand);
    while ($row_brand = mysqli_fetch_array($result_brand)) { ?>

        <option value="<?php echo $row_brand['model_id'] ?>"><?php echo $row_brand['model_name'] ?></option>
    <?php } ?>
</select>