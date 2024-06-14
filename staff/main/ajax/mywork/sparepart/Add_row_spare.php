<?php
session_start();
include("../../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$job_id = $_POST['job_id'];

$sql = "SELECT * FROM tbl_job a 
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
LEFT JOIN tbl_user_stock c ON b.user_id = c.user_id
LEFT JOIN tbl_spare_part d ON c.spare_part_id = d.spare_part_id
WHERE a.job_id = '$job_id'";



$sql_wtt = "SELECT * FROM tbl_warranty_type WHERE active_status = 1";
$result_wtt  = mysqli_query($connection, $sql_wtt);
?>


<tr name="tr_CM[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <input type="hidden" id="spare_used_id_<?php echo $i; ?>" name="spare_used_id[]" value="<?php echo getRandomID(5, 'tbl_job_spare_used', 'spare_used_id'); ?>">
    <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </td>
    <td>

        <select class='form-control select2' name='insurance_status[]' id='insurance_status_<?php echo $i; ?>'>
        <?php while ($row_wtt = mysqli_fetch_array($result_wtt)) { ?>
                <option value='<?php echo $row_wtt['warranty_type_id'] ?>'><?php echo $row_wtt['warranty_type_name'] ?></option>

            <?php } ?>
        </select>
        <!-- <input class="icheckbox_square-green" type="checkbox" name="chkbox[]" id="chkbox_<?php echo $i; ?>" value="chkbox">

        <input type="hidden" id="insurance_status_<?php echo $i; ?>" name="insurance_status[]" value="0" style="position: absolute; opacity: 0;"> -->
    </td>
    <td>
        <select name="spare_part[]" id="spare_part_<?php echo $i; ?>" style="width:50%;" onchange="select_part(this.value,'<?php echo $i ?>');" class="form-control select2 spare_part">
            <option value="">กรุณาเลือกอะไหล่</option>
            <?php $result  = mysqli_query($connection, $sql);
            while ($row = mysqli_fetch_array($result)) { ?>
                <option value="<?php echo $row['spare_part_id']; ?>"><?php echo $row['spare_part_name']; ?></option>
            <? } ?>
        </select>
    </td>
    <td>
        <input type="text" class="form-control Onhand" readonly name="Onhand[]" id="Onhand_<?php echo $i; ?>" value="">
    </td>
    <td>
        <input type="text" class="form-control quantity" name="quantity[]" id="quantity_<?php echo $i; ?>" value="">
    </td>
    <input type="hidden" class="form-control" readonly name="cost[]" id="cost_<?php echo $i; ?>" value="">
</tr>