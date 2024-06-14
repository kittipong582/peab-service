<?php
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$start_date = $_POST['start_date'];
$start_date = explode('/', $start_date);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = $_POST['end_date'];
$end_date = explode('/', $end_date);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));

////////////////////////////product//////////////////////
$sql_product = "SELECT a.product_id,a.serial_no,b.brand_name,c.model_name FROM tbl_product a
    LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
    LEFT JOIN tbl_product_model c ON a.model_id = c.model_id 
    LEFT JOIN tbl_job d ON a.product_id = d.product_id
    WHERE d.appointment_date BETWEEN '$start_date' and '$end_date' ORDER BY serial_no";
$rs_product = mysqli_query($connection, $sql_product);

?>

<div class="form-group">
    <label>เครื่อง</label>
    <select class="form-control select2" id="product_select" name="product_select" data-width="100%">
        <option value="x" selected>ทั้งหมด</option>
        <?php while ($row_product = mysqli_fetch_array($rs_product)) { ?>

            <option value="<?php echo $row_product['product_id']; ?>"><?php echo "[ " . $row_product['serial_no'] . " ] " . $row_product['brand_name'] . " - " . $row_product['model_name'] ?></option>

        <?php } ?>

    </select>
</div>