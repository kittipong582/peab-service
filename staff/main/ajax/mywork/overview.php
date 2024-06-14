<?php

include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
session_start();
$user_id = $_SESSION['user_id'];

$job_id = $_POST['job_id'];



$sql = "SELECT a.*,b.branch_code,b.branch_name AS cus_branch_name,b.google_map_link,c.serial_no,c.warranty_start_date,c.warranty_expire_date,d.brand_name,g.model_name,b.address AS baddress,b.address2 AS baddress2 ,h.sub_type_name  FROM tbl_job a 
LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id
LEFT JOIN tbl_product c ON a.product_id = c.product_id
LEFT JOIN tbl_product_brand d ON c.brand_id = d.brand_id
LEFT JOIN tbl_product_model g ON c.model_id = g.model_id
LEFT JOIN tbl_sub_job_type h ON h.sub_job_type_id = a.sub_job_type_id 
WHERE a.job_id = '$job_id' ;";
$result  = mysqli_query($connect_db, $sql);
$num_row = mysqli_num_rows($result);
$row = mysqli_fetch_array($result);
// echo $sql;


////////////////////////////////////////ค่าบริการเปิดงาน/////////////////////////
$sql_open_service = "SELECT * FROM tbl_job_open_oth_service a
LEFT JOIN tbl_income_type b ON a.service_id = b.income_type_id
 WHERE a.job_id = '$job_id' ORDER BY a.list_order";
$result_open_service  = mysqli_query($connect_db, $sql_open_service);

//////////////////////////////////////////////////////////////////////////////////////////////////////

$sql_spare = "SELECT IFNULL(SUM(unit_price),0) AS totall,IFNULL(SUM(quantity),0) AS sum_spare FROM tbl_job_spare_used WHERE job_id = '$job_id'";
$result_spare  = mysqli_query($connect_db, $sql_spare);
$row_spare = mysqli_fetch_array($result_spare);

$sql_income = "SELECT * FROM tbl_job_income WHERE job_id = '$job_id'";
$result_income  = mysqli_query($connect_db, $sql_income);
while ($row_income = mysqli_fetch_array($result_income)) {

    $income_total += $row_income['quantity'] * $row_income['income_amount'];
}

$service_total = $income_total;

$start = new DateTime($row['appointment_time_start']);
$end = new DateTime($row['appointment_time_end']);

$time = $start->diff($end);
$diffInMinutes = $time->i; //นาที;
$diffInHours   = $time->h; //ชั่วโมง;

$minute = $diffInMinutes;
$hour = $diffInHours;

$count_minute = strlen($minute);
if ($count_minute == 1) {
    $minute = "0" . $diffInMinutes;
}

$count_hour = strlen($hour);
if ($count_hour == 1) {
    $hour = "0" . $diffInHours;
}

$total_time = $hour . " : " . $minute;
//////////////////////////////////////////////////////////////////////////////////////////////////////

$warranty_start_date = $row['warranty_start_date'];
$warranty_expire_date = $row['warranty_expire_date'];
$today = date("d-M-Y");
$today_time = strtotime($today);
// $expire_time = strtotime($expire);

$chk_date = "";
if ($today_time < $warranty_expire_date && $warranty_expire_date != null) {
    $chk_date = date('d-M-Y', strtotime($row['warranty_expire_date']));
} else if ($today_time > $warranty_expire_date && $warranty_expire_date != null) {
    $chk_date = '<font color="red">(หมดประกัน)</font>';
} else  if ($warranty_expire_date == null) {
    $chk_date = '<font color="red">ไม่ระบุ</font>';
}




?>
<div class="col-lg-12">
    <div class="row">
        <div class="col-6">
            <div class="widget style1 navy-bg">
                <div class="row">
                    <!-- <div class="col-4">
                        <i class="fa fa-money fa-4x"></i>
                    </div> -->
                    <div class="col-12 text-center">
                        <span> ค่าบริการ </span>
                        <h3 class="font-bold" id="total_service"><?php echo number_format($service_total); ?></h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="widget style1 red-bg">
                <div class="row">
                    <!-- <div class="col-4">
                        <i class="fa fa-list-ul fa-4x"></i>
                    </div> -->
                    <div class="col-12 text-center">
                        <span> ค่าใช้จ่าย </span>
                        <h3 class="font-bold"><?php echo number_format($row_spare['totall']); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<br>

