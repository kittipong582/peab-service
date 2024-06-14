<?php include('header.php');
// include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_GET['id'];

$sql = "SELECT a.*,b.branch_name AS b_name,b.branch_code,b.customer_id,b.address,b.address2,b.branch_note,a.branch_name AS team_name,b.district_id FROM tbl_customer_branch b 
LEFT JOIN tbl_branch a ON a.branch_id = b.branch_care_id 
WHERE b.customer_branch_id = '$customer_branch_id'";
$result = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$team_name = $row['branch_name'];
$customer_id = $row['customer_id'];
// $customer_branch_id = $row['customer_branch_id'];


////////////////////address
$sql_address = "SELECT a.district_name_th,a.district_zipcode,b.amphoe_name_th,c.province_name_th FROM tbl_district a 
LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id
LEFT JOIN tbl_province c ON b.ref_province = c.province_id
 WHERE a.district_id = '{$row['district_id']}'";
$rs_address = mysqli_query($connect_db, $sql_address);
$row_address = mysqli_fetch_array($rs_address);


$sql_customer = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result_customer = mysqli_query($connect_db, $sql_customer);
$row_customer = mysqli_fetch_array($result_customer);


if ($row_customer['customer_type'] == 1) {
    $customer_type = 'นิติบุคคล';
} else {
    $customer_type = 'บุคคลธรรมดา';
}

$sql_type = "SELECT * FROM tbl_customer_group_type WHERE customer_group_type_id = '{$row_customer['customer_group_type_id']}'";
$result_type = mysqli_query($connect_db, $sql_type);
$row_type = mysqli_fetch_array($result_type);

$sql_contact = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '$customer_branch_id' ORDER BY main_contact_status DESC";
$result_contact = mysqli_query($connect_db, $sql_contact);


$list = array();

$sql_activity = "SELECT a.create_datetime AS row1
,b.fullname AS row2
,a.job_type AS row3
,a.job_no AS row4
,a.job_id AS row5
,1 AS row6
FROM tbl_job a
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
WHERE a.customer_branch_id = '$customer_branch_id' and a.create_datetime is not null

Union

SELECT a.start_service_time AS row1
,b.fullname AS row2
,a.job_type AS row3
,a.job_no AS row4
,a.job_id AS row5
,2 AS row6
FROM tbl_job a
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
WHERE a.customer_branch_id = '$customer_branch_id' and a.start_service_time is not null

UNION

SELECT a.finish_service_time AS row1
,b.fullname AS row2
,a.job_type AS row3
,a.job_no AS row4
,a.job_id AS row5
,3 AS row6
FROM tbl_job a
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id
WHERE a.customer_branch_id = '$customer_branch_id'  and a.finish_service_time is not null

UNION

SELECT b.approve_datetime AS row1
,c.fullname AS row2
,a.job_type AS row3
,a.job_no AS row4
,a.job_id AS row5
,4 AS row6
FROM tbl_job a
LEFT JOIN tbl_job_close_approve b ON a.close_approve_id = b.close_approve_id
LEFT JOIN tbl_user c ON b.approve_user_id = c.user_id
WHERE a.customer_branch_id = '$customer_branch_id'  and a.close_approve_id is not null AND b.approve_result = 1



ORDER BY row1 ASC
";
$result_activity = mysqli_query($connect_db, $sql_activity);
while ($row_activity = mysqli_fetch_array($result_activity)) {


    if ($row_activity['row3'] == 1) {
        $job_type = "CM";
    } elseif ($row_activity['row3'] == 2) {
        $job_type = "PM";
    } else if ($row_activity['row3'] == 3) {
        $job_type = "INSTALLATION";
    } else if ($row_activity['row3'] == 5) {
        $job_type = "งานอื่นๆ";
    } else if ($row_activity['row3'] == 4) {
        $job_type = 'OVERHAUL';
    } else if ($row_activity['row3'] == 6) {
        $job_type = 'เสนอราคา';
    }


    if ($row_activity['row6'] == 1) {
        $text = '<span class="label label-primary">เปิดงาน</span>';
    } elseif ($row_activity['row6'] == 2) {
        $text = '<span class="label label-success">เช็คอิน</span>';;
    } else if ($row_activity['row6'] == 3) {
        $text = '<span class="label label-info">เช็คเอาท์</span>';;
    } else if ($row_activity['row6'] == 4) {
        $text = '<span class="label label-danger">ปิดงาน</span>';;
    }

    $temp_array = array(
        "text_show" => $row_activity['row2'],
        "time" => "วันที่ " . date("d-m-Y H:i", strtotime($row_activity['row1'])),
        "job_type" => $job_type,
        "job_no" => $row_activity['row4'],
        "job_id" => $row_activity['row5'],
        "text" => $text,
    );

    array_push($list, $temp_array);
}

$date = date('Y-m-d', strtotime("today"));
$date_last = date('Y-m-d', strtotime('+30 days', strtotime($date)));
$coming_list = array();

