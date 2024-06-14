<?php


session_start();
$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");
$job_id = $_POST['job_id'];

$sql = "SELECT a.*,b.branch_name AS cus_branch,b.branch_code,b.google_map_link,c.customer_name,d.fullname,d.mobile_phone,e.branch_name,f.serial_no,f.warranty_start_date,f.warranty_expire_date,f.buy_date,f.install_date,g.brand_name,h.model_name,b.address AS baddress,b.address2 AS baddress2,f.warranty_type as product_warranty_type,f.product_type,i.type_code,i.type_name,b.district_id,j.fullname as create_fullname,k.sub_type_name FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_product f ON a.product_id = f.product_id
LEFT JOIN tbl_product_brand g ON f.brand_id = g.brand_id
LEFT JOIN tbl_product_model h ON f.model_id = h.model_id
LEFT JOIN tbl_product_type i ON f.product_type = i.type_id
LEFT JOIN tbl_user j ON j.user_id = a.create_user_id
LEFT JOIN tbl_sub_job_type k ON k.sub_job_type_id = a.sub_job_type_id
WHERE a.job_id = '$job_id' ;";
$result = mysqli_query($connection, $sql);
$row = mysqli_fetch_array($result);
// echo $sql;
// echo $job_id;

$sql_open_service = "SELECT * FROM tbl_job_open_oth_service a
LEFT JOIN tbl_income_type b ON a.service_id = b.income_type_id
 WHERE a.job_id = '$job_id' ORDER BY a.list_order";
$result_open_service = mysqli_query($connection, $sql_open_service);

// $sql_app = "SELECT COUNT(close_approve_id) as num FROM tbl_job_close_approve WHERE job_id = '$job_id' and approve_user_id = '$approve_user_id' AND approve_result = 0";
// $result_app  = mysqli_query($connection, $sql_app);
// $row_app = mysqli_fetch_array($result_app);


$overhaul_id = $row['overhaul_id'];



// $sql_qt = "SELECT COUNT(quotation_approve_id) as num FROM tbl_job_quotation_approve WHERE job_id = '$job_id' and approve_user_id = '$approve_user_id' AND approve_result is NULL ORDER BY create_datetime limit 1 ";
// $result_qt  = mysqli_query($connection, $sql_qt);
// $row_qt = mysqli_fetch_array($result_qt);

// $sql_qt1 = "SELECT *FROM tbl_job_quotation_approve WHERE job_id = '$job_id' and approve_user_id = '$approve_user_id' AND approve_result is NULL ORDER BY create_datetime limit 1 ";
// $result_qt1  = mysqli_query($connection, $sql_qt1);
// $row_qt1 = mysqli_fetch_array($result_qt1);

// $quotation_approve_id = $row_qt1['quotation_approve_id'];



////////////////////////////////query refjob///////////////////
$sql_ref = "SELECT a.*,b.job_id AS ref_id,b.job_no as refjob_no FROM tbl_job_ref a
LEFT JOIN tbl_job b ON a.ref_job_id = b.job_id
 WHERE a.job_id = '$job_id'";
$result_ref = mysqli_query($connection, $sql_ref);

// echo $sql_ref;

if ($row['job_type'] == 3) {

    $sql_in_product = "SELECT * FROM tbl_in_product a
    LEFT JOIN tbl_product f ON a.product_id = f.product_id
    LEFT JOIN tbl_product_brand g ON f.brand_id = g.brand_id
    LEFT JOIN tbl_product_model h ON f.model_id = h.model_id
    LEFT JOIN tbl_product_type i ON f.product_type = i.type_id
    WHERE job_id = '$job_id'";
    $result_in_product = mysqli_query($connection, $sql_in_product);
}


if ($row['job_type'] == 2) {

    $sql_group = "SELECT * FROM tbl_group_pm_detail WHERE job_id = '$job_id'";
    $result_group = mysqli_query($connection, $sql_group);
    $num_group = mysqli_num_rows($result_group);

    $have_data = 1;
    if ($num_group > 0) {

        $have_data = 2;
    }

    $sql_pm_setting = "SELECT * FROM tbl_pm_setting WHERE column";
    $res_pm_setting = mysqli_query($connection, $sql_pm_setting);
    $row_pm_setting = mysqli_fetch_assoc($res_pm_setting);
}



