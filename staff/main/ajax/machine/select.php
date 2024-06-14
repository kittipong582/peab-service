<?php
include ("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);

$sql_model = "SELECT * FROM tbl_product_model WHERE brand_id ='$brand_id'";
$res_model = mysqli_query($connect_db, $sql_model);

?>

<label for="">รุ่น</label>
<select name="model_id" id="model_id" class="form-control select2" onchange="Get_data();">
    <option value="">กรุณาเลือก</option>
    <?php while ($row_model = mysqli_fetch_assoc($res_model)) { ?>
        <option value="<?php echo $row_model['model_id'] ?>">
            <?php echo $row_model['model_name'] ?>
        </option>
    <?php } ?>
</select>
<script>
    $(document).ready(function () {
        $(".select2").select2();
    });
</script>