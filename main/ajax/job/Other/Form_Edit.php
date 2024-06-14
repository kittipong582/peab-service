<?php
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
LEFT JOIN tbl_product_type i ON f.product_type = i.type_id 
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



////////////////////////////////query refjob///////////////////
$sql_ref = "SELECT *,b.job_id AS ref_id,b.job_no as refjob_no FROM tbl_job_ref a
    LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
     WHERE a.job_id = '$job_id'";
$result_ref  = mysqli_query($connect_db, $sql_ref);
$row_ref = mysqli_fetch_array($result_ref);


if ($row['appointment_date'] != "") {
    $appointment_date = date("d-m-Y", strtotime($row['appointment_date']));
}
?>
<?php include("../Edit/form_edit_customer_branch.php"); ?>
<div class="row mb-3">
    <input type="hidden" id="job_id" value="<?php echo $row['job_id'] ?>" name="job_id">

    <div class="mb-3 col-12">
        <strong>
            <h4>1.งาน</h4>
        </strong>
    </div>
    <div class="mb-3 col-3">
        <label>ชื่องาน</label>
        <font color="red">**</font>
        <input type="text" id="job_title" value="<?php echo $row['job_title'] ?>" name="job_title" class="form-control">
    </div>
    <div class="mb-3 col-3">
    </div>
    <div class="mb-3 col-3">
    </div>
    <div class="mb-3 col-3">
    </div>

    <div class="mb-3 col-12">
        <strong>
            <h4>2.ข้อมูลลูกค้า</h4>
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

        <input type="text" id="contact_name" value="<?php echo $contact_name ?>" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>

        <input type="text" id="contact_position" value="<?php echo $contact_position ?>" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>

        <div class="input-group">
            <input type="text" id="contact_phone" value="<?php echo $contact_phone ?>" name="contact_phone" class="form-control">
        </div>

    </div>

</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.ข้อมูลสินค้า</h4>
        </strong>
    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <input type="text" id="serial_no" readonly value="<?php echo $row['serial_no'] ?>" name="serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" class="form-control" readonly value="<?php echo $row['type_code'] . " - " . $row['type_name'] ?>">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly class="form-control" value="<?php echo $brand_name ?>">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <div class="" id="getmodel">
            <input type="text" readonly class="form-control" value="<?php echo $model_name ?>">
        </div>
    </div>

    <div class="mb-3 col-3">
        <label>ประเภทการรับประกัน</label>
        <input type="text" readonly class="form-control" value="<?php echo $warranty_text ?>">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่ติดตั้ง</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="install_date" name="install_date" class="form-control datepicker" readonly value="<?php if ($row['install_date'] != null) {
                                                                                                                            echo date("d-m-Y", strtotime($row['install_date']));
                                                                                                                        } ?>" autocomplete="off">
        </div>
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="warranty_start_date" name="warranty_start_date" class="form-control datepicker" readonly value="<?php if ($row['warranty_start_date'] != null) {
                                                                                                                                        echo date("d-m-Y", strtotime($row['warranty_start_date']));
                                                                                                                                    } ?>" autocomplete="off">
        </div>
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="warranty_expire_date" name="warranty_expire_date" class="form-control datepicker" readonly value="<?php if ($row['warranty_expire_date'] != null) {
                                                                                                                                            echo date("d-m-Y", strtotime($row['warranty_expire_date']));
                                                                                                                                        } ?>" autocomplete="off">
        </div>
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

        <div class="input-group">
            <input type="text" id="branch_care" value="<?php echo $row['team_name']  ?>" readonly name="branch_care" class="form-control">
            <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care()" class="btn btn-primary">เลือกทีมอื่น</button></span>

        </div>

        <!-- <div class="input-group">
            <input type="text" id="branch_care" value="<?php echo $row['team_name'] ?>" readonly name="branch_care" class="form-control branch_care">
            <?php if ($user_level != 1 && $user_level != 2) { ?>
            <?php } ?>
        </div> -->
    </div>
    <div class="mb-3 col-3" id="user_list">
        <label>ช่างผู้รับผิดชอบ</label>

        <select class="form-control select2 mb-3" style="width: 100%;" name="responsible_user_id" id="responsible_user_id">
            <option value="">กรุณาเลือกช่าง</option>
            <?php $sql_user = "SELECT * FROM tbl_user WHERE branch_id = '$care_branch_id'";
            $result_user  = mysqli_query($connect_db, $sql_user);
            while ($row_user = mysqli_fetch_array($result_user)) { ?>

                <option value="<?php echo $row_user['user_id'] ?>" <?php if ($row['responsible_user_id'] == $row_user['user_id']) {
                                                                        echo "SELECTED";
                                                                    } ?>><?php echo $row_user['fullname'] ?></option>
            <?php } ?>
        </select>
        <!-- <input id="responsible_user_id" name="responsible_user_id" readonly class="form-control" value="<?php echo $fullname ?>"> -->
    </div>
    <div class="mb-3 col-3">
        <label>วันที่นัดหมาย</label>

        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="appointment_date" name="appointment_date" readonly value="<?php echo $appointment_date ?>" class="form-control datepicker" value="" autocomplete="off">
        </div>
    </div>
    <div class="mb-3 col-2">
        <label>เวลาเริ่ม</label>

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
            <h4>5.รายละเอียดงาน</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="job_detail" name="job_detail" class="summernote"> <?php echo $row['job_detail'] ?></textarea>
    </div>

</div>
<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>6.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="note" name="note" class="summernote"> <?php echo $row['Aremark'] ?></textarea>
    </div>

</div>
<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_job()">บันทึก</button>
</div>