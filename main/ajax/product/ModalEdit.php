<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_POST['product_id'];
$sql = "SELECT * FROM tbl_product WHERE product_id = '$product_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);
$brand_id = $row['brand_id'];

$sql_type = "SELECT * FROM tbl_product_type WHERE active_status = 1 ORDER BY type_code";
$result_type  = mysqli_query($connect_db, $sql_type);
?>
<form action="" method="post" id="form-edit" enctype="multipart/form-data">
    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">เเก้ไขสินค้า</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
    <div class="modal-body">
        <div class="row">
            <input type="hidden" value="<?php echo $product_id  ?>" id="product_id" name="product_id">
            <input type="hidden" value="<?php echo $row['current_branch_id']  ?>" id="current_branch_id" name="current_branch_id">
            <div class="col-4 mb-3">
                <label for="brand_id">
                    แบรนด์
                </label>

                <font color="red">**</font>
                <select class="form-control select2 mb-3" style="width: 100%;" name="brand_id" id="brand_id" onchange="setModel(value)">
                    <option value="">กรุณาเลือกแบรนด์</option>
                    <?php $sql_brand = "SELECT * FROM tbl_product_brand WHERE active_status = '1'";
                    $result_brand  = mysqli_query($connect_db, $sql_brand);
                    while ($row_brand = mysqli_fetch_array($result_brand)) { ?>

                        <option value="<?php echo $row_brand['brand_id'] ?>" <?php echo ($row['brand_id'] == $row_brand['brand_id']) ? 'selected' : ''; ?>><?php echo $row_brand['brand_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="col-4 mb-3">
                <label for="model_id">
                    รุ่น
                </label>
                <font color="red">**</font>
                <div class="" id="getmodel">
                    <select class="form-control select2 mb-3 " style="width: 100%;" name="model_id" id="model_id">
                        <option value="">กรุณาเลือกรุ่น</option>
                        <?php $sql_model = "SELECT * FROM tbl_product_model WHERE brand_id = '$brand_id' AND active_status = '1'";
                        $result_model  = mysqli_query($connect_db, $sql_model);
                        while ($row_model = mysqli_fetch_array($result_model)) { ?>

                            <option value="<?php echo $row_model['model_id'] ?>" <?php echo ($row['model_id'] == $row_model['model_id']) ? 'selected' : ''; ?>><?php echo $row_model['model_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="col-4 mb-3">
                <div>
                    <label for="product_type">
                        ประเภทเครื่อง
                    </label>
                    <font color="red">**</font>
                    <select name="product_type" id="product_type" style="width: 100%;" class="form-control select2 mb-3 ">
                        <option value="">กรุณาเลือกเครื่อง</option>

                        <?php

                        while ($row_type = mysqli_fetch_array($result_type)) { ?>

                            <option value="<?php echo $row_type['type_id'] ?>" <?php if ($row['product_type'] == $row_type['type_id']) {
                                                                                    echo "selected";
                                                                                } ?>><?php echo $row_type['type_code'] . " - " . $row_type['type_name'] ?></option>
                        <?php } ?>


                    </select>
                </div>
            </div>
            <div class="col-12 mb-3">
                <label for="serial_no">
                    serial no
                </label>
                <font color="red">**</font>
                <input type="text" class="form-control mb-3" id="serial_no" value="<?php echo $row['serial_no'] ?>" name="serial_no">
            </div>

            <div class="col-4 mb-3">
                <div>
                    <label for="warranty_type">
                        ประเภทการรับประกัน
                    </label>
                    <font color="red">**</font>
                    <select name="warranty_type" id="warranty_type" class="form-control select2 mb-3" style="width: 100%;" onchange="setwarranty(this.value),clear_date();">
                        <option value="">กรุณาเลือกประเภทประกัน</option>
                        <option value="1" <?php if ($row['warranty_type'] == 1) {
                                                echo "selected";
                                            } ?>>ซื้อจากบริษัท</option>
                        <option value="2" <?php if ($row['warranty_type'] == 2) {
                                                echo "selected";
                                            } ?>>ไม่ได้ซื้อจากบริษัท</option>
                        <option value="3" <?php if ($row['warranty_type'] == 3) {
                                                echo "selected";
                                            } ?>>สัญญาบริการ</option>

                    </select>
                </div>
            </div>

            <div class="col-4 mb-3">
            </div>

            <div class="col-4 mb-3">
            </div>

            <div class="col-6 mb-3" id="div_install" style="display:none">
                <label for="install_date">
                    วันที่ติดตั้ง
                </label>
                <font color="red" id="alert" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="install_date" name="install_date" class="form-control datepicker" value="<?php echo ($row['install_date'] == null ? '' : date("d-m-Y", strtotime($row['install_date'])))  ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_buy" style="display:none">

                <label for="buy_date">
                    วันที่ซื้อ
                </label>
                <font color="red" id="alert1" style="display:none">**</font>

                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="buy_date" name="buy_date" class="form-control datepicker" value="<?php echo ($row['buy_date'] == null ? '' : date("d-m-Y", strtotime($row['buy_date'])))  ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_start" style="display:none">
                <label for="warranty_start_date">
                    วันที่เริ่มประกัน
                </label>
                <font color="red" id="alert2" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_start_date" name="warranty_start_date" class="form-control datepicker" value="<?php echo ($row['warranty_start_date'] == null ? '' : date("d-m-Y", strtotime($row['warranty_start_date'])))  ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-6 mb-3" id="div_end" style="display:none">

                <label for="warranty_end_date">
                    วันที่หมดประกัน
                </label>
                <font color="red" id="alert3" style="display:none">**</font>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_end_date" name="warranty_end_date" class="form-control datepicker" value="<?php echo ($row['warranty_expire_date'] == null ? '' : date("d-m-Y", strtotime($row['warranty_expire_date'])))  ?>" autocomplete="off">
                </div>
            </div>

            <div class="col-12 mb-3">

                <label for="note">
                    หมายเหตุ
                </label>
                <textarea class="summernote" name="note" style="outline: 1px;" id="note"><?php echo $row['note'] ?></textarea>
            </div>

            <div class="col-4 mb-3">
            </div>
        </div>


    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary btn-sm" onclick="update_product();">บันทึก</button>
    </div>
</form>
<?php include('import_script.php'); ?>
<script>
    $(document).ready(function() {



        $('.summernote').summernote({
            toolbar: false,
            height: 100,
        });

        $(".select2").select2({});


        $(".datepicker").datepicker({
            todayBtn: "linked",
            keyboardNavigation: false,
            format: 'dd-mm-yyyy',
            autoclose: true,
        });

    });

  
</script>