$sql_job_coming = "SELECT * FROM tbl_job a
LEFT JOIN tbl_user b ON a.responsible_user_id = b.user_id 
WHERE customer_branch_id = '$customer_branch_id'and appointment_date BETWEEN '$date' AND '$date_last'";
$result_job_coming = mysqli_query($connect_db, $sql_job_coming);
while ($row_job_coming = mysqli_fetch_array($result_job_coming)) {


    $temp_array = array(
        "job_no" => $row_job_coming['job_no'],
        "datetime" => "วันที่ " . date("d-m-Y", strtotime($row_job_coming['appointment_date'])),
        "service_user" => $row_job_coming['fullname'],
        "job_id" => $row_job_coming['job_id'],
    );

    array_push($coming_list, $temp_array);
}


?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2>
            <?php echo $row['b_name'] ?> -
            <?php echo $row_customer['customer_name'] ?>
        </h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="customer_branch_list.php">รายการลูกค้า</a>
            </li>
            <!-- <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li> -->
            <li class="breadcrumb-item active">
                <strong>
                    <?php echo $row['b_name'] ?>
                </strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content  animated fadeInRight">

    <?php include('ajax/menu/branch_customer_menu.php'); ?>

    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-success float-right">Monthly</span>
                        <h5>Income</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">40 886,200</h1>
                        <div class="stat-percent font-bold text-success">98% <i class="fa fa-bolt"></i></div>
                        <small>Total income</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-info float-right">Annual</span>
                        <h5>Orders</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">275,800</h1>
                        <div class="stat-percent font-bold text-info">20% <i class="fa fa-level-up"></i></div>
                        <small>New orders</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-primary float-right">Today</span>
                        <h5>visits</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">106,120</h1>
                        <div class="stat-percent font-bold text-navy">44% <i class="fa fa-level-up"></i></div>
                        <small>New visits</small>
                    </div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="ibox ">
                    <div class="ibox-title">
                        <span class="label label-danger float-right">Low value</span>
                        <h5>User activity</h5>
                    </div>
                    <div class="ibox-content">
                        <h1 class="no-margins">80,600</h1>
                        <div class="stat-percent font-bold text-danger">38% <i class="fa fa-level-down"></i></div>
                        <small>In first month</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-content" style="padding: 15px 15px 15px 15px;">
                <div class="row">

                    <div class="col-1">
                        <a href="customer_form_new.php" class="btn btn-xs btn-info"><i class="fa fa-plus"></i> เพิ่ม</a>
                    </div>

                    <div class="col-1">
                        <a href="product.php?id=<?php echo $branch_id ?>" class="btn btn-xs btn-info"><i
                                class="fa fa-plus"></i> สินค้า</a>
                    </div>
                    <div class="col-1">
                        <button class="btn btn-info btn-block btn-sm" onclick="modal_add('<?php echo $customer_branch_id ?>');"><i class="fa fa-plus"> </i>
                            เพิ่ม
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div> -->


    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-9">
                <div class="full-height">

                    <div class="ibox ">

                        <div class="ibox-content">

                            <div class="row mb-3">
                                <div class="col-3 mb-3">
                                    <label>
                                        <b>สาขา</b>
                                    </label><br>
                                    <label>
                                        <?php echo $row['b_name'] ?>
                                    </label>

                                </div>

                                <div class="col-3 mb-3">
                                    <label>
                                        <b>รหัสสาขา</b>
                                    </label><br>
                                    <label>
                                        <?php echo $row['branch_code'] ?>
                                    </label>

                                </div>

                                <div class="col-3 mb-3">
                                    <label>
                                        <b>ประเภทลูกค้า</b>
                                    </label><br>
                                    <label>
                                        <?php echo $row_type['customer_group_type_name'] ?>
                                    </label>

                                </div>

                                <div class="col-3 mb-3">
                                    <label>
                                        <b>AX code</b>
                                    </label><br>
                                    <label>
                                        <?php echo $row['ax_code'] ?>
                                    </label>
                                </div>

                                <div class="col-4 mb-3">
                                    <label>
                                        <b>ที่อยู่</b>
                                    </label><br>

                                    <label>
                                        <?php echo $row['address'] ?><br>
                                        <?php echo "ต." . $row_address['district_name_th'] . " อ." . $row_address['amphoe_name_th'] . " จ." . $row_address['province_name_th'] . " " . $row_address['district_zipcode'] ?>
                                    </label>

                                </div>


                                <div class="col-4 mb-3">
                                    <label>
                                        <b>ทีมดูแล</b>
                                    </label><br>
                                    <label>
                                        <?php echo $team_name ?>
                                    </label>

                                </div>


                                <div class="col-12 mb-3">

                                    <label for="note">
                                        <b>หมายเหตุ</b>
                                    </label><br>
                                    <p>
                                        <?php echo $row['branch_note'] ?>
                                    </p>
                                </div>

                            </div>

                        </div>
                    </div>

                    <div class="ibox ">


                        <div class="ibox-title" style="padding: 15px 15px 0px 15px;">
                            <div class="col-lg-12">
                                <div class="row">

                                    <div class="col-lg-10">
                                        <h5>รายชื่อผู้ติดต่อ</h5>
                                    </div>

                                    <div class="col-lg-1">
                                        <div class="form-group text-right">
                                            <button class="btn btn-info btn-xs" onclick="modal_add('<?php echo $customer_branch_id ?>');"><i class="fa fa-plus">
                                                </i>
                                                เพิ่มรายชื่อ
                                            </button>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>

                        <div class="ibox-content">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <tbody>
                                        <?php

                                        while ($row_contact = mysqli_fetch_array($result_contact)) {



                                        ?>
                                            <tr>
                                                <td><a href="#contact-1" class="client-link">
                                                        <?php echo $row_contact['contact_name'] ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $row_contact['contact_position'] ?>
                                                </td>
                                                <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                                <td>
                                                    <?php echo $row_contact['contact_phone'] ?>
                                                </td>
                                                <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                                <td>
                                                    <?php echo $row_contact['contact_email'] ?>
                                                </td>
                                                <td class="client-status">
                                                    <button class="btn btn-warning btn-xs" onclick="modal_edit('<?php echo $row_contact['contact_id'] ?>');">
                                                        <i class="fa fa-pencil-square-o"></i>
                                                </td>
                                                <td class="client-status">
                                                    <button class="btn btn-danger btn-xs" onclick="modal_delete('<?php echo $row_contact['contact_id'] ?>');">
                                                        <i class="fa fa-times"></i>

                                                    </button>
                                                </td>
                                            </tr>

                                        <?php

                                        }

                                        ?>
                                        <!-- <tr>
                                            <td><a href="#contact-2" class="client-link">Rooney Lindsay</a></td>
                                            <td>Proin Limited</td>
                                            <td class="contact-type"><i class="fa fa-phone"> </i></td>
                                            <td> +432 955 908</td>
                                            <td class="contact-type"><i class="fa fa-envelope"> </i></td>
                                            <td> rooney@proin.com</td>
                                            <td class="client-status"><span class="label label-primary">Active</span>
                                            </td>
                                        </tr> -->

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>บันทึกการทำงาน</h5>
                        </div>

                        <div class="ibox-content">
                            <?php foreach ($list as $row) { ?>

                                <div class="stream-small">

                                    <label>
                                        <?php echo $row['text'] ?>
                                        <?php echo " " . $row['text_show'] . " " ?><a href="view_cm.php?id=<?php echo $row['job_id'] ?>" target="_blank">
                                            <?php echo $row['job_no'] ?>
                                        </a>
                                        <?php echo " " . $row['time'] ?>
                                    </label>

                                </div>
                            <?php } ?>



                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3">
                <div class="full-height">
                    <div class="ibox ">
                        <div class="ibox-title">
                            <h5>งานที่กำลังจะมาถึง (30 วัน)</h5>
                        </div>

                        <div class="ibox-content">
                            <?php foreach ($coming_list as $row) { ?>

                                <div class="stream-small">

                                    <label><a href="view_cm.php?id=<?php echo $row['job_id'] ?>" target="_blank">
                                            <?php echo $row['job_no'] ?>
                                        </a>
                                        <?php echo " " . $row['datetime'] . " ช่าง " . $row['service_user'] ?>
                                    </label>

                                </div>
                            <?php } ?>



                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- addmodal -->
