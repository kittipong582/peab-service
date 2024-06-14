<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$job_type = $_POST['job_type'];


$sql = "SELECT *,a.remark AS Aremark,b.branch_name as team_name,e.customer_id AS eid,i.type_code,i.type_name FROM tbl_job a 
LEFT JOIN tbl_user c ON a.responsible_user_id = c.user_id
LEFT JOIN tbl_branch b ON a.care_branch_id = b.branch_id 
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

$product_type = $row['type_code'] . " - " . $row['type_name'];

if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}
$fullname = $row['fullname'];

$customer_id = $row['eid'];

////////////////////////////////query refjob///////////////////
$sql_ref = "SELECT *,b.job_id AS ref_id,b.job_no as refjob_no FROM tbl_job_ref a
    LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
     WHERE a.job_id = '$job_id'";
$result_ref  = mysqli_query($connect_db, $sql_ref);
$row_ref = mysqli_fetch_array($result_ref);


///////////////////product id branch /////////////////////
$sql_product = "SELECT * FROM tbl_product WHERE current_branch_id = '$customer_branch_id'";
$result_product  = mysqli_query($connect_db, $sql_product);

// echo $sql_product;
?>

<?php include("../Edit/form_edit_customer_branch.php"); ?>

<div class="row mb-3">
    <input type="hidden" id="job_id" value="<?php echo $row['job_id'] ?>" name="job_id">
    <input type="hidden" id="customer_branch_id" value="<?php echo $row['customer_branch_id'] ?>" name="customer_branch_id">
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


    <div class="mb-3 col-3">
        <label>ผู้ติดต่อ</label>
        <font color="red">**</font>
        <input type="text"  id="contact_name" value="<?php echo $contact_name ?>" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>
        <font color="red">**</font>
        <input type="text"  id="contact_position" value="<?php echo $contact_position ?>" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>
        <font color="red">**</font>
        <div class="input-group">
            <input type="text"  id="contact_phone" value="<?php echo $contact_phone ?>" name="contact_phone" class="form-control">
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

    <div class="mb-3 col-12" id="product_point">
        <label>เครื่อง</label><br>
        <select id="product_select" name="product_select" style="width: 35%;" class="form-control select2" onchange="Get_detailProduct(this.value)">

            <option value="">เลือกเครื่อง</option>

            <?php while ($row_product = mysqli_fetch_array($result_product)) {



                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '{$row_product['brand_id']}'";
                $result_brand  = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '{$row_product['model_id']}'";
                $result_model  = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);
            ?>

                <option value="<?php echo $row_product['product_id'] ?>" <?php if ($row_product['product_id'] == $row['product_id']) {
                                                                                echo "SELECTED";
                                                                            } ?>><?php echo $row_product['serial_no'] . " - " . $row_brand['brand_name'] . " - " . $row_model['model_name'] ?></option>

            <?php  } ?>
        </select>
    </div>


    <div class="mb-3 col-3">
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
            <input type="text" id="branch_care" value="<?php echo $row['team_name'] ?>" readonly name="branch_care" class="form-control branch_care">
            <?php if ($user_level != 1 && $user_level != 2) { ?>
                <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care()" class="btn btn-primary">เลือกทีมอื่น</button></span>
            <?php } ?>
        </div>
    </div>
    <div class="mb-3 col-3" id="user_list">
        <label>ช่างผู้รับผิดชอบ</label>
        <font color="red">**</font>
        <select class="form-control select2 mb-3" style="width: 100%;" name="responsible_user_id" id="responsible_user_id">
            <option value="">กรุณาเลือกช่าง</option>
            <?php $sql_res = "SELECT * FROM tbl_user WHERE active_status = 1 AND branch_id = '$care_branch_id'";
            $result_res  = mysqli_query($connect_db, $sql_res);
            while ($row_res = mysqli_fetch_array($result_res)) { ?>
                <option value="<?php echo $row_res['user_id'] ?>" <?php echo ($row_res['user_id'] == $row['responsible_user_id']) ? 'selected' : ''; ?>><?php echo $row_res['fullname'] ?></option>
            <?php  } ?>
        </select>
    </div>
    <div class="mb-3 col-3">
        <label>วันที่นัดหมาย</label>
        <font color="red">**</font>
        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="appointment_date" name="appointment_date" value="<?php echo (!empty($row['appointment_date'])) ? date("d-m-Y", strtotime($row['appointment_date'])) : ""; ?>" class="form-control datepicker" value="" autocomplete="off">
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
            <h4>5.เครื่องทดแทน</h4>
        </strong>
    </div>
    <?php $sql_oh = "SELECT * FROM tbl_overhaul a 
            LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id 
            LEFT JOIN tbl_product_model c ON a.model_id = c.model_id
            LEFT JOIN tbl_product_type d ON d.type_id = a.product_type
            WHERE a.overhaul_id = '{$row['overhaul_id']}'";
    $result_oh  = mysqli_query($connect_db, $sql_oh);
    $row_branch1 = mysqli_fetch_array($result_oh);
    $war_end = "-";
    $war_start = "-";

    $num_chk = mysqli_num_rows($result_oh);
    if (!empty($row_branch1['warranty_start_date']) && $num_chk > 1) {
        $war_start = date("d-m-Y", strtotime($row_branch1['warranty_start_date']));
    }

    if (!empty($row_branch1['warranty_end_date']) && $num_chk > 1) {
        $war_end = date("d-m-Y", strtotime($row_branch1['warranty_end_date']));
    }
    ?>

    <div class="mb-3 col-4">
        <label>เครื่องทดแทน</label>
        <select id="" name="" onchange="get_oh_product(this.value)" class="form-control select2 mb-3">
            <?php $sql_branch = "SELECT * FROM tbl_branch WHERE active_status = 1";
            $rs_branch = mysqli_query($connect_db, $sql_branch) or die($connect_db->error);
            ?>
            <option value="">กรุณาเลือกเครื่อง</option>
            <?php while ($row_branch = mysqli_fetch_assoc($rs_branch)) { ?>
                <option value="<?php echo $row_branch['branch_id'] ?>" <?php if ($row_branch1['current_branch_id'] == $row_branch['branch_id']) {
                                                                            echo "SELECTED";
                                                                        } ?>><?php echo $row_branch['team_number'] . " - " . $row_branch['branch_name'] ?></option>
            <?php } ?>
        </select>
    </div>

    <div class="mb-3 col-4" id="overhaul_point">
        <label>เครื่องทดแทน</label>
        <select id="overhaul_id" name="overhaul_id" class="form-control select2 mb-3" onchange="">
            <option value="">กรุณาเลือกเครื่อง</option>
            <?php while ($row_oh = mysqli_fetch_array($result_oh)) { ?>
                <option value="<?php echo $row_oh['overhaul_id'] ?>"><?php echo "[ " . $row_oh['serial_no'] . " ] - " . $row_oh['brand_name'] . " " . $row_oh['model_name'] ?></option>
            <?php } ?>

        </select>

    </div>

    <div class="mb-3 col-4">

    </div>
    <div class="mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="o_serial_no" value="<?php echo $row_branch1['serial_no'] ?>" name="o_serial_no" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" id="o_type" class="form-control" readonly value="<?php echo $row_branch1['type_code'] . " - " . $row_branch1['type_name'] ?>">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="o_brand" value="<?php echo $row_branch1['brand_code'] . " - " . $row_branch1['brand_name'] ?>" name="o_brand" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="o_model" value="<?php echo $row_branch1['model_code'] . " - " . $row_branch1['model_name'] ?>" name="o_model" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="o_warranty_start_date" value="<?php echo $war_start ?>" name="o_warranty_start_date" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="o_warranty_expire_date" value="<?php echo $war_end ?>" name="o_warranty_expire_date" class="form-control">
    </div>
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

                $sql_service = "SELECT * FROM tbl_job_open_oth_service a
                LEFT JOIN tbl_income_type b ON a.service_id = b.income_type_id WHERE a.job_id ='$job_id'";
                $result_service  = mysqli_query($connect_db, $sql_service);
                while ($row_service = mysqli_fetch_array($result_service)) {

                    $i++;
                    $service_array = array();
                    $sql_row = "SELECT * FROM  tbl_income_type 
                                 WHERE active_status = 1";
                    $result_row  = mysqli_query($connect_db, $sql_row);


                    while ($row_row = mysqli_fetch_array($result_row)) {
                        $temp_array = array(
                            "service_id" => $row_row['income_type_id'],
                            "service_name" => $row_row['income_type_name'],
                            "income_code" => $row_row['income_code']
                        );

                        array_push($service_array, $temp_array);
                    }


                ?>

                    <tr name="tr_CM[]" id="tr_<?php echo $i; ?>" value="<?php echo $i; ?>">
                        <td> <button type="button" class="btn btn-danger btn-block" name="button" onclick="desty('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
                        </td>
                        <td><select name="job_service[]" id="job_service_<?php echo $i; ?>" style="width: 100%;" class="form-control select2" onchange="select_Service(this.value,'<?php echo $i ?>');">
                                <option value="">กรุณาเลือกบริการ</option>
                                <?php foreach ($service_array as $service_row) { ?>
                                    <option value="<?php echo $service_row['service_id'] ?>" <?php if ($service_row['service_id'] == $row_service['service_id']) {
                                                                                                    echo "selected";
                                                                                                } ?>><?php echo "[" . $service_row['income_code'] . "] -" . $service_row['service_name'] ?></option>

                                <?php } ?>


                            </select></td>
                        <?php
                        // $result_job_se  = mysqli_query($connect_db, $sql_row);
                        // $row_job_service = mysqli_fetch_array($result_service);

                        // echo $row_job_service['income_type_name'];
                        ?>
                        <td><input type="text" class="form-control" onchange="Cal(this.value,'<?php echo $i; ?>');" name="quantity[]" id="quantity_<?php echo $i; ?>" value="<?php echo $row_service['quantity'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit[]" id="unit_<?php echo $i; ?>" value="<?php echo $row_service['unit'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit_cost[]" id="unit_cost_<?php echo $i; ?>" value="<?php echo $row_service['unit_cost'] ?>"></td>
                        <td><input type="text" readonly class="form-control" name="unit_price[]" id="unit_price_<?php echo $i; ?>" value="<?php echo $row_service['unit_price'] ?>"></td>
                    </tr>

                <?php } ?>
                <div id="counter" hidden><?php echo $result_service->num_rows ?></div>
            </tbody>
        </table>

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