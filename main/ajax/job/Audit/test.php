<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$job_type = $_POST['job_type'];



$sql = "SELECT *,a.remark AS Aremark,b.branch_name as team_name FROM tbl_job a 
LEFT JOIN tbl_branch b ON a.care_branch_id = b.branch_id 
LEFT JOIN tbl_user c ON a.responsible_user_id = c.user_id
LEFT JOIN tbl_customer_branch d ON d.customer_branch_id = a.customer_branch_id
LEFT JOIN tbl_customer e ON d.customer_id = e.customer_id
LEFT JOIN tbl_product f ON a.product_id = f.product_id
LEFT JOIN tbl_product_brand g ON g.brand_id = f.brand_id
LEFT JOIN tbl_product_model h ON h.model_id = f.model_id 
WHERE a.job_id = '$job_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$hours = date("H", strtotime($row['appointment_time_start']));
$minutes = date("i", strtotime($row['appointment_time_start']));

$houre = date("H", strtotime($row['appointment_time_end']));
$minutee = date("i", strtotime($row['appointment_time_end']));

$customer_branch_id = $row['customer_branch_id'];
$contact_name = $row['contact_name'];
$contact_position = $row['contact_position'];
$contact_phone = $row['contact_phone'];
$product_id = $row['product_id'];

$care_branch_id = $row['care_branch_id'];
$customer_branch_name = $row['branch_name'];
$customer_name = $row['customer_name'];

$serial_no = $row['serial_no'];
$brand_name = $row['brand_name'];
$model_name = $row['model_name'];
if ($row['product_type'] == 1) {
    $product_type = "CM";
}
if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}
$fullname = $row['fullname'];


if ($row['product_type'] == 1) {
    $product_type = 'เครื่องชง';
} else if ($row['product_type'] == 2) {
    $product_type = 'เครื่องบด';
} else if ($row['product_type'] == 3) {
    $product_type = 'เครื่องปั่น';
}


////////////////////////////////query refjob///////////////////
$sql_ref = "SELECT *,b.job_id AS ref_id,b.job_no as refjob_no FROM tbl_job_ref a
    LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
     WHERE a.job_id = '$job_id'";
$result_ref  = mysqli_query($connect_db, $sql_ref);
$row_ref = mysqli_fetch_array($result_ref);




?>


<div class="row mb-3">
    <input type="hidden" id="job_id" value="<?php echo $row['job_id'] ?>" name="job_id">

    <div class="mb-3 col-12">
        <strong>
            <h4>1.ข้อมูลลูกค้า</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-3">
        <label>ชื่อลูกค้า</label>
        <input type="text" readonly id="customer_name" value="<?php echo  $customer_name ?>" name="customer_name" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ชื่อร้าน</label>
        <input type="text" readonly id="branch_name" value="<?php echo  $customer_branch_name ?>" name="branch_name" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>งานที่เกี่ยวข้อง</label>
        <div class="input-group">
            <input type="text" readonly readonly id="job_ref" name="job_ref" value="<?php echo $row_ref['refjob_no'] ?>" class="form-control">
        </div>
    </div>

    <div class="mb-3 col-3">

    </div>

    <input type="hidden" id="customer_branch_id" value="<?php echo $customer_branch_id ?>" name="customer_branch_id">
    <div class="mb-3 col-3">
        <label>ผู้ติดต่อ</label>
        <font color="red">**</font>
        <input type="text" readonly id="contact_name" value="<?php echo $contact_name ?>" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>
        <font color="red">**</font>
        <input type="text" readonly id="contact_position" value="<?php echo $contact_position ?>" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>
        <font color="red">**</font>
        <div class="input-group">
            <input type="text" readonly id="contact_phone" value="<?php echo $contact_phone ?>" name="contact_phone" class="form-control">
        </div>

    </div>

</div>

<div class="row mb-3">
    <input type="hidden" id="product_id" value="<?php echo $row['product_id'] ?>" name="product_id">
    <div class="mb-3 col-12">
        <strong>
            <h4>2.ข้อมูลสินค้า</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="serial_no" value="<?php echo $serial_no ?>" name="serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" readonly id="product_type" value="<?php echo $product_type ?>" name="product_type" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="brand" value="<?php echo $brand_name ?>" name="brand" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="model" value="<?php echo $model_name ?>" name="model" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ประเภทการรับประกัน</label>
        <input type="text" readonly id="warranty_type" value="<?php echo $warranty_text ?>" name="warranty_type" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่ติดตั้ง</label>
        <input type="text" readonly id="install_date" value="<?php if ($row['install_date'] != null) {
                                                                    echo date("d-m-Y", strtotime($row['install_date']));
                                                                } ?>" name="install_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="warranty_start_date" value="<?php if ($row['warranty_start_date'] != null) {
                                                                        echo date("d-m-Y", strtotime($row['warranty_start_date']));
                                                                    } ?>" name="warranty_start_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="warranty_expire_date" value="<?php if ($row['warranty_expire_date'] != null) {
                                                                            echo date("d-m-Y", strtotime($row['warranty_expire_date']));
                                                                        } ?>" name="warranty_expire_date" class="form-control">
    </div>
</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.อาการเสียเบื้องต้น</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="damaged_report" name="damaged_report" class="summernote"><?php echo $row['initial_symptoms'] ?></textarea>
    </div>

