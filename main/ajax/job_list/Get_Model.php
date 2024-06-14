<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$brand_id = mysqli_real_escape_string($connect_db, $_POST['brand_id']);
if ($brand_id != 'x') {
    $sql_model = "SELECT * FROM tbl_product_model WHERE brand_id = '$brand_id' AND active_status = 1";
    $res_model = mysqli_query($connect_db, $sql_model);
?>
    <option value="x">ทั้งหมด</option>
    <?php
    while ($row_model = mysqli_fetch_assoc($res_model)) { ?>

        <option value="<?php echo $row_model['model_id'] ?>"><?php echo $row_model['model_name'] ?></option>

    <?php }
} else { ?>
    <option value="x">ทั้งหมด</option>
<?php } ?>