////////////////////address
$sql_address = "SELECT a.district_name_th,a.district_zipcode,b.amphoe_name_th,c.province_name_th FROM tbl_district a 
LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
LEFT JOIN tbl_province c ON b.ref_province = c.province_id
 WHERE a.district_id = '{$row['district_id']}'";
$rs_address = mysqli_query($connection, $sql_address);
$row_address = mysqli_fetch_array($rs_address);

?>
<div role="tabpanel" id="" class="tab-pane1 active">
    <div class="col-lg-12">
        <?php if ($current_user_id == $row['responsible_user_id'] || $admin_status == 9) { ?>
            <div class="row">
                <div class="col-md-2">
                    <br>
                    <button type="button" onclick="Modal_menu_button('<?php echo $job_id ?>');" class="btn btn-success btn-lg btn-block">
                        ดำเนินการ</button>
                </div>
                <div class="col-md-2">
                    <br>
                    <button type="button" onclick="Modal_history_product('<?php echo $row['product_id'] ?>','<?php echo $job_id ?>')" class="btn btn-success btn-lg btn-block">
                        ประวัติการซ่อม</button>
                </div>
                <!-- <?php if ($row_app['num'] == 1) { ?>
                    <div class="col-md-2">
                        <br>

                        <button type="button" onclick="Modal_approve_close('<?php echo $job_id ?>');" class="btn btn-success btn-lg btn-block">
                            การอนุมัติปิดงาน</button>
                    </div>
                <?php } ?>
                <?php if ($row_qt['num'] == 1) { ?>
                    <div class="col-md-2">
                        <br>

                        <button type="button" onclick="Modal_approve_qt('<?php echo $quotation_approve_id ?>');" class="btn btn-success btn-lg btn-block">
                            การอนุมัติใบเสนอราคา</button>
                    </div>
                <?php } ?> -->

                <?php if ($row['job_type'] == 2) { ?>

                    <div class="col-md-2">
                        <br>
                        <button type="button" onclick="Modal_group_pm('<?php echo $job_id ?>','<?php echo $row['customer_branch_id'] ?>','<?php echo $have_data ?>')" class="btn btn-success btn-lg btn-block">
                            รวมงาน</button>
                    </div>

                <?php } ?>

                <?php if ($row['close_user_id'] == "") { ?>
                    <div class="col-md-2">
                        <br>
                        <a href="form_edit_job.php?id=<?php echo $job_id ?>"><button type="button" class="btn btn-warning btn-lg btn-block">
                                แก้ไข</button></a>
                    </div>
                <?php } ?>

                <?php if ($row['finish_service_time'] != "") { ?>
                    <div class="col-md-2">
                        <br>
                        <a href="../../../print/Receipt _CRM.php?job_id=<?php echo $job_id ?>" target="_blank"><button type="button" class="btn btn-secondary btn-lg btn-block">
                                ใบเสร็จชั่วคราว</button></a>
                    </div>
                <?php } ?>
            </div>
        <?php } ?>
    </div>
    <br>


    <div class="ibox">
        <div class="ibox-content">
            <?php

            $type = "";
            if ($row['job_type'] == 1) {
                $type = "CM";
            } else if ($row['job_type'] == 2) {
                $type = "PM";
            } else if ($row['job_type'] == 3) {
                $type = "Installation";
            } else if ($row['job_type'] == 5) {
                $type = "งานอื่นๆ";
            } else if ($row['job_type'] == 4) {
                $type = 'OVERHAUL';
            } else if ($row['job_type'] == 6) {
                $type = 'เสนอราคา';
            }

            if ($row['warranty_start_date'] != null) {
                $warranty_start_date = date('d-m-Y', strtotime($row['warranty_start_date']));
            } else {
                $warranty_start_date = "ไม่ระบุ";
            }

            if ($row['warranty_expire_date'] != null) {
                $warranty_expire_date = date('d-m-Y', strtotime($row['warranty_expire_date']));
            } else {
                $warranty_expire_date = "ไม่ระบุ";
            }

            if ($row['install_date'] != null) {
                $install_date = date('d-m-Y', strtotime($row['install_date']));
            } else {
                $install_date = "ไม่ระบุ";
            }

            $today = date("d-m-Y");
            $today_time = strtotime($today);
            // $expire_time = strtotime($expire);

            $chk_date = "";
            if ($row['warranty_expire_date'] == null) {
                $warranty = "ไม่มีข้อมูล";
            } else {

                $now = strtotime("today");
                $expire_date = strtotime($row['warranty_expire_date']);
                $datediff = $expire_date - $now;

                $days_remain = round($datediff / (60 * 60 * 24));
                if ($days_remain <= 0) {
                    $total_remain = "<font color=red>" . "หมดอายุ " . "</font>";
                } else {
                    $total_remain = "เหลือ " . $days_remain . " วัน";
                }
                $warranty = date("d-m-Y", strtotime($row['warranty_expire_date'])) . "<br>" . $total_remain;
            }

            $warranty_type = "ไม่ระบุ";
            if ($row['product_warranty_type'] == 1) {
                $warranty_type = "ซื้อจากบริษัท";
            } elseif ($row['product_warranty_type'] == 2) {
                $warranty_type = "ไม่ได้ซื้อจากบริษัท";
            } elseif ($row['product_warranty_type'] == 3) {
                $warranty_type = "สัญญาบริการ";
            }


            $product_type = $row['type_code'] . " - " . $row['type_name'];

            ?>

            <br>
            <div class="row">
                <input type="hidden" id="job_id" name="job_id" value="<?php echo $job_id ?>">
                <div class="col-lg-6">
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ประเภทงาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $type; ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ชื่องาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo ($row['sub_type_name'] != "") ? $row['sub_type_name'] : "-" ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ชื่อร้าน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['branch_code'] . " - " . $row['cus_branch']; ?>
                                <a href="<?php echo $row['google_map_link'] ?>" target="_blank" class="btn btn-info btn-xs">แผนที่</a>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ผู้ติดต่อ :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['contact_name'] != "") {
                                    echo $row['contact_name'] .
                                        ' ( ' . $row['contact_position'] . ' ) - 
                                                [ ' . $row['contact_phone'] . ' ]';
                                } else {
                                    echo "ไม่ระบุ";
                                } ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>วันที่สร้างรายการ :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo date('d-m-Y H:i', strtotime($row['create_datetime'])); ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ผู้ออกใบงาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['create_fullname']; ?>
                            </dd>
                        </div>
                    </dl>

                    <!-- <?php if ($row['job_type'] == 2) { ?>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รอบ :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row['list_pm_job']; ?>
                                </dd>
                            </div>
                        </dl>
                    <?php } ?> -->
                    <br>
                    <hr>

                    <?php if ($row['job_type'] == 1) { ?>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>S/N :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row['serial_no']; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รุ่น :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php if ($row['model_name'] != "") {
                                        echo $row['model_name'] .
                                            '(' . $row['brand_name'] . ')';
                                    } else {
                                        echo "ไม่ระบุ";
                                    } ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>ประเภทเครื่อง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $product_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>การรับประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันที่ติดตั้ง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $install_date; ?>
                                </dd>
                            </div>
                        </dl>


                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันหมดประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty; ?>
                                </dd>
                            </div>
                        </dl>

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>อาการเสียเบื้องต้น </dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd>
                                    <?php echo $row['initial_symptoms']; ?>
                                </dd>
                            </div>
                        </dl>
                        <?php } else if ($row['job_type'] == 3) {
                        while ($row_in_product = mysqli_fetch_array($result_in_product)) {


                            $warranty_type_in = "ไม่ระบุ";
                            if ($row_in_product['warranty_type'] == 1) {
                                $warranty_type_in = "ซื้อจากบริษัท";
                            } elseif ($row_in_product['warranty_type'] == 2) {
                                $warranty_type_in = "ไม่ได้ซื้อจากบริษัท";
                            } elseif ($row_in_product['warranty_type'] == 3) {
                                $warranty_type_in = "สัญญาบริการ";
                            }


                            if ($row_in_product['warranty_start_date'] != null) {
                                $warranty_start_date = date('d-m-Y', strtotime($row_in_product['warranty_start_date']));
                            } else {
                                $warranty_start_date = "ไม่ระบุ";
                            }

                            if ($row_in_product['warranty_expire_date'] != null) {
                                $warranty_expire_date = date('d-m-Y', strtotime($row_in_product['warranty_expire_date']));
                            } else {
                                $warranty_expire_date = "ไม่ระบุ";
                            }

                            if ($row_in_product['install_date'] != null) {
                                $install_date = date('d-m-Y', strtotime($row_in_product['install_date']));
                            } else {
                                $install_date = "ไม่ระบุ";
                            }

                            if ($row_in_product['warranty_expire_date'] == null) {
                                $warranty_expire_date = 'ไม่มีข้อมูล';
                            } else {
                                $warranty_expire_date = date("d-m-Y", strtotime($row_in_product['warranty_expire_date']));
                                $now = strtotime("today");
                                $expire_date = strtotime($row_in_product['warranty_expire_date']);
                                $datediff = $expire_date - $now;

                                $days_remain = round($datediff / (60 * 60 * 24));
                                if ($days_remain <= 0) {
                                    $chk_date = $warranty_expire_date . " <font color=red>" . "( หมดอายุ " . abs($days_remain) . " วัน )" . "</font>";
                                } else {
                                    $chk_date = $warranty_expire_date;
                                }
                            }


                            $product_type = $row_in_product['type_code'] . " - " . $row_in_product['type_name'];


                        ?>

                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>S/N :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php echo $row_in_product['serial_no']; ?>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>รุ่น :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php if ($row_in_product['model_name'] != "") {
                                            echo $row_in_product['model_name'] .
                                                ' ( ' . $row_in_product['brand_name'] . ' ) ';
                                        } else {
                                            echo "ไม่ระบุ";
                                        } ?>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>ประเภทเครื่อง :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php echo $product_type ?>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>การรับประกัน :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php echo $warranty_type_in ?>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>วันที่ติดตั้ง :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php echo $install_date; ?>
                                    </dd>
                                </div>
                            </dl>
                            <dl class="row mb-0">
                                <div class="col-sm-4 text-sm-left">
                                    <dt>วันหมดประกัน :</dt>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                    <dd class="mb-1">
                                        <?php echo $chk_date; ?>
                                    </dd>
                                </div>
                            </dl>

                            <hr>
                        <?php }
                    } else if ($row['job_type'] == 4) { ?>

                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>S/N :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row['serial_no']; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รุ่น :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php if ($row['model_name'] != "") {
                                        echo $row['model_name'] .
                                            '(' . $row['brand_name'] . ')';
                                    } else {
                                        echo "ไม่ระบุ";
                                    } ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>ประเภทเครื่อง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $product_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>การรับประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันที่ติดตั้ง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $install_date; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันหมดประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty; ?>
                                </dd>
                            </div>
                        </dl>


                    <?php } else if ($row['job_type'] == 2 || $row['job_type'] == 6) { ?>


                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>S/N :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row['serial_no']; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รุ่น :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php if ($row['model_name'] != "") {
                                        echo $row['model_name'] .
                                            '(' . $row['brand_name'] . ')';
                                    } else {
                                        echo "ไม่ระบุ";
                                    } ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>ประเภทเครื่อง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $product_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>การรับประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty_type ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันที่ติดตั้ง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $install_date; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันหมดประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $warranty; ?>
                                </dd>
                            </div>
                        </dl>



                    <?php } ?>

                    <br>
                    <hr>
                    <?php if ($row['overhaul_id'] != NULL) {


                        $sql_oh = "SELECT * FROM  tbl_overhaul f 
                        LEFT JOIN tbl_product_brand g ON f.brand_id = g.brand_id
                        LEFT JOIN tbl_product_model h ON f.model_id = h.model_id
                        LEFT JOIN tbl_product_type i ON f.product_type = i.type_id
                        WHERE f.overhaul_id = '{$row['overhaul_id']}'";
                        $rs_oh = mysqli_query($connection, $sql_oh);
                        $row_oh = mysqli_fetch_array($rs_oh);
                    ?>
                        <div class="row mb-2">
                            <div class="col-sm-12 text-sm-left">
                                <dt>เครื่องทดแทน</dt>
                            </div>
                        </div>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>S/N :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row_oh['serial_no']; ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รุ่น :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php if ($row_oh['model_name'] != "") {
                                        echo $row_oh['model_name'] .
                                            '(' . $row_oh['brand_name'] . ')';
                                    } else {
                                        echo "ไม่ระบุ";
                                    } ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>ประเภทเครื่อง :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo $row_oh['type_code'] . " - " . $row_oh['type_name'] ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>การรับประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo ($row_oh['warranty_start_date'] != NULL && $row_oh['warranty_start_date'] != '1970-01-01') ? date("d-m-Y", strtotime($row_oh['warranty_start_date'])) : '' ?>
                                </dd>
                            </div>
                        </dl>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>วันหมดประกัน :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php echo ($row_oh['warranty_end_date'] != NULL && $row_oh['warranty_end_date'] != '1970-01-01') ? date("d-m-Y", strtotime($row_oh['warranty_end_date'])) : '' ?>
                                </dd>
                            </div>
                        </dl>

                    <?php } ?>
                    <br>
                </div>

                <div class="col-lg-6" id="cluster_info">
                    <?php if ($row['job_type'] == 2) { ?>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รอบการ PM :</dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1">
                                    <?php
                                    if ($row['list_pm_job'] != null) {
                                        echo $row['list_pm_job'] . " / " . date('Y', strtotime($row['create_datetime']));
                                    } else {
                                        echo "-";
                                    }; ?>
                                </dd>
                            </div>
                        </dl>
                    <?php } ?>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>สถานะ :</dt>
                        </div>
                        <?php if ($row['cancel_datetime'] != null) { ?>
                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"><span class="label label-danger">ยกเลิกงาน</span></dd>
                            </div>
                        <?php } else if ($row['close_datetime'] != null) { ?>

                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"><span class="label label-warning">ปิดงาน</span></dd>
                            </div>

                        <?php } else if ($row['finish_service_time'] != null) { ?>

                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"><span class="label label-info">รอปิดงาน</span></dd>
                            </div>

                        <?php } else if ($row['start_service_time'] != null) { ?>

                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"><span class="label label-success">กำลังดำเนินการ</span></dd>
                            </div>

                        <?php } else if ($row['start_service_time'] == null) { ?>

                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-1"><span class="label label-primary">เปิดงาน</span></dd>
                            </div>

                        <?php } ?>


                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>วันที่นัดหมาย :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php
                                if ($row['appointment_date'] != null) {
                                    echo date('d-m-Y', strtotime($row['appointment_date']));
                                } else {
                                    echo "-";
                                }; ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>วันที่เข้า-ออกงาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['start_service_time'] != null) {
                                    echo date('d-m-Y', strtotime($row['start_service_time']));
                                } else {
                                    echo "-" . "</br>";
                                } ?>

                                <?php if ($row['finish_service_time'] != null && date('d-m-Y', strtotime($row['start_service_time'])) !== date('d-m-Y', strtotime($row['finish_service_time']))) {
                                    echo " - " . date('d-m-Y', strtotime($row['finish_service_time']));
                                } ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>เวลาที่เข้างาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['start_service_time'] != null) {
                                    echo date('H : i', strtotime($row['start_service_time']));
                                } else {
                                    echo "-" . "</br>";
                                } ?>


                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>เวลาที่ออกงาน :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['finish_service_time'] != null) {
                                    echo date('H : i', strtotime($row['finish_service_time']));
                                } else {
                                    echo "-" . "</br>";
                                } ?>
                            </dd>
                        </div>
                    </dl>

                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>SO :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['so_no'] != "") {
                                    echo $row['so_no'];
                                } else {
                                    echo "-" . "</br>";
                                } ?>
                            </dd>
                        </div>
                    </dl>
                    <hr>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ที่อยู่สาขา :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php echo $row['baddress'] . "</br>" .
                                    $row['baddress2']; ?>
                                <?php echo "ต." . $row_address['district_name_th'] . " อ." . $row_address['amphoe_name_th'] . " จ." . $row_address['province_name_th'] . " " . $row_address['district_zipcode'] ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ผู้รับผิดชอบ :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['fullname'] != "") {
                                    echo $row['fullname'] .
                                        '[' . $row['mobile_phone'] . ']';
                                } else {
                                    echo "ไม่ระบุ";
                                } ?>
                            </dd>
                        </div>
                    </dl>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>ทีม :</dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-1">
                                <?php if ($row['branch_name'] != "") {
                                    echo $row['branch_name'];
                                } else {
                                    echo "ไม่ระบุ";
                                }; ?>
                            </dd>
                        </div>
                    </dl>
                    <br>


                    <?php if ($row['job_type'] == 5) { ?>
                        <dl class="row mb-0">
                            <div class="col-sm-4 text-sm-left">
                                <dt>รายละเอียดงาน </dt>
                            </div>
                            <div class="col-sm-8 text-sm-left">
                            </div>

                            <div class="col-sm-8 text-sm-left">
                                <dd class="mb-0">
                                    <?php echo $row['job_detail'] ?>
                                </dd>
                            </div>
                        </dl>
                    <?php } ?>
                    <dl class="row mb-0">
                        <div class="col-sm-4 text-sm-left">
                            <dt>หมายเหตุ </dt>
                        </div>
                        <div class="col-sm-8 text-sm-left">
                        </div>

                        <div class="col-sm-8 text-sm-left">
                            <dd class="mb-0">
                                <?php echo $row['remark'] ?>
                            </dd>
                        </div>
                    </dl>


                </div>
                <div class="col-12">
                    <label>
                        <dt>ค่าบริการเปิดงาน</dt>
                    </label>
                    <div class="row">

                        <div class="col-4 mb-1">
                            <b>รายการ</b>
                        </div>

                        <div class="col-3 mb-1">
                            <b>ราคาต่อหน่วย</b>
                        </div>

                        <div class="col-3 mb-1">
                            <b>จำนวน</b>
                        </div>

                        <div class="col-2 mb-1">
                            <b>รวม</b>
                        </div>

                    </div>
                    <div class="row">
                        <?php while ($row_open_service = mysqli_fetch_array($result_open_service)) { ?>
                            <div class="col-4 mb-2">
                                <?php echo "[" . $row_open_service['income_code'] . "] -" . $row_open_service['income_type_name']; ?>
                            </div>

                            <div class="col-3 mb-2">
                                <?php echo number_format($row_open_service['unit_cost'], 1) . " " . $row_open_service['unit']; ?>
                            </div>

                            <div class="col-3 mb-2">
                                <?php echo number_format($row_open_service['quantity']); ?>
                            </div>

                            <div class="col-2 mb-2">
                                <?php echo number_format($row_open_service['unit_price'], 1); ?>
                            </div>
                        <?php } ?>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="ibox">
        <div class="ibox-title" style="padding: 15px 0px 0px 10px;">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <h4>งานที่เกี่ยวข้อง</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="ibox-content">
            <div class="col-lg-12">
                <div class="row">
                    <?php while ($row_ref = mysqli_fetch_array($result_ref)) { ?>
                        <div class="col-md-1">
                            <br>
                            <a href="view_cm.php?id=<?php echo $row_ref['ref_id'] ?>" target="_blank"><button type="button" class="btn btn-info btn-xs">
                                    <?php echo $row_ref['refjob_no'] ?>
                                </button></a>
                        </div>
                    <?php } ?>

                </div>
            </div>
        </div>
    </div>


    <div class="ibox">


        <div class="ibox-content">
            <div class="tabs-container" style="margin-top: 2ex;">
                <ul class="nav nav-tabs">
                    <li><a class="nav-link tab_head active" id="tab_head_1" onclick="load_table_total_service()" href="#tab-1" data-toggle="tab">อะไหล่และบริการ</a></li>
                    </li>

                    <!-- <li><a class="nav-link tab_head" id="tab_head_2" onclick="load_table_spare()" href="#tab-2" data-toggle="tab">รายการอะไหล่</a></li> -->
                    <?php if ($row['job_type'] == 1) { ?>
                        <li><a class="nav-link tab_head" id="tab_head_8" onclick="load_fixed_detail()" href="#tab-8" data-toggle="tab">แจ้งปัญหาการซ่อม</a></li>
                    <?php } else if ($row['job_type'] == 2 || $row['job_type'] == 3 || $row['job_type'] == 4 || $row['job_type'] == 5) { ?>
                        <li><a class="nav-link tab_head" id="tab_head_8" onclick="load_pm_detail()" href="#tab-8" data-toggle="tab">รูปรายละเอียด</a></li>

                    <?php } ?>
                    <!-- <li><a class="nav-link tab_head" id="tab_head_4" onclick="load_table_close_app()" href="#tab-4" data-toggle="tab">บันทึกปิดงาน</a></li> -->
                    <li><a class="nav-link tab_head" id="tab_head_5" onclick="load_table_expend()" href="#tab-5" data-toggle="tab">บันทึกค่าใช้จ่าย</a></li>
                    <li><a class="nav-link tab_head" id="tab_head_6" onclick="load_table_daily()" href="#tab-6" data-toggle="tab">บันทึกประจำวัน</a></li>
                    <li><a class="nav-link tab_head" id="tab_head_7" onclick="load_table_job_payment()" href="#tab-7" data-toggle="tab">บันทึกการจ่ายเงิน</a></li>
                    <?php if ($row['job_type'] == 4 || $row['job_type'] == 1) { ?>
                        <li><a class="nav-link tab_head" id="tab_head_9" href="#tab-9" onclick="load_overhaul('<?php echo $row['overhaul_id'] ?>')" data-toggle="tab">เครื่องทดแทน</a></li>
                    <?php } ?>
                    <?php if ($row['job_type'] == 4) { ?>
                        <li><a class="nav-link tab_head" id="tab_head_10" onclick="load_sub_oh()" href="#tab-10" data-toggle="tab">งานย่อย OH</a></li>
                    <?php } ?>
                </ul>

                <div class="tab-content">
                    <div role="tabpanel" id="tab-1" class="tab-pane active">
                        <div id="Loading_total_service">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_table_total_service">
                        </div>
                    </div>

                    <!-- <div role="tabpanel" id="tab-2" class="tab-pane">
                        <div id="Loading_spare">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_table_spare_part">
                        </div>
                    </div> -->
                    <?php if ($row['job_type'] == 1) { ?>
                        <div role="tabpanel" id="tab-8" class="tab-pane">
                            <div id="Loading_show_fixed">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-wave">
                                        <div class="sk-rect1"></div>
                                        <div class="sk-rect2"></div>
                                        <div class="sk-rect3"></div>
                                        <div class="sk-rect4"></div>
                                        <div class="sk-rect5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" id="show_fixed_detail">
                            </div>
                        </div>
                    <?php } else if ($row['job_type'] == 2 || $row['job_type'] == 3 || $row['job_type'] == 4 || $row['job_type'] == 5) { ?>

                        <div role="tabpanel" id="tab-8" class="tab-pane">
                            <div id="Loading_show_Pm">
                                <div class="spiner-example">
                                    <div class="sk-spinner sk-spinner-wave">
                                        <div class="sk-rect1"></div>
                                        <div class="sk-rect2"></div>
                                        <div class="sk-rect3"></div>
                                        <div class="sk-rect4"></div>
                                        <div class="sk-rect5"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body" id="show_Pm_detail">
                            </div>
                        </div>




                    <?php } ?>

                    <!-- <div role="tabpanel" id="tab-4" class="tab-pane">
                        <div id="Loading_close">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_close_app">
                        </div>
                    </div> -->

                    <div role="tabpanel" id="tab-5" class="tab-pane">
                        <div id="Loading_expend">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_table_expend">
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-6" class="tab-pane">
                        <div id="Loading_daily">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_daily_table">
                        </div>
                    </div>
                    <div role="tabpanel" id="tab-7" class="tab-pane">
                        <div id="Loading_payment">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_table_payment">
                        </div>
                    </div>


                    <div role="tabpanel" id="tab-9" class="tab-pane">

                        <div class="panel-body" id="show_overhaul">
                        </div>
                    </div>

                    <div role="tabpanel" id="tab-10" class="tab-pane">
                        <div id="Loading_sub_oh">
                            <div class="spiner-example">
                                <div class="sk-spinner sk-spinner-wave">
                                    <div class="sk-rect1"></div>
                                    <div class="sk-rect2"></div>
                                    <div class="sk-rect3"></div>
                                    <div class="sk-rect4"></div>
                                    <div class="sk-rect5"></div>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body" id="show_sub_oh">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>