<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$tab = $_POST['tab'];

$sql = "SELECT * FROM tbl_income_type WHERE active_status = 1";
$result  = mysqli_query($connection, $sql);

?>
<tr name="tr_CM[]" id="tr_<?php echo $i; ?>_tab_<?php echo $tab; ?>" value="<?php echo $i; ?>">
    <td>
        <button type="button" class="btn btn-danger btn-block" name="button" onclick="destyTab('<?php echo $i; ?>','<?php echo $tab; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </td>
    <td>
        <select name="job_service_tab_<?php echo $tab; ?>[]" id="job_service_<?php echo $i; ?>_tab_<?php echo $tab; ?>" style="width: 100%;" class="form-control select2" onchange="select_ServiceTab(this.value,'<?php echo $i ?>','<?php echo $tab ?>');">
            <option value="">กรุณาเลือกบริการ</option>
            <?php while ($row = mysqli_fetch_array($result)) { ?>

                <option value="<?php echo $row['income_type_id'] ?>"><?php echo "[" . $row['income_code'] . "] - " . $row['income_type_name'] ?></option>
            <?php } ?>
        </select>
    </td>
    <td><input type="text" class="form-control" onchange="CalTab(this.value,'<?php echo $i; ?>','<?php echo $tab; ?>');" name="quantity_tab_<?php echo $tab; ?>[]" id="quantity_<?php echo $i; ?>_tab_<?php echo $tab; ?>"></td>
    <td><input type="text" readonly class="form-control" name="unit_tab_<?php echo $tab; ?>[]" id="unit_<?php echo $i; ?>_tab_<?php echo $tab; ?>" value=""></td>
    <td><input type="text" readonly class="form-control" name="unit_cost_tab_<?php echo $tab; ?>[]" id="unit_cost_<?php echo $i; ?>_tab_<?php echo $tab; ?>" value=""></td>
    <td><input type="text" readonly class="form-control" name="unit_price_tab_<?php echo $tab; ?>[]" id="unit_price_<?php echo $i; ?>_tab_<?php echo $tab; ?>" value=""></td>
</tr>