<?php include('header.php');
include("../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$product_id = $_GET['id'];

$sql = "SELECT * FROM tbl_product a
LEFT JOIN tbl_product_type b ON a.product_type = b.type_id
 WHERE a.product_id = '$product_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);

$serial_no = $row['serial_no'];
$note = $row['note'];
if ($row['install_date'] == null) {
    $install_date = 'ไม่มีข้อมูล';
} else {
    $install_date = date("d-m-Y", strtotime($row['install_date']));
}


if ($row['buy_date'] == null) {
    $buy_date = 'ไม่มีข้อมูล';
} else {
    $buy_date = date("d-m-Y", strtotime($row['buy_date']));
}


if ($row['warranty_start_date'] == null) {
    $warranty_start_date = 'ไม่มีข้อมูล';
} else {
    $warranty_start_date = date("d-m-Y", strtotime($row['warranty_start_date']));
}


if ($row['warranty_expire_date'] == null) {
    $warranty_expire_date = 'ไม่มีข้อมูล';
} else {
    $warranty_expire_date = date("d-m-Y", strtotime($row['warranty_expire_date']));
    $now = strtotime("today");
    $expire_date = strtotime($row['warranty_expire_date']);
    $datediff = $expire_date - $now;

    $days_remain = round($datediff / (60 * 60 * 24));
    if ($days_remain <= 0) {
        $total_remain = "<font color=red>" . "หมดอายุ " . abs($days_remain) . " วัน" . "</font>";
    } else {
        $total_remain = "เหลือ " . $days_remain . " วัน";
    }
}


$brand_id = $row['brand_id'];
$model_id = $row['model_id'];

$sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
$result_brand  = mysqli_query($connect_db, $sql_brand);
$row_brand = mysqli_fetch_array($result_brand);

$sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
$result_model  = mysqli_query($connect_db, $sql_model);
$row_model = mysqli_fetch_array($result_model);



if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}


$current_branch_id = $row['current_branch_id'];
$sql_cus_branch = "SELECT * FROM tbl_customer_branch 
 WHERE customer_branch_id = '$current_branch_id'";
$result_cus_branch  = mysqli_query($connect_db, $sql_cus_branch);
$row_cus_branch = mysqli_fetch_array($result_cus_branch);


$customer_id = $row_cus_branch['customer_id'];
$customer_branch_id = $row_cus_branch['customer_branch_id'];

$sql_customer = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
$result_customer  = mysqli_query($connect_db, $sql_customer);
$row_customer = mysqli_fetch_array($result_customer);
?>
<style>
    .box-input {
        min-height: 90px;
    }
</style>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-10">
        <h2><?php echo "[ " . $serial_no . " ] - " . $row['type_code'] ." ". $row['type_name']; ?></h2>
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="index.php">หน้าแรก</a>
            </li>
            <li class="breadcrumb-item">
                <a href="product_list.php">รายการสินค้า</a>
            </li>
            <li class="breadcrumb-item active">
                <strong><?php echo "[ " . $serial_no . " ] - " . $row['type_code'] ." ". $row['type_name']; ?></strong>
            </li>
        </ol>
    </div>
    <div class="col-lg-2"></div>
</div>
<div class="wrapper wrapper-content">

    <div class="row">
        <?php include('ajax/menu/product_customer_menu.php'); ?>
        <div class="col-md-12">
            <div class="ibox">
                <div class="ibox-title">
                    <h5>รายละเอียดสินค้า</h5>
                </div>
                <div class="ibox-content">
                    <div class="row">
                        <div class="col-md-3 col-12 box-input">
                            <strong>Serial No</strong><br>
                            <?php echo $serial_no; ?>
                        </div>

                        <div class="col-md-3 col-12 box-input">
                            <strong>ประเภทเครื่อง</strong><br>
                            <?php echo  $row['type_code'] . " - " . $row['type_name'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>ยี่ห้อ</strong><br>
                            <?php echo $row_brand['brand_name'] ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>รุ่น</strong><br>
                            <?php echo $row_model['model_name'] ?>
                        </div>


                        <div class="col-md-3 col-12 box-input">
                            <strong>วันที่ติดตั้ง</strong><br>
                            <?php echo $install_date ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>วันที่ซื้อ</strong><br>
                            <?php echo  $buy_date ?>
                        </div>
                        <div class="col-md-3 col-12 box-input">
                            <strong>วันเริ่มประกัน</strong><br>
                            <?php echo  $warranty_start_date ?>
                        </div>
                        <div class="col-3 box-input">
                            <strong>วันหมดประกัน ( <?php echo  $total_remain ?> )</strong><br>
                            <?php echo $warranty_expire_date ?>
                        </div>

                        <div class="col-md-3 col-12 box-input">
                            <strong>ประเภทการรับประกัน</strong><br>
                            <?php echo $warranty_text ?>
                        </div>
                        <div class="col-12 box-input">
                            <strong>หมายเหตุ </strong><br>
                            <?php echo $note ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>