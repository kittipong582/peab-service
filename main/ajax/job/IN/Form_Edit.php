<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];
$job_type = $_POST['job_type'];


$sql = "SELECT *,a.remark AS Aremark,b.branch_name as team_name,e.customer_id AS eid FROM tbl_job a 
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
$customer_id = $row['eid'];
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


///////////////////product id branch /////////////////////
$sql_product = "SELECT * FROM tbl_product WHERE current_branch_id = '$customer_branch_id'";
$result_product  = mysqli_query($connect_db, $sql_product);



/////////////////////in_product///////////////
$sql_in_product = "SELECT * FROM tbl_in_product a
LEFT JOIN tbl_product b ON a.product_id = b.product_id
LEFT JOIN tbl_product_brand c ON c.brand_id = b.brand_id
LEFT JOIN tbl_product_model d ON d.model_id = b.model_id
WHERE a.job_id = '$job_id'";
$result_in_product  = mysqli_query($connect_db, $sql_in_product);
$num_in_product = mysqli_num_rows($result_in_product);
?>
<?php include("../Edit/form_edit_customer_branch.php"); ?>
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

        <input type="text"  id="contact_name" value="<?php echo $contact_name ?>" name="contact_name" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ตำแหน่ง</label>

        <input type="text"  id="contact_position" value="<?php echo $contact_position ?>" name="contact_position" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>เบอร์โทรติดต่อ</label>

        <div class="input-group">
            <input type="text"  id="contact_phone" value="<?php echo $contact_phone ?>" name="contact_phone" class="form-control">
        </div>

    </div>

</div>

<strong>
    <h4>2.ข้อมูลสินค้า</h4>
</strong>

<div class="row mb-3 mt-3">
    <div id="product_counter" hidden><?php echo $num_in_product ?></div>

    <?php $i = 0;
    while ($row_in_product = mysqli_fetch_array($result_in_product)) {

        $sql_type = "SELECT * FROM tbl_product_type WHERE active_status = 1 ORDER BY type_code";
        $result_type  = mysqli_query($connect_db, $sql_type);

        $i++; ?>
        <div class="row mb-3" id="row_product_<?php echo $i ?>">
            <input type="hidden" id="product_id_<?php echo $i ?>" value="<?php echo $row_in_product['product_id'] ?>" name="product_id[]">
            <div class="mb-3 col-12">
                <button type="button" class="btn btn-danger btn-sm" name="button" onclick="desty_product('<?php echo $i; ?>')"><i class="fa fa-times" aria-hidden="true"></i></button>
            </div>
            <div class="mb-3 col-3">
                <label>Serial No</label>
                <div class="input-group">
                    <input type="text" id="serial_no_<?php echo $i ?>" value="<?php echo $row_in_product['serial_no'] ?>" name="serial_no[]" class="form-control">
                    <span class="input-group-append"><button type="button" id="btn_ref_<?php echo $i ?>" onclick="search_product('<?php echo $i ?>');" name="btn_ref" class="btn btn-warning">ตรวจสอบ</button></span>
                </div>
            </div>
            <div class="mb-3 col-3" id="point_type_<?php echo $i ?>">
                <label>ประเภทเครื่อง</label>
                <font color="red">**</font>
                <select name="product_type[]" id="product_type_<?php echo $i ?>" style="width: 100%;" class="form-control select2 mb-3 ">
                    <option value="">กรุณาเลือกเครื่อง</option>
                    <?php while ($row_type = mysqli_fetch_array($result_type)) { ?>

                        <option value="<?php echo $row_type['type_id'] ?>" <?php if ($row_type['type_id'] == $row_in_product['product_type']) {
                                                                                echo "SELECTED";
                                                                            } ?>><?php echo $row_type['type_code'] . " - " . $row_type['type_name'] ?></option>
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

                        <option value="<?php echo $row_brand['brand_id'] ?>" <?php if ($row_brand['brand_id'] == $row_in_product['brand_id']) {
                                                                                    echo "SELECTED";
                                                                                } ?>><?php echo $row_brand['brand_name'] ?></option>
                    <?php } ?>
                </select>
            </div>
            <div class="mb-3 col-3" id="point_model_<?php echo $i ?>">
                <label>รุ่น</label>
                <font color="red">**</font>
                <div class="" id="getmodel_<?php echo $i ?>">
                    <select class="form-control select2 mb-3" style="width: 100%;" name="model_id[]" id="model_id">
                        <option value="">กรุณาเลือกรุ่น</option>
                        <?php $sql_model = "SELECT * FROM tbl_product_model WHERE active_status = '1'";
                        $result_model  = mysqli_query($connect_db, $sql_model);
                        while ($row_model = mysqli_fetch_array($result_model)) { ?>

                            <option value="<?php echo $row_model['model_id'] ?>" <?php if ($row_model['model_id'] == $row_in_product['model_id']) {
                                                                                        echo "SELECTED";
                                                                                    } ?>><?php echo $row_model['model_name'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>

            <div class="mb-3 col-3" id="point_war_type_<?php echo $i ?>">
                <label>ประเภทการรับประกัน</label>
                <font color="red">**</font>
                <select name="warranty_type[]" id="warranty_type_<?php echo $i ?>" class="form-control select2 mb-3" style="width: 100%;">
                    <option value="">กรุณาเลือกประเภทประกัน</option>
                    <option value="1" <?php if (1 == $row_in_product['warranty_type']) {
                                            echo "SELECTED";
                                        } ?>>ซื้อจากบริษัท</option>
                    <option value="2" <?php if (2 == $row_in_product['warranty_type']) {
                                            echo "SELECTED";
                                        } ?>>ไม่ได้ซื้อจากบริษัท</option>
                    <option value="3" <?php if (3 == $row_in_product['warranty_type']) {
                                            echo "SELECTED";
                                        } ?>>สัญญาบริการ</option>

                </select>
            </div>

            <div class="mb-3 col-3" id="point_in_<?php echo $i ?>">
                <label>วันที่ติดตั้ง</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="install_date_<?php echo $i ?>" name="install_date[]" class="form-control datepicker" readonly value="<?php if ($row_in_product['install_date'] != null) {
                                                                    echo date("d-m-Y", strtotime($row_in_product['install_date']));
                                                                } ?>" autocomplete="off">
                </div>
            </div>

            <div class="mb-3 col-3" id="point_swar_<?php echo $i ?>">
                <label>วันที่เริ่มประกัน</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_start_date_<?php echo $i ?>" name="warranty_start_date[]" class="form-control datepicker" readonly value="<?php if ($row_in_product['warranty_start_date'] != null) {
                                                                    echo date("d-m-Y", strtotime($row_in_product['warranty_start_date']));
                                                                } ?>" autocomplete="off">
                </div>
            </div>

            <div class="mb-3 col-3" id="point_nwar_<?php echo $i ?>">
                <label>วันที่หมดประกัน</label>
                <div class="input-group date">
                    <span class="input-group-addon">
                        <i class="fa fa-calendar"></i>
                    </span>
                    <input type="text" id="warranty_expire_date_<?php echo $i ?>" name="warranty_expire_date[]" class="form-control datepicker" readonly value="<?php if ($row_in_product['warranty_expire_date'] != null) {
                                                                    echo date("d-m-Y", strtotime($row_in_product['warranty_expire_date']));
                                                                } ?>" autocomplete="off">
                </div>
            </div>
            <hr>
        </div>
    <?php } ?>
    <div class="col-12" id="add_product_row" name="add_product_row">
    </div>
