<?php
session_start();    
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$overhaul_id = $_POST['overhaul_id'];
$job_id = $_POST['job_id'];
$sql_oh = "SELECT * FROM tbl_overhaul WHERE overhaul_id = '$overhaul_id'";
$result_oh  = mysqli_query($connect_db, $sql_oh);
$row_oh = mysqli_fetch_array($result_oh);


if ($row_oh['product_type'] == 1) {
    $product_type = 'เครื่องชง';
} else if ($row_oh['product_type'] == 2) {
    $product_type = 'เครื่องบด';
} else if ($row_oh['product_type'] == 3) {
    $product_type = 'เครื่องปั่น';
}

$brand_id = $row_oh['brand_id'];
$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$model_id = $row_oh['model_id'];
$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);

$warranty_start_date = date("d-m-Y", strtotime($row_oh['warranty_start_date']));

if ($row_oh['warranty_end_date'] == null) {
    $warranty = "ไม่มีข้อมูล";
} else {
    $now = strtotime("today");
    $expire_date = strtotime($row_oh['warranty_end_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain <= 0) {
        $total_remain =  "หมดอายุ " . abs($days_remain) . " วัน";
    } else {
        $total_remain = "เหลือ " . $days_remain . " วัน";
    }
    $warranty = date("d-m-Y", strtotime($row_oh['warranty_end_date'])) . " " . $total_remain;
}


$sql = "SELECT *,a.create_datetime as log_datetime FROM tbl_overhaul_log a 
LEFT JOIN tbl_overhaul b ON a.overhaul_id = b.overhaul_id 
LEFT JOIN tbl_user c ON a.create_user_id = c.user_id
WHERE a.job_id = '$job_id' ORDER BY a.create_datetime DESC";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);


$current_user_id = $_SESSION['user_id'];
$admin_status = $_SESSION['admin_status'];
$sql_current = "SELECT responsible_user_id FROM tbl_job WHERE job_id = '$job_id'";
$rs_current = mysqli_query($connect_db, $sql_current) or die($connect_db->error);
$row_current = mysqli_fetch_assoc($rs_current);

if ($overhaul_id != "") {
?>

    <div class="row mb-3 " style="padding-top: 5ex;">

        <input type="hidden" id="overhaul_show" name="overhaul_show" value="<?php echo $row_oh['overhaul_id'] ?>">
        <div class="mb-3 col-4">
        </div>
        <div class="mb-3 col-4">
        </div>
        <div class="mb-3 col-4">
            <?php if ($current_user_id == $row_current['responsible_user_id'] || $admin_status == 9) { ?>
                <button class="btn btn-warning btn-sm" type="button" style="float: right;" id="submit" onclick="change_overhaul('<?php echo $job_id ?>');">เปลี่ยนเครื่องทดแทน</button>
            <?php } ?>
        </div>

        <div class="mb-3 col-4">
            <label>Serial No</label>
            <input type="text" readonly id="serial_no" value="<?php echo $row_oh['serial_no'] ?>" name="serial_no" class="form-control">
        </div>
        <div class="mb-3 col-4">
            <label>ประเภทเครื่อง</label>
            <input type="text" readonly id="product_type" value="<?php echo $product_type ?>" name="product_type" class="form-control">
        </div>
        <div class="mb-3 col-4">
            <label>ยี่ห้อ</label>
            <input type="text" readonly id="brand" value="<?php echo $row_brand['brand_name'] ?>" name="brand" class="form-control">
        </div>
        <div class="mb-3 col-4">
            <label>รุ่น</label>
            <input type="text" readonly id="model" value="<?php echo $row_model['model_name'] ?>" name="model" class="form-control">
        </div>

        <div class="mb-3 col-4">
            <label>วันที่เริ่มประกัน</label>
            <input type="text" readonly id="warranty_start_date" value="<?php echo $warranty_start_date ?>" name="warranty_start_date" class="form-control">
        </div>

        <div class="mb-3 col-4">
            <label>วันที่หมดประกัน</label>
            <input type="text" readonly id="warranty_expire_date" value="<?php echo $warranty ?>" name="warranty_expire_date" class="form-control">
        </div>
        <div class="mb-3 col-12">
            <?php if ($current_user_id == $row_current['responsible_user_id'] || $admin_status == 9) { ?>
                <button class="btn btn-info btn-sm" type="button" style="float: right;" id="submit" onclick="return_overhaul('<?php echo $job_id ?>','<?php echo $overhaul_id ?>');">คืนเครื่อง</button>
            <?php } ?>
        </div>
    </div>
<?php } ?>

<div class="table-responsive">

    <table class="table table-striped table-hover table-bordered  tbl_log">

        <thead>

            <tr>

                <th width="10%"></th>

                <th width="15%" class="text-center">วันที่ทำรายการ</th>

                <th width="15%" class="text-center">ผู้ทำรายการ</th>

                <th width="45%" class="">รายละเอียดเครื่อง</th>

                <th width="15%" class="">สถานะ</th>

            </tr>

        </thead>

        <tbody>

            <?php
            while ($row = mysqli_fetch_assoc($rs)) {

                $i++;

                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }
                $overhaul = $row['overhaul_id'];
                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand  = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model  = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);
                $branch_id = $row['current_branch_id'];

                $sql_care = "SELECT *  FROM tbl_branch WHERE branch_id = '$branch_id'";
                $result_care  = mysqli_query($connect_db, $sql_care);
                $row_care = mysqli_fetch_array($result_care);

                if ($row['warranty_end_date'] == null) {
                    $warranty = "ไม่มีข้อมูล";
                } else {

                    $now = strtotime("today");
                    $expire_date = strtotime($row['warranty_end_date']);
                    $datediff = $expire_date - $now;

                    $days_remain = round($datediff / (60 * 60 * 24));
                    if ($days_remain <= 0) {
                        $total_remain = "<font color=red>" . "หมดอายุ " . abs($days_remain) . " วัน" . "</font>";
                    } else {
                        $total_remain = "เหลือ " . $days_remain . " วัน";
                    }
                    $warranty = date("d-m-Y", strtotime($row['warranty_end_date'])) . "<br>" . $total_remain;
                }

                if ($row['return_datetime'] != "") {
                    $log_status = "คืนเครื่องแล้ว";
                } else {
                    $log_status = "กำลังใช้งาน";
                }

            ?>
                <tr id="tr_<?php echo $row['spare_used_id']; ?>">

                    <td class="text-center">
                        <?php echo $i ?>

                    </td>


                    <td class="text-center">
                        <?php echo date("d-m-Y H:i:s", strtotime($row['log_datetime'])); ?>
                    </td>

                    <td class="text-center">
                        <?php echo $row['fullname']; ?>
                    </td>
                    </td>

                    <td class="">
                        <?php echo "<b>ยี่ห้อ : </b>" . $row_brand['brand_name'] . "<br>"; ?>
                        <?php echo "<b>รุ่น : </b>" . $row_model['model_name'] . "<br>"; ?>
                        <?php echo "<b>ประเภทเครื่อง : </b>" . $product_type . "<br>"; ?>
                    </td>

                    <td>
                        <?php echo $log_status; ?>
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>