<div class="ibox mb-3 d-block">

    <div class="ibox-content">

        <br>
        <div class="row">

            <div class="col-12 mb-3">
                <label><b>ชื่องาน</b></label> <br><?php echo $row['sub_type_name'] ?>
            </div>

            <div class="col-12">
                <label><b>ชื่อร้าน</b></label> <br><?php echo $row['branch_code'] . " - " . $row['cus_branch_name'] ?> <a href="<?php echo $row['google_map_link'] ?>" target="_blank" class="btn btn-info btn-xs">แผนที่</a>
            </div>

        </div>

        <br>
        <div class="row">

            <div class="col-12">
                <label><b>ที่อยู่สาขา</b></label>
                <br><?php echo $row['baddress']; ?><br><?php echo $row['baddress2']; ?>
            </div>

        </div>

        <br>
        <div class="row">
            <div class="col-12">
                <label><b>ผู้ติดต่อ</b></label> <br><?php echo $row['contact_name']; ?>
                (<?php echo $row['contact_position']; ?>)
                <a href='tel:<?php echo $row['contact_phone']; ?>' class="btn btn-success btn-xs"><i class="fa fa-phone"></i> <?php echo $row['contact_phone']; ?></a>
            </div>
        </div>

        <br>
        <?php if ($row['job_type'] == 3) {


            $sql_product = "SELECT * FROM tbl_in_product a
            LEFT JOIN tbl_product c ON a.product_id = c.product_id
            LEFT JOIN tbl_product_model d ON c.model_id = d.model_id
            WHERE job_id = '{$row['job_id']}'";
            $result_product  = mysqli_query($connect_db, $sql_product);
            while ($row_product = mysqli_fetch_array($result_product)) {

                $warranty_start_date = $row_product['warranty_start_date'];
                $warranty_expire_date = $row_product['warranty_expire_date'];
                $today = date("d-M-Y");
                $today_time = strtotime($today);
                // $expire_time = strtotime($expire);


                $chk_date = "";
                if ($today_time < $warranty_expire_date && $warranty_expire_date != null) {
                    $chk_date = date('d-M-Y', strtotime($row_product['warranty_expire_date']));
                } else if ($today_time > $warranty_expire_date && $warranty_expire_date != null) {
                    $chk_date = '<font color="red">(หมดประกัน)</font>';
                } else  if ($warranty_expire_date == null) {
                    $chk_date = '<font color="red">ไม่ระบุ</font>';
                }
        ?>

                <div class="row">

                    <div class="col-6">
                        <label><b>S/N</b></label> <br><?php echo $row_product['serial_no'] ?>
                    </div>

                    <div class="col-6">
                        <label><b>การรับประกัน</b></label> <br>ซื้อจากบริษัท
                    </div>

                </div>

                <br>
                <div class="row">

                    <div class="col-6">
                        <label><b>รุ่น</b></label> <br><?php echo $row_product['model_name']; ?>(<?php echo $row_product['brand_name']; ?>)
                    </div>

                    <div class="col-6">
                        <label><b>วันหมดประกัน</b></label>
                        <br><?php echo ($row_product['warranty_expire_date'] == "") ? "-" : date('d-M-Y', strtotime($row_product['warranty_expire_date'])) ?>
                        <?php echo $chk_date; ?>
                    </div>

                </div>
                <hr>
                <br>




            <?php }
        } else { ?>
            <div class="row">

                <div class="col-6">
                    <label><b>S/N</b></label> <br><?php echo $row['serial_no'] ?>
                </div>

                <div class="col-6">
                    <label><b>การรับประกัน</b></label> <br>ซื้อจากบริษัท
                </div>

            </div>

            <br>
            <div class="row">

                <div class="col-6">
                    <label><b>รุ่น</b></label> <br><?php echo $row['model_name']; ?>(<?php echo $row['brand_name']; ?>)
                </div>

                <div class="col-6">
                    <label><b>วันหมดประกัน</b></label>
                    <br><?php echo ($row['warranty_expire_date'] == "") ? "-" : date('d-M-Y', strtotime($row['warranty_expire_date'])) ?>
                    <?php echo $chk_date; ?>
                </div>

            </div>

            <br>
        <?php } ?>
        <div class="row">

            <div class="col-6">
                <label><b>วันที่สร้างรายการ</b></label>
                <br><?php echo date('d-M-Y', strtotime($row['create_datetime'])); ?>
            </div>

            <div class="col-6">
                <label><b>วันที่นัดหมาย</b></label>
                <br><?php echo date('d-M-Y H:i', strtotime($row['appointment_date'])); ?>
            </div>

        </div>

        <?php if ($row['job_type'] == 1) { ?>
            <br>
            <div class="row">

                <div class="col-6">
                    <label><b>อาการเสียเบื้องต้น</b></label>
                    <br><?php echo $row['initial_symptoms']; ?>
                </div>


            </div>
        <?php } ?>

        <?php
        $rowcount = mysqli_num_rows($result_open_service);
        if ($rowcount >= 1) { ?>
            <div class="row">

                <div class="col-12 mb-2">
                    <label><b>ค่าบริการเปิดงาน</b></label>
                </div>
                <div class="col-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover dataTables-example" style="width: 150%;">
                            <thead>
                                <tr>
                                    <th width="15%" class="text-center">รายการ</th>
                                    <th width="10%" class="text-right">ราคาต่อหน่วย</th>
                                    <th width="10%" class="text-right">จำนวน</th>
                                    <th width="10%" class="text-right">รวม</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 0;

                                while ($row_open_service = mysqli_fetch_array($result_open_service)) {
                                ?>

                                    <tr id="tr_<?php echo $row['payment_id']; ?>">

                                        <td class="text-center">
                                            <?php echo "[" . $row_open_service['income_code'] . "] -" . $row_open_service['income_type_name']; ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($row_open_service['unit_cost']); ?>

                                        </td>

                                        <td class="text-right">

                                            <?php echo number_format($row_open_service['quantity']); ?>

                                        </td>
                                        <td class="text-right">
                                            <?php echo number_format($row_open_service['unit_price']); ?>
                                        </td>
                                    </tr>

                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        <?php } ?>

        <!-- <br>
        <div class="row">

            <div class="col-12">
                <label><b>วันเวลาที่เข้าออกงาน</b></label>
                <br><?php echo date('d-M-Y', strtotime($row['appointment_date'])); ?> [
                <?php echo date('H : i', strtotime($row['appointment_time_start'])); ?> -
                <?php echo date('H : i', strtotime($row['appointment_time_end'])); ?> ]
            </div>

        </div> -->


    </div>
</div>

<script>
    $(document).ready(function() {

        $('table').DataTable({
            pageLength: 10,
            responsive: true,
        });

    });

    $(".select2").select2({});

    $('.date').datepicker({
        // startView: 0,
        todayBtn: "linked",
        keyboardNavigation: false,
        forceParse: false,
        autoclose: true,
        format: "dd/mm/yyyy",

    })
</script>