</div>



<div class="row">
    <div class="col-md-12 mb-3">
        <button type="button" class="btn btn-sm btn-outline-primary" onclick="add_product_row();"><i class="fa fa-plus"></i>
            เพิ่มรายการ
        </button>
    </div>
</div>

<div class="row mb-3">
    <div class="mb-3 col-12">
        <strong>
            <h4>3.การนัดหมาย</h4>
        </strong>
    </div>
    <input type="hidden" readonly id="branch_care_id" value="<?php echo $care_branch_id ?>" name="branch_care_id" class="form-control">
    <div class="col-mb-3 col-3">
        <label>ทีมดูแล</label>

        <div class="input-group">
            <input type="text" id="branch_care" value="<?php echo $row['team_name']  ?>" readonly name="branch_care" class="form-control">
            <?php if ($user_level != 1 && $user_level != 2) { ?>
                        <span class="input-group-append"><button type="button" id="btn_branch" name="btn_branch" onclick="Other_care()" class="btn btn-primary">เลือกทีมอื่น</button></span>
                    <?php } ?>

        </div>
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
        <!-- <input  readonly class="form-control" value="<?php echo $fullname ?>">
        <input type="hidden" id="responsible_user_id" name="responsible_user_id" readonly class="form-control" value="<?php echo $row['responsible_user_id'] ?>"> -->
    </div>
    <div class="mb-3 col-3">
        <label>วันที่นัดหมาย</label>

        <div class="input-group date">
            <span class="input-group-addon">
                <i class="fa fa-calendar"></i>
            </span>
            <input type="text" id="appointment_date" name="appointment_date" value="<?php echo (!empty($row['appointment_date'])) ? date("d-m-Y", strtotime($row['appointment_date'])) : ""; ?>" class="form-control datepicker" value="" autocomplete="off">
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
            <h4>4.ค่าบริการ</h4>
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
            <h4>5.หมายเหตุ</h4>
        </strong>
    </div>
    <div class="col-mb-3 col-12">

        <textarea type="text" id="note" name="note" class="summernote"> <?php echo $row['Aremark'] ?></textarea>
    </div>

</div>
<div class="text-center">
    <button class="btn btn-primary px-5" type="button" id="submit" onclick="Update_job()">บันทึก</button>
</div>