</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>4.การนัดหมาย</h4>
        </strong>
    </div>
    <input type="hidden" readonly id="branch_care_id" value="<?php echo $care_branch_id ?>" name="branch_care_id" class="form-control">
    <div class="col-mb-3 col-3">
        <label>ทีมดูแล</label>
        <font color="red">**</font>
        <div class="input-group">
            <input type="text" id="branch_care" value="<?php echo $row['team_name']  ?>" readonly name="branch_care" class="form-control">
        </div>
    </div>
    <div class="mb-3 col-3" id="user_list">
        <label>ช่างผู้รับผิดชอบ</label>
        <font color="red">**</font>

        <input id="responsible_user_id" name="responsible_user_id" readonly class="form-control" value="<?php echo $fullname ?>">
    </div>
    <div class="mb-3 col-3">
        <label>วันที่นัดหมาย</label>
        <font color="red">**</font>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="appointment_date" name="appointment_date" value="<?php echo date("d-m-Y", strtotime($row['appointment_date'])) ?>" class="form-control datepicker" value="" autocomplete="off">
        </div>
    </div>
    <div class="mb-3 col-2">
        <label>เวลาเริ่ม</label>
        <font color="red">**</font>
        <select name="hours" id="hours" style="width: 100%;" class="form-control select2 mb-3 ">
            <option value="">กรุณาเลือกเวลา</option>
            <?php $i = 0;
            $h = 2;
            while ($i <= 23) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>" <?php if ($hours == $time) {
                                                        echo 'selected';
                                                    } ?>><?php echo $time ?></option>

            <?php $i++;
            } ?>

        </select>

    </div>

    <div class="mb-3 col-1">
        <label>นาที</label>
        <select name="minutes" id="minutes" style="width: 100%;" class="form-control select2 mb-3 ">
            <?php $i = 0;
            $h = 2;
            while ($i <= 59) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>" <?php if ($minutes == $time) {
                                                        echo 'selected';
                                                    } ?>><?php echo $time ?></option>

            <?php $i++;
            } ?>

        </select>

    </div>

    <div class="mb-3 col-2">
        <label>เวลาสิ้นสุด</label>
        <font color="red">**</font>
        <select name="houre" id="houre" style="width: 100%;" class="form-control select2 mb-3 ">
            <option value="">กรุณาเลือกเวลา</option>
            <?php $i = 0;
            $h = 2;
            while ($i <= 23) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>" <?php if ($houre == $time) {
                                                        echo 'selected';
                                                    } ?>><?php echo $time ?></option>

            <?php $i++;
            } ?>

        </select>

    </div>

    <div class="mb-3 col-1">
        <label>นาที</label>
        <select name="minutee" id="minutee" style="width: 100%;" class="form-control select2 mb-3 ">
            <?php $i = 0;
            $h = 2;
            while ($i <= 59) {
                $time = sprintf("%0" . $h . "d", $i); ?>
                <option value="<?php echo $time ?>" <?php if ($minutee == $time) {
                                                        echo 'selected';
                                                    } ?>><?php echo $time ?></option>

            <?php $i++;
            } ?>

        </select>


    </div>

    <?php include("../form_edit_staff.php"); ?>
</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>5.ค่าบริการ</h4>
        </strong>
    </div>
    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_row();"><i class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>
    <div class="col-mb-3 col-12">
        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width:5%;"></th>
                    <th style="width:20%;">รายการ</th>
                    <th style="width:10%;">จำนวน</th>
                    <th style="width:10%;">หน่วย</th>
                    <th style="width:10%;">ราคาต่อหน่วย</th>
                    <th style="width:10%;">ราคารวม (โดยประมาณ)</th>
                </tr>
            </thead>
            <tbody id="Addform" name="Addform">


                <?php $i = 0;

                $sql_service = "SELECT * FROM tbl_job_open_oth_service WHERE job_id ='$job_id'";
                $result_service  = mysqli_query($connect_db, $sql_service);
                while ($row_service = mysqli_fetch_array($result_service)) {

                    $i++;

                    $sql_row = "SELECT * FROM tbl_oth_open_job_service a 
                    LEFT JOIN tbl_oth_open_job_service b ON b.service_id = a.service_id
                     WHERE a.active_status = 1";
                    $result_row  = mysqli_query($connect_db, $sql_row);
                ?>

                    <tr name="tr_CM[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
                        <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </td>
                        <td><select name="job_service[]" id="job_service_<?php echo $i; ?>" style="width: 100%;" class="form-control select2" onchange="select_Service(this.value,'<?php echo $i ?>');">
                                <option value="">กรุณาเลือกบริการ</option>

                                <?php
                               
                                while ($row_row = mysqli_fetch_array($result_row)) { ?>

                                    <option value="<?php echo $row_row['service_id']; ?>" <?php echo ($row_row['service_id'] == $row_service['service_id']) ? 'selected' : ''; ?>><?php echo $row_row['service_name']; ?></option>

                                <? } ?>

                            </select></td>
                        <?php
                        $result_job_se  = mysqli_query($connect_db, $sql_row);
                        $row_job_service = mysqli_fetch_array($result_job_se);
                        ?>
                        <td><input type="text" class="form-control" onchange="Cal(this.value,'<?php echo $i; ?>');" name="quantity[]" id="quantity_<?php echo $i; ?>" value="<?php echo $row_service['quantity'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit[]" id="unit_<?php echo $i; ?>" value="<?php echo $row_job_service['unit'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit_cost[]" id="unit_cost_<?php echo $i; ?>" value="<?php echo $row_job_service['unit_cost'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit_price[]" id="unit_price_<?php echo $i; ?>" value="<?php echo $row_service['unit_price'] ?>"></td>
                    </tr>

                <?php } ?>
                <div id="counter" hidden><?php echo $result_service->num_rows ?></div>
            </tbody>
        </table>

    </div>

</div>