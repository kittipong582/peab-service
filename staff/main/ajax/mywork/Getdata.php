<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();

$start_date = $_POST['start_date'];
$start_date = explode('/', $_POST['start_date']);
$start_date = date('Y-m-d', strtotime($start_date['0'] . "-" . $start_date['1'] . "-" . $start_date['2']));

$end_date = $_POST['end_date'];
$end_date = explode('/', $_POST['end_date']);
$end_date = date('Y-m-d', strtotime($end_date['0'] . "-" . $end_date['1'] . "-" . $end_date['2']));
$customer_branch_code = $_POST['search'];

$condition = '';

if ($customer_branch_code != "") {
    $condition .= "AND b.branch_code = '$customer_branch_code'";
}

if ($_POST['chk'] != 2) {

    $condition .= '';
} else {
    $condition .= "AND a.close_user_id is NULL AND finish_service_time IS NULL";
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT a.*,b.branch_code,b.branch_name AS cus_branch_name,b.google_map_link,c.serial_no,d.model_name,b.district_id,sub_type_name FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_product c ON a.product_id = c.product_id
LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
LEFT JOIN tbl_sub_job_type k ON k.sub_job_type_id = a.sub_job_type_id
WHERE a.responsible_user_id = '$user_id' $condition $condition1 AND (a.appointment_date BETWEEN '$start_date' AND  '$end_date') and a.job_id not in(select job_id from tbl_group_pm_detail )";
// echo $sql;
$result  = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($result);
// $row = mysqli_fetch_array($result);

$work_list = array();
while ($row = mysqli_fetch_array($result)) {
    $style_job = "";
    if ($row['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {
        $status = "ปิดงาน";
        $style_job = "style='color: red;'";
    } else if ($row['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
        $status =  "กำลังดำเนินการ" . "  " . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {
        $status = "เปิดงาน";
    }





    $status_oh = '';
    if ($row['job_type'] == 4) {
        // if ($row['pay_oh_datetime'] != null) {
        //     $status_oh = '(ชำระแล้ว)';
        // } else if ($row['send_qcoh_datetime'] != null) {
        //     $status_oh = '(ส่ง QC แล้ว)';
        // } else if ($row['get_qcoh_datetime'] != null) {
        //     $status_oh = '(เปิด QC แล้ว)';
        // } else if ($row['send_oh_datetime'] != null) {
        //     $status_oh = '(ล้างเครื่องเสร็จแล้ว)';
        // } else if ($row['get_oh_datetime'] != null) {
        //     $status_oh = '(เปิดล้างเครื่องแล้ว)';
        // }
        $sql_oh_status = "SELECT * FROM tbl_job_oh WHERE user_id = '$user_id' AND job_id = '{$row['job_id']}' ";
        $rs_oh_status = mysqli_query($connect_db, $sql_oh_status);
        $row_oh_status = mysqli_fetch_assoc($rs_oh_status);


        if ($row_oh_status['oh_type'] == 1) {
            $status_oh = 'รับเครื่อง';
        } else if ($row_oh_status['oh_type'] == 2) {
            $status_oh = 'เปิดล้างเครื่อง';
        } else if ($row_oh_status['oh_type'] == 3) {
            $status_oh = 'ตรวจสภาพก่อนถอด';
        } else if ($row_oh_status['oh_type'] == 4) {
            $status_oh = 'แยกชิ้นส่วน';
        } else if ($row_oh_status['oh_type'] == 5) {
            $status_oh = 'แช่ล้าง';
        }else if ($row_oh_status['oh_type'] == 6) {
            $status_oh = 'ประกอบชิ้นส่วนพร้อมทดสอบ';
        }else if ($row_oh_status['oh_type'] == 7) {
            $status_oh = 'QC';
        }else if ($row_oh_status['oh_type'] == 8) {
            $status_oh = 'ส่งคืนเครื่อง';
        }

    }






    $temp_array = array(

        "create_user_id" => $row['create_user_id'],
        "job_type" => $row['job_type'],
        "cus_branch_name" => $row['cus_branch_name'],
        "create_user_name" => $row_create['fullname'],
        "status" => $status,
        "style_job" => $style_job,
        "status_oh" => $status_oh,
        "job_id" => $row['job_id'],
        "job_no" => $row['job_no'],
        "job_create" => $row['job_create'],
        "contact_name" => $row['contact_name'],
        "contact_phone" => $row['contact_phone'],
        "fullname" => $row['fullname'],
        "mobile_phone" => $row['mobile_phone'],
        "branch_name" => $row['branch_name'],
        "appointment_date" => $row['appointment_date'],
        "appointment_time" => $row['appointment_time'],
        "type" => '1',
        "model_name" => $row['model_name'],
        "branch_code" => $row['branch_code'],
        "district_id" => $row['district_id'],
        "sub_type_name" => $row['sub_type_name']
    );

    array_push($work_list, $temp_array);
}


$sql_chk = "SELECT * FROM tbl_group_pm
WHERE group_pm_id IN (select group_pm_id from tbl_group_pm_detail c 
LEFT JOIN tbl_job a ON a.job_id = c.job_id 
LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
WHERE a.responsible_user_id = '$user_id' $condition $condition1 ) AND (group_date BETWEEN '$start_date' AND  '$end_date')";
$result_chk  = mysqli_query($connect_db, $sql_chk);

// echo $sql_chk;
while ($row_chk = mysqli_fetch_array($result_chk)) {


    $group_pm_id = $row_chk['group_pm_id'];

    $sql_pm = "SELECT a.*,b.branch_code,b.branch_name AS cus_branch,b.district_id
    ,c.customer_name as cus_name,d.fullname,d.mobile_phone,e.branch_name,f.sub_type_name
    ,a.create_datetime AS job_create,b.branch_code AS cus_branch_code,c.customer_code,i.model_name
    FROM tbl_group_pm_detail g
    LEFT JOIN tbl_job a ON g.job_id = a.job_id
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id
    LEFT JOIN tbl_user d ON a.responsible_user_id = d.user_id
    LEFT JOIN tbl_branch e ON a.care_branch_id = e.branch_id
    LEFT JOIN tbl_sub_job_type f ON a.sub_job_type_id = f.sub_job_type_id
    LEFT JOIN tbl_product h ON a.product_id = h.product_id
    LEFT JOIN tbl_product_model i ON i.model_id = h.model_id
 WHERE group_pm_id = '$group_pm_id'";
    $result_pm  = mysqli_query($connect_db, $sql_pm);
    $row_pm = mysqli_fetch_array($result_pm);
    // echo $sql_pm;
    $style_job = "";
    if ($row['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row_chk['close_user_id'] != null) {
        $status = "ปิดงาน";
        $style_job = "style='color: red;'";
    } else if ($row_chk['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row_chk['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row_chk['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row_chk['start_service_time']))) / 60) * 10;
        $status =  "กำลังดำเนินการ" . "  " . $h . "." . number_format(abs($m));
    } else if ($row_chk['start_service_time'] == null) {
        $status = "เปิดงาน";
    }


    $temp_array = array(

        "create_user_id" => $row_pm['create_user_id'],
        "job_type" => $row_pm['job_type'],
        "cus_branch_name" => $row_pm['cus_branch'],
        "create_user_name" => $row_create['fullname'],
        "status" => $status,
        "style_job" => $style_job,
        "status_oh" => "",
        "job_id" => $row_chk['group_pm_id'],
        "job_no" => 'กลุ่มงาน PM',
        "job_create" => $row_pm['job_create'],
        "contact_name" => $row_pm['contact_name'],
        "contact_phone" => $row_pm['contact_phone'],
        "fullname" => $row_pm['fullname'],
        "mobile_phone" => $row_pm['mobile_phone'],
        "branch_name" => $row_pm['branch_name'],
        "appointment_date" => $row_pm['appointment_date'],
        "appointment_time" => $row_pm['appointment_time'],
        "type" => '2',
        "model_name" => $row_pm['model_name'],
        "branch_code" => $row_pm['branch_code'],
        "district_id" => $row_pm['district_id'],
        "sub_type_name" => $row_pm['sub_type_name']
    );

    array_push($work_list, $temp_array);
}





//////////////////////////////////////////oh ย่อย ////////////////////////////



$sql = "SELECT a.*,b.branch_code,b.branch_name AS cus_branch_name,b.google_map_link,c.serial_no,d.model_name,b.district_id,k.sub_type_name FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_product c ON a.product_id = c.product_id
LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
LEFT JOIN tbl_sub_job_type k ON k.sub_job_type_id = a.sub_job_type_id
WHERE job_id IN (SELECT job_id FROM tbl_job_oh WHERE user_id = '$user_id' AND appointment_datetime BETWEEN '$start_date' AND '$end_date')
AND a.job_type = 4 ";

// -- WHERE a.get_oh_user = '$user_id' $condition  AND (a.get_oh_datetime BETWEEN '$start_date' AND  '$end_date') OR (a.send_oh_user = '$user_id' AND a.send_oh_datetime BETWEEN '$start_date' AND  '$end_date') OR (a.get_qcoh_user = '$user_id' AND a.get_qcoh_datetime BETWEEN '$start_date' AND  '$end_date') OR (a.send_qcoh_user = '$user_id' AND a.send_qcoh_datetime BETWEEN '$start_date' AND  '$end_date') OR (a.pay_oh_user = '$user_id' AND a.pay_oh_datetime BETWEEN '$start_date' AND  '$end_date') OR (a.return_oh_user = '$user_id' AND a.return_datetime BETWEEN '$start_date' AND  '$end_date') AND 

$result  = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($result);
// $row = mysqli_fetch_array($result);

while ($row = mysqli_fetch_array($result)) {

    if ($row['cancel_datetime'] != null) {
        $status = "ยกเลิกงาน";
    } else if ($row['close_user_id'] != null) {
        $status = "ปิดงาน";
        $style_job = "style='color: red;'";
    } else if ($row['finish_service_time'] != null) {
        $status = "รอปิดงาน";
    } else if ($row['start_service_time'] != null) {
        $h = date('H', strtotime('NOW')) - date('H', strtotime($row['start_service_time']));
        $m = ((date('i', strtotime('NOW')) - date('i', strtotime($row['start_service_time']))) / 60) * 10;
        $status =  "กำลังดำเนินการ" . "  " . $h . "." . number_format(abs($m));
    } else if ($row['start_service_time'] == null) {
        $status = "เปิดงาน";
    }


    $status_oh = '';
    if ($row['job_type'] == 4) {
        // if ($row['pay_oh_datetime'] != null) {
        //     $status_oh = '(ชำระแล้ว)';
        // } else if ($row['send_qcoh_datetime'] != null) {
        //     $status_oh = '(ส่ง QC แล้ว)';
        // } else if ($row['get_qcoh_datetime'] != null) {
        //     $status_oh = '(เปิด QC แล้ว)';
        // } else if ($row['send_oh_datetime'] != null) {
        //     $status_oh = '(ล้างเครื่องเสร็จแล้ว)';
        // } else if ($row['get_oh_datetime'] != null) {
        //     $status_oh = '(เปิดล้างเครื่องแล้ว)';
        // }
        $sql_oh_status = "SELECT * FROM tbl_job_oh WHERE user_id = '$user_id' AND job_id = '{$row['job_id']}' ";
        $rs_oh_status = mysqli_query($connect_db, $sql_oh_status);
        $row_oh_status = mysqli_fetch_assoc($rs_oh_status);


        if ($row_oh_status['oh_type'] == 1) {
            $status_oh = 'รับเครื่อง';
        } else if ($row_oh_status['oh_type'] == 2) {
            $status_oh = 'เปิดล้างเครื่อง';
        } else if ($row_oh_status['oh_type'] == 3) {
            $status_oh = 'ตรวจสภาพก่อนถอด';
        } else if ($row_oh_status['oh_type'] == 4) {
            $status_oh = 'แยกชิ้นส่วน';
        } else if ($row_oh_status['oh_type'] == 5) {
            $status_oh = 'แช่ล้าง';
        }else if ($row_oh_status['oh_type'] == 6) {
            $status_oh = 'ประกอบชิ้นส่วนพร้อมทดสอบ';
        }else if ($row_oh_status['oh_type'] == 7) {
            $status_oh = 'QC';
        }else if ($row_oh_status['oh_type'] == 8) {
            $status_oh = 'ส่งคืนเครื่อง';
        }

    }


    $temp_array = array(
        "create_user_id" => $row['create_user_id'],
        "job_type" => $row['job_type'],
        "cus_branch_name" => $row['cus_branch_name'],
        "create_user_name" => $row_create['fullname'],
        "status" => $status,
        "style_job" => $style_job,
        "status_oh" => $status_oh,
        "job_id" => $row['job_id'],
        "job_no" => $row['job_no'],
        "job_create" => $row['job_create'],
        "contact_name" => $row['contact_name'],
        "contact_phone" => $row['contact_phone'],
        "fullname" => $row['fullname'],
        "mobile_phone" => $row['mobile_phone'],
        "branch_name" => $row['branch_name'],
        "appointment_date" => $row['appointment_date'],
        "appointment_time" => $row['appointment_time'],
        "type" => '4',
        "model_name" => $row['model_name'],
        "branch_code" => $row['branch_code'],
        "district_id" => $row['district_id'],
        "sub_type_name" => $row['sub_type_name']

    );

    array_push($work_list, $temp_array);
}

?>

<?php
// var_dump($work_list);
if (count($work_list) > 0) {
    array_multisort(array_column($work_list, 'appointment_date'), SORT_DESC, $work_list);
    foreach ($work_list as $row) {


        switch ($row['job_type']) {
            case "1":
                $type = "CM";
                break;
            case "2":
                $type = "PM";
                break;
            case "3":
                $type = "Installation";
                break;
            case "4":
                $color = "Overhaul";
                break;
            case "5":
                $type = "Oth";
                break;
            default:
                $type = "Quotation";
        }

        switch ($row['job_type']) {
            case "1":
                $color = "cm";
                break;
            case "2":
                $color = "pm";
                break;
            case "3":
                $color = "install";
                break;
            case "4":
                $color = "overhaul";
                break;
            case "5":
                $color = "oth";
                break;
            default:
                $color = "เสนอราคา";
        }


        ////////////////////address
        $sql_address = "SELECT a.district_name_th,a.district_zipcode,b.amphoe_name_th,c.province_name_th FROM tbl_district a 
    LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
    LEFT JOIN tbl_province c ON b.ref_province = c.province_id
     WHERE a.district_id = '{$row['district_id']}'";
        $rs_address  = mysqli_query($connect_db, $sql_address);
        $row_address = mysqli_fetch_array($rs_address);

?>

        <div class="ibox mb-3 d-block border-<?php echo $color ?>">
            <div class="ibox-title" <?php echo $row['style_job'] ?>>
                <?php echo $row['job_no'] . " " . $row['status_oh'] ?> <br> <?php echo $row['branch_code'] . " - " . $row['cus_branch_name'] . " จ." . $row_address['province_name_th'] . " อ." . $row_address['amphoe_name_th'] . " ต." . $row_address['district_name_th'] ?> <br>
                [<?php echo $row['status'] ?>]

            </div>
            <div class="ibox-content">

                <table class="w-100">

                    <tr>
                        <td>ชื่องาน</td>
                        <td>: <?php echo ($row['sub_type_name'] == "") ? "-" : $row['sub_type_name']; ?></td>
                    </tr>

                    <?php if ($row['job_type'] == 3) {

                        $sql_product = "SELECT * FROM tbl_in_product a
                        LEFT JOIN tbl_product c ON a.product_id = c.product_id
                        LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
                        WHERE job_id = '{$row['job_id']}'";
                        $result_product  = mysqli_query($connect_db, $sql_product);
                        while ($row_product = mysqli_fetch_array($result_product)) { ?>

                            <tr>
                                <td>รุ่น</td>
                                <td>: <?php echo ($row_product['model_name'] == "") ? "-" : $row_product['model_name']; ?></td>
                            </tr>
                        <?php }
                    } else { ?>
                        <tr>
                            <td>รุ่น</td>
                            <td>: <?php echo ($row['model_name'] == "") ? "-" : $row['model_name']; ?></td>
                        </tr>
                    <?php } ?>
                    <tr>
                        <td colspan="1">เวลานัดหมาย</td>
                        <td colspan="2">: <?php echo date('d-M-Y', strtotime($row['appointment_date'])) ?> <?php echo ($row['appointment_time_start'] == "") ? "" : date('H:i', strtotime($row['appointment_time_start'])) ?>
                            <?php echo ($row['appointment_time_end'] == "") ? "" : " - " . date('H:i', strtotime($row['appointment_time_end'])) ?></td>
                    </tr>
                    <tr>
                        <td>ติดต่อ</td>
                        <td>
                            <h5>: <?php echo $row['contact_name']; ?>
                                (<?php echo $row['contact_position']; ?>)
                            </h5>
                        </td>

                    </tr>
                    <tr>

                        <td>โทร</td>
                        <td>: <?php echo $row['contact_phone']; ?></td>
                    </tr>
                </table>

                <div class="text-center mt-3">
                    <div class="btn-group">

                        <a href='tel:<?php echo $row['contact_phone'] ?>' class="btn btn-white btn-sm"><i class="fa fa-phone">
                            </i> Tel</a>

                        <a href='<?php echo $row['google_map_link'] ?>' target="_blank" class="btn btn-white btn-sm"><i class="fa fa-map-marker">
                            </i> Map</a>

                        <a href='view_work.php?id=<?php echo $row['job_id'] ?>&&type=<?php echo $row['type'] ?>' class="btn btn-white btn-sm" type="button"><i class="fa fa-edit"></i> Record</a>
                    </div>
                </div>
            </div>
        </div>

    <?php }
    ?>

<?php
} else {
?>
    <br>
    <center>
        <h1> ไม่พบงาน </h1>
    </center>

<?php
}
?>



<script>
    new ClipboardJS(".btn", {
        text: function(trigger) {
            const query = trigger.getAttribute('data-clipboard-target');
            const target = document.querySelector(query);
            return target.getAttribute('href');
        }
    });
</script>