<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];


?>
<div name="div_ax[]" id="div_<?php echo $i; ?>" value="<?php echo $i; ?>">
    <div class="col-lg-12">
        <div class="row">

            <div class="col-md-1">
                <div class="form-group">
                    <button style="width:50px;" type="button" class="btn btn-sm btn-danger" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                </div>
            </div>
            <div class="col-md-2 col-xs-2 col-sm-2">
                <div class="form-group">
                    <input type="text" id="code_<?php echo $i; ?>" name="code[]" class="form-control" placeholder="" autocomplete="off" readonly>
                </div>
            </div>

            <div class="col-mb-4 col-xs-4 col-sm-4">
                <!-- <label>สิ่งที่ต้องการเบิก</label> -->
                <select name="ax[]" id="ax_<?php echo $i; ?>" class="form-control select2" onchange="GetUnit(this.value,'<?php echo $i ?>'),chk(<?php echo $i; ?>);">
                    <option value="x" selected>กรุณาเลือก </option>

                    <?php

                    $sql_sp = "SELECT * FROM tbl_spare_part ;";
                    $rs_sp = mysqli_query($connection, $sql_sp);
                    while ($row_sp = mysqli_fetch_assoc($rs_sp)) {

                    ?>

                        <option value="<?php echo $row_sp['spare_part_id'] ?>">
                            <?php echo $row_sp['spare_part_code']." - ".$row_sp['spare_part_name'] ?></option>


                    <?php } ?>

                </select>
            </div>

            <div class="col-md-2 col-xs-2 col-sm-2">
                <div class="form-group">
                    <input type="text" id="unit_<?php echo $i; ?>" name="unit[]" class="form-control" placeholder="" autocomplete="off" readonly>
                </div>
            </div>

            <div class="col-mb-3 col-xs-3 col-sm-3">
                <!-- <label>จำนวน</label> -->
                <div class="form-group">
                    <input type="text" id="quantity_<?php echo $i; ?>" name="quantity[]" class="form-control" placeholder="" autocomplete="off">
                </div>
            </div>




        </div>
    </div>
</div>