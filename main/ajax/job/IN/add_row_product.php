<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connect_db = connectDB($secure);

$i = $_POST['rowCount'];

$sql_type = "SELECT * FROM tbl_product_type WHERE active_status = 1 ORDER BY type_code";
$result_type  = mysqli_query($connect_db, $sql_type);

?>
<div class="row mb-3" id="row_product_<?php echo $i ?>">
    <input type="hidden" id="product_id_<?php echo $i ?>" name="product_id[]">
    <div class="mb-3 col-12">
        <button type="button" class="btn btn-danger btn-sm" name="button" onclick="desty_product('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <div class="input-group">
            <input type="text" id="serial_no_<?php echo $i ?>" value="" name="serial_no[]" class="form-control">
            <span class="input-group-append"><button type="button" id="btn_ref_<?php echo $i ?>" onclick="search_product('<?php echo $i ?>');" name="btn_ref" class="btn btn-warning">ตรวจสอบ</button></span>
        </div>
    </div>
    <div class="mb-3 col-3" id="point_type_<?php echo $i ?>">
        <label>ประเภทเครื่อง</label>
        <font color="red">**</font>
        <select name="product_type[]" id="product_type_<?php echo $i ?>" style="width: 100%;" class="form-control select2 mb-3 ">
            <option value="">กรุณาเลือกเครื่อง</option>
            <?php while ($row_type = mysqli_fetch_array($result_type)) { ?>

                <option value="<?php echo $row_type['type_id'] ?>"><?php echo $row_type['type_code'] . " - " . $row_type['type_name'] ?></option>
            <?php } ?>

        </select>
    </div>
    <div class="mb-3 col-3" id="point_brand_<?php echo $i ?>">
        <label>ยี่ห้อ</label>
        <font color="red">**</font>
        <select class="form-control select2 mb-3" style="width: 100%;" name="brand_id[]" id="brand_id_<?php echo $i ?>" onchange="setModel(value,<?php echo $i ?>)">
            <option value="">กรุณาเลือกแบรนด์</option>
            <?php $sql_brand = "SELECT * FROM tbl_product_brand WHERE active_status = '1'";
            $result_brand  = mysqli_query($connect_db, $sql_brand);
            while ($row_brand = mysqli_fetch_array($result_brand)) { ?>

                <option value="<?php echo $row_brand['brand_id'] ?>"><?php echo $row_brand['brand_name'] ?></option>
            <?php } ?>
        </select>
    </div>
    <div class="mb-3 col-3" id="point_model_<?php echo $i ?>">
        <label>รุ่น</label>
        <font color="red">**</font>
        <div class="" id="getmodel_<?php echo $i ?>">
            <select class="form-control select2 mb-3" style="width: 100%;" name="model_id[]" id="model_id">
                <option value="">กรุณาเลือกรุ่น</option>
            </select>
        </div>
    </div>

    <div class="mb-3 col-3" id="point_war_type_<?php echo $i ?>">
        <label>ประเภทการรับประกัน</label>
        <font color="red">**</font>
        <select name="warranty_type[]" id="warranty_type_<?php echo $i ?>" class="form-control select2 mb-3" style="width: 100%;">
            <option value="">กรุณาเลือกประเภทประกัน</option>
            <option value="1">ซื้อจากบริษัท</option>
            <option value="2">ไม่ได้ซื้อจากบริษัท</option>
            <option value="3">สัญญาบริการ</option>

        </select>
    </div>

    <div class="mb-3 col-3" id="point_in_<?php echo $i ?>">
        <label>วันที่ติดตั้ง</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="install_date_<?php echo $i ?>" name="install_date[]" class="form-control datepicker" readonly value="" autocomplete="off">
        </div>
    </div>

    <div class="mb-3 col-3" id="point_swar_<?php echo $i ?>">
        <label>วันที่เริ่มประกัน</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="warranty_start_date_<?php echo $i ?>" name="warranty_start_date[]" class="form-control datepicker" readonly value="" autocomplete="off">
        </div>
    </div>

    <div class="mb-3 col-3" id="point_nwar_<?php echo $i ?>">
        <label>วันที่หมดประกัน</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="warranty_expire_date_<?php echo $i ?>" name="warranty_expire_date[]" class="form-control datepicker" readonly value="" autocomplete="off">
        </div>
    </div>
    <hr>
</div>