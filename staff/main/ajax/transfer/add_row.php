<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$branch_id = $_POST['branch_id'];
$sql_sp = "SELECT a.*,b.spare_part_name FROM tbl_branch_stock a 
JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
WHERE a.branch_id = '$branch_id';";
$rs_sp = mysqli_query($connection, $sql_sp);

?>

<tr name="tr_CM[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <td>
        <button style="width:50px;" type="button" class="btn btn-sm btn-danger" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>

    </td>
    <td>
        <input type="text" id="code_<?php echo $i; ?>" name="code[]" class="form-control" placeholder="" autocomplete="off" readonly>
    </td>
    <td>
        <select name="ax[]" id="ax_<?php echo $i; ?>" class="form-control select2" onchange="GetRemain(this.value,'<?php echo $i ?>'),chk(<?php echo $i; ?>),GetUnit(this.value,'<?php echo $i ?>');" data-width="100%">
            <option value="x" selected>กรุณาเลือก </option>

            <?php

            while ($row_sp = mysqli_fetch_assoc($rs_sp)) {

            ?>

                <option value="<?php echo $row_sp['spare_part_id'] ?>">
                    <?php echo $row_sp['spare_part_name'] ?></option>


            <?php } ?>

        </select>
    </td>
    <td>
        <input type="text" id="unit_<?php echo $i; ?>" name="unit[]" class="form-control" placeholder="" autocomplete="off" readonly>
    </td>
    <td>
        <input type="text" id="remain_<?php echo $i; ?>" name="remain[]" class="form-control form-remain" placeholder="" autocomplete="off" readonly>
    </td>
    <td>
        <input type="text" id="quantity_<?php echo $i; ?>" name="quantity[]" class="form-control form-quantity" placeholder="" autocomplete="off" onchange="check_stock('<?php echo $i ?>');">
    </td>
</tr>