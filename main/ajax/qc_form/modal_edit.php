<?php
include ("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");


    $qc_id = mysqli_real_escape_string($connection, $_POST['qc_id']);

 $sql = "SELECT * FROM tbl_qc_form  WHERE qc_id = '$qc_id'";
   $res = mysqli_query($connection, $sql);
   $row = mysqli_fetch_assoc($res);
?>
<div class="modal-header">
    <h4 class="modal-title">เพิ่ม</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
            aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <form id="form-add" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <div class="row mb-3">
                <div class="col-6">
                    <label class="font-normal">หัวข้อ</label>
                    <input type="text" class="form-control" id="qc_name" name="qc_name" value="<?php echo $row['qc_name'] ?>">
                </div>
                <div class="col-6">
                    <label class="font-normal">รายละเอียด</label>
                    <input type="text" class="form-control" id="description" name="description" value="<?php echo $row['description'] ?>">
                </div>
            </div>

        </div>
        <div class="form-group">
            <div class="row mb-3">
                <div class="col-12">
                    <label class="font-normal">ประเภทเครื่อง</label>
                    <select id="type_id" name="type_id" class="form-control select2 mb-3">
                        <?php $sql_type = "SELECT * FROM tbl_product_type WHERE active_status = 1";
                        $rs_type = mysqli_query($connection, $sql_type) or die ($connection->error);
                        ?>
                        <option value="">กรุณาเลือกเครื่อง</option>
                        <?php while ($row_type = mysqli_fetch_assoc($rs_type)) { ?>
                            <option value="<?php echo $row_type['type_id'] ?>"<?php echo ($row_type['type_id'] == $row['product_type_id']) ? ' selected' : ''; ?>>


                                <?php echo $row_type['type_code'] . " - " . $row_type['type_name'] ?>
                            </option>
                        <?php } ?>
                    </select>
                </div>
            </div>
        </div>
       
        <div class="modal-footer">
            <button type="button" class="btn btn-primary" onclick="SubmitQc()"><i
                    class="fa fa-check"></i>&nbsp;บันทึก</button>
            <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
        </div>
    </form>
</div>

<?php include ("import_script.php") ?>
<script>
    $(document).ready(function () {
        $(".select2").select2({
            width: "100%"
        });
    });
</script>