<div class="modal hide fade in" id="modal" role="dialog" data-keyboard="false" data-backdrop="static" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div id="show_modal"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {

    });

    $(".select2").select2({
        width: "100%"
    });

    function modal_add(customer_branch_id) {
        $('#modal').modal('show');
        $('#show_modal').load("ajax/branch_view/modal_add.php", {
            customer_branch_id: customer_branch_id
        });
    }

    function modal_edit(contact_id) {
        $('#modal').modal('show');
        $('#show_modal').load("ajax/branch_view/modal_edit.php", {
            contact_id: contact_id
        });
    }

    function modal_delete(contact_id) {
        swal({
            title: 'กรุณายืนยันเพื่อทำรายการ',
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            cancelButtonText: 'ยกเลิก',
            confirmButtonText: 'ยืนยัน',
            buttonsStyling: false
        }, function() {
            $.ajax({
                type: 'POST',
                url: 'ajax/branch_view/delete.php',
                data: {
                    contact_id: contact_id
                },
                dataType: 'json',
                success: function(data) {
                    if (data.result == 0) {
                        swal({
                            title: 'ผิดพลาด!',
                            text: 'กรุณาลองใหม่อีกครั้ง',
                            type: 'warning'
                        });
                        return false;
                    }
                    if (data.result == 1) {
                        $('#modal').modal('hide');
                        swal({
                            title: "ดำเนินการสำเร็จ!",
                            text: "ทำการบันทึกรายการ เรียบร้อย",
                            type: "success",
                            showConfirmButton: false,
                            timer: 1000
                        });
                        location.reload();
                    }
                }
            })
        });
    }
</script>