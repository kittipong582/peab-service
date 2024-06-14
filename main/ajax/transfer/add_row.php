<?php
session_start();
include("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$i = $_POST['rowCount'];
$from_branch = $_POST['from_branch'];


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

            <div class="col-mb-3 col-xs-3 col-sm-3" id="get_stock">
                <!-- <label>สิ่งที่ต้องการเบิก</label> -->
                <select name="ax[]" id="ax_<?php echo $i; ?>" class="form-control select2" onchange="GetRemain(this.value,'<?php echo $i ?>'),chk(<?php echo $i; ?>),GetUnit(this.value,'<?php echo $i ?>');">
                    <option value="x" selected>กรุณาเลือก </option>

                    <?php

                    $sql_sp = "SELECT a.*,b.spare_part_name,b.spare_part_code FROM tbl_branch_stock a 
                    JOIN tbl_spare_part b ON a.spare_part_id = b.spare_part_id 
                    WHERE a.branch_id = '$from_branch'  ;";
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

            <!-- <div class="col-md-1 col-xs-1 col-sm-1">
            </div> -->

            <div class="col-mb-2 col-xs-2 col-sm-2">
                <!-- <label>จำนวนคงเหลือ</label> -->
                <div class="form-group">
                    <input type="text" id="remain_<?php echo $i; ?>" name="remain[]" class="form-control form-remain" placeholder="" autocomplete="off" readonly>
                </div>
            </div>

            <div class="col-mb-2 col-xs-2 col-sm-2">
                <!-- <label>จำนวน</label> -->
                <div class="form-group">
                    <input type="text" id="quantity_<?php echo $i; ?>" name="quantity[]" class="form-control form-quantity" placeholder="" autocomplete="off" onchange="check_stock('<?php echo $i ?>');">
                </div>
            </div>




        </div>
    </div>
</div>