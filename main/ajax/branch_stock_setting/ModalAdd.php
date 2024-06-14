<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
?>

<div class="modal-header">
    <h3>เพิ่มรายการตั้งค่าอะไหล่เริ่มต้น</h3>
</div>
<div class="col-lg-12">
    <div class="wrapper wrapper-content animated fadeInRight">
        <div class="row">
                    <div class="col-lg-12">
                        <form id="frm_import" method="POST" enctype="multipart/form-data">
                            <div class="col-lg-12 col-xs-12 col-sm-12">
                                <div class="row">
                                    <div class="col-md-3 col-xs-12 col-sm-12">
                                        <div class="form-group">
                                            <label>ทีม</label>
                                            <font color="red">**</font>
                                            <select class="form-control select2" id="branch_id" name="branch_id" data-width="100%">
                                                <?php if ($user_level == '2' ){
                                                    $sql_b = "SELECT a.branch_id,a.branch_name 
                                                    FROM tbl_branch a LEFT JOIN tbl_user b 
                                                    ON a.branch_id=b.branch_id
                                                    WHERE b.user_id = '$user_id';";
                                                    $rs_b = mysqli_query($connect_db, $sql_b);
                                                    $row_b = mysqli_fetch_assoc($rs_b)
                                                    ?>
                                                        <option value="<?php echo $row_b['branch_id'] ?>">
                                                        <?php echo $row_b['branch_name'] ?></option>
                                                    <?php } else { ?>
            
                                                <option value="x" selected>กรุณาเลือกทีม </option>

                                                <?php

                                                $sql_b = "SELECT branch_id,branch_name  FROM tbl_branch ;";
                                                $rs_b = mysqli_query($connect_db, $sql_b);
                                                while ($row_b = mysqli_fetch_assoc($rs_b)) {

                                                ?>

                                                    <option value="<?php echo $row_b['branch_id'] ?>">
                                                        <?php echo $row_b['branch_name'] ?></option>


                                                <?php }} ?>
                                            </select>
                                        </div>
                                    </div>
                                    </select>
                                </div>
                            </div>
                            <br>
                            <div class="col-md-12 col-xs-12 col-sm-12">
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-mb-5 col-xs-5 col-sm-5 text-left"><label>รายการอะไหล่</label></div>
                                        <div class="col-md-3 col-xs-3 col-sm-3 text-left"><label>หน่วย</label></div>
                                        <div class="col-mb-4 col-xs-4 col-sm-4 text-left"><label>จำนวนเริ่มต้น</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="col-mb-5 col-xs-5 col-sm-5">
                                            <select name="ax" id="ax" class="form-control select2" onchange="GetUnit(this.value);">
                                                <option value="x" selected>กรุณาเลือก </option>
                                                    <?php
                                                    $sql_sp = "SELECT * FROM tbl_spare_part ;";
                                                    $rs_sp = mysqli_query($connect_db, $sql_sp);
                                                    while ($row_sp = mysqli_fetch_assoc($rs_sp)) {
                                                    ?>
                                                        <option value="<?php echo $row_sp['spare_part_id'] ?>">
                                                            <?php echo $row_sp['spare_part_code'] . " - " . $row_sp['spare_part_name'] ?>
                                                        </option>
                                                    <?php } ?>
                                            </select>
                                        </div>
                                        <div class="col-md-3 col-xs-3 col-sm-3">
                                            <div class="form-group">
                                                <input type="text" id="unit" name="unit" class="form-control" placeholder="" autocomplete="off" readonly>
                                            </div>
                                        </div>

                                        <div class="col-mb-4 col-xs-4 col-sm-4">
                                            <!-- <label>จำนวน</label> -->
                                            <div class="form-group">
                                                <input type="number" id="quantity" name="quantity" class="form-control" placeholder="" autocomplete="off">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
    <button type="button" class="btn btn-primary btn-sm" onclick="Add();">บันทึก</button>
</div>

<script>
    $(".select2").select2({
        width: "100%"
    });

    function GetUnit(spare_part_id) {

        $.ajax({
            url: 'ajax/import_from_ax/GetUnit.php',
            data: {
                spare_part_id: spare_part_id
            },
            type: 'POST',
            dataType: 'json',
            success: function(data) {
                $("#unit").val(data.unit);
            }
        });
    }

</script>