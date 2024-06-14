<?php
session_start();
include ("../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);

$i = $_POST['rowCount'];



?>
<div class="row" id="row_staff_<?php echo $i ?>">
    <div class="col-12 mb-3">
        <div class="row">
            <div class="col-md-1">
                <label>&nbsp;</label>
                <button type="button" class="btn btn-danger btn-block" name="button"
                    onclick="desty_staff('<?php echo $i; ?>')">
                    <i class="fa fa-times" aria-hidden="true"></i>
                </button>
            </div>
            <div class="mb-3 col-md-3">
                <label>รายชื่อช่าง</label><br>
                <select class="form-control select2 mb-3" style="width: 100%;" name="responsible_user_id[]" id="responsible_user_id">
                    <option value="">กรุณาเลือกช่าง</option>
                    <?php
                    $sql_staff = "SELECT a.*,b.branch_name FROM tbl_user a LEFT JOIN tbl_branch b ON a.branch_id = b.branch_id WHERE  a.active_status = 1 ORDER BY branch_name ASC;";
                    $result_staff = mysqli_query($connect_db, $sql_staff);
                    while ($row = mysqli_fetch_assoc($result_staff)) {
                        ?>
                        <option value="<?php echo $row['user_id'] ?>">
                            <?php echo $row['branch_name'] . ' - ' . $row['fullname']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
    </div>

</div>
<script>
    $(document).ready(function () {
        $(".select2").select2({
        });
    });
        function desty_staff(i) {
        document.getElementById('row_staff_' + i).remove();

    }

    function desty_product(i) {
        document.getElementById('row_product_' + i).remove();

    }

</script>