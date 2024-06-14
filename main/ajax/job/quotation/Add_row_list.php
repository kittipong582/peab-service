<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$i = $_POST['rowCount'];

$sql = "SELECT * FROM tbl_quotation_setting WHERE active_status = 1";
$result  = mysqli_query($connect_db, $sql);


?>

<tr name="tr_qs[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty_list('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </td>
    <td><select name="qs_id[]" id="qs_id_<?php echo $i; ?>" style="width: 100%;" class="form-control select2">
            <option value="">กรุณาเลือกบริการ</option>
            <?php while ($row = mysqli_fetch_array($result)) { ?>
                <option value="<?php echo $row['qs_id'] ?>"><?php echo $row['qs_name'] ?></option>

            <?php } ?>
        </select></td>
    <td><input type="text" class="form-control text-right" onchange="Cal_Qs('<?php echo $i; ?>');" name="unit[]" id="unit_<?php echo $i; ?>" value=""></td>
    <td><input type="text" class="form-control text-right" onchange="Cal_Qs('<?php echo $i; ?>');" name="quantity[]" id="quantity_<?php echo $i; ?>"></td>


    <td><input type="text" readonly class="form-control unit_price text-right" name="unit_price[]" id="unit_price_<?php echo $i; ?>" value=""></td>
</tr>