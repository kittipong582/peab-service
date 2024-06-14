<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$branch_id = $_POST['branch_id'];

?>
<tr name="div_ax[]" id="div_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <td>
        <button style="width:50px;" type="button" class="btn btn-sm btn-danger" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>

    </td>
    <td>
        <select name="ax[]" id="ax_<?php echo $i; ?>" class="form-control select2" onchange="GetRemain(this.value,'<?php echo $i ?>'),chk(<?php echo $i; ?>);">
            <option value="x" selected>กรุณาเลือก </option>

            <?php

            $sql_sp = "SELECT a.*,b.spare_part_name,b.spare_part_code FROM tbl_branch_stock a 
                    JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                    WHERE a.branch_id = '$branch_id'  ;";
            $rs_sp = mysqli_query($connection, $sql_sp);
            while ($row_sp = mysqli_fetch_assoc($rs_sp)) {

            ?>

                <option value="<?php echo $row_sp['spare_part_id'] ?>">
                    <?php echo "[ " . $row_sp['spare_part_code'] . " ]  " . $row_sp['spare_part_name'] ?></option>


            <?php } ?>

        </select>
    </td>
    <td>
        <div class="form-group">
            <input type="text" id="remain_<?php echo $i; ?>" name="remain[]" class="form-control form-remain" placeholder="" autocomplete="off" readonly>
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" id="quantity_<?php echo $i; ?>" name="quantity[]" class="form-control form-quantity" placeholder="" autocomplete="off" onchange="check_stock('<?php echo $i ?>');">
        </div>
    </td>
    <td>
        <div class="form-group">
            <input type="text" id="note_<?php echo $i; ?>" name="note[]" class="form-control form-note" placeholder="" autocomplete="off">
        </div>
    </td>
</tr>

