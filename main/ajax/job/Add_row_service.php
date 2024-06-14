<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];

$sql = "SELECT * FROM tbl_income_type WHERE active_status = 1";
$result  = mysqli_query($connection, $sql);

?>


<tr name="tr_CM[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </td>
    <td><select name="job_service[]" id="job_service_<?php echo $i; ?>" style="width: 100%;" class="form-control select2" onchange="select_Service(this.value,'<?php echo $i ?>');">
            <option value="">กรุณาเลือกบริการ</option>
            <?php while ($row = mysqli_fetch_array($result)) { ?>

                <option value="<?php echo $row['income_type_id'] ?>"><?php echo "[".$row['income_code']."] - ".$row['income_type_name'] ?></option>
            <?php } ?>
        </select></td>
    <td><input type="text" class="form-control" onchange="Cal(this.value,'<?php echo $i; ?>');" name="quantity[]" id="quantity_<?php echo $i; ?>"></td>
    <td><input type="text" readonly class="form-control" name="unit[]" id="unit_<?php echo $i; ?>" value=""></td>
    <td><input type="text" readonly class="form-control" name="unit_cost[]" id="unit_cost_<?php echo $i; ?>" value=""></td>
    <td><input type="text" readonly class="form-control" name="unit_price[]" id="unit_price_<?php echo $i; ?>" value=""></td>
</tr>