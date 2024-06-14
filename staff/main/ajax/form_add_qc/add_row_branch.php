<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");


$i = $_POST['rowCount'];



?>
<div class="row" id="row_product_<?php echo $i ?>">
    <div class="col-12 mb-3">
    <div class="row">
        <div class="col-md-1">
            <label>&nbsp;</label>
            <button type="button" class="btn btn-danger btn-block" name="button"
                onclick="desty_product('<?php echo $i; ?>')">
                <i class="fa fa-times" aria-hidden="true"></i>
            </button>
        </div>
        <div class="mb-3 col-md-3">
            <label>เลือกเครื่อง</label><br>
            <select id="product_id" name="product_id[]" class="form-control select2 mb-3">
                <?php
                $sql_product = "SELECT a.*,b.model_code,model_name FROM tbl_product_waiting a LEFT JOIN tbl_product_model b ON a.model_id = b.model_code";
                $rs_product = mysqli_query($connect_db, $sql_product) or die ($connect_db->error);
                ?>
                <option value="">กรุณาเลือกเครื่อง</option>
                <?php while ($row_product = mysqli_fetch_assoc($rs_product)) { ?>
                    <option value="<?php echo $row_product['model_id'] ?>">
                        <?php echo $row_product['model_code'] . " - " . $row_product['model_name'] ?>
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