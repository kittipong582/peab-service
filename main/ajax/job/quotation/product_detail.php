<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];

$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];

$product_id = $_POST['product_id'];

$sql = "SELECT a.serial_no,d.type_code,d.type_name,b.brand_name,c.model_name,a.warranty_type,a.install_date,a.warranty_start_date,a.warranty_expire_date FROM tbl_product a 
    LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
    LEFT JOIN tbl_product_model c ON a.model_id = c.model_id
    LEFT JOIN tbl_product_type d ON a.product_type = d.type_id
    WHERE a.product_id = '$product_id' and a.active_status = 1";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_assoc($result);

if ($row['warranty_type'] == 1) {
    $warranty_text = 'ซื้อจากบริษัท';
} else  if ($row['warranty_type'] == 2) {
    $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
} else if ($row['warranty_type'] == 3) {
    $warranty_text = 'สัญญาบริการ';
}
?>

<div class="row">
    <div class="col-mb-3 col-3">
        <label>Serial No</label>
        <input type="text" readonly id="" value="<?php echo $row['serial_no'] ?>" name="" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ประเภทเครื่อง</label>
        <input type="text" readonly id="" value="<?php echo $row['type_code'] . " " . $row['type_name'] ?>" name="" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>ยี่ห้อ</label>
        <input type="text" readonly id="" value="<?php echo $row['brand_name'] ?>" name="" class="form-control">
    </div>
    <div class="mb-3 col-3">
        <label>รุ่น</label>
        <input type="text" readonly id="" value="<?php echo $row['model_name'] ?>" name="" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>ประเภทการรับประกัน</label>
        <input type="text" readonly id="warranty_type" value="<?php echo $warranty_text ?>" name="warranty_type" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่ติดตั้ง</label>
        <input type="text" readonly id="" value="<?php echo ($row['install_date'] != null) ? date("d-m-Y", strtotime($row['install_date'])) : '-'; ?>" name="" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่เริ่มประกัน</label>
        <input type="text" readonly id="" value="<?php echo ($row['warranty_start_date'] != null) ? date("d-m-Y", strtotime($row['warranty_start_date'])) : '-'; ?>" name="" class="form-control">
    </div>

    <div class="mb-3 col-3">
        <label>วันที่หมดประกัน</label>
        <input type="text" readonly id="" value="<?php echo ($row['warranty_expire_date'] != null) ? date("d-m-Y", strtotime($row['warranty_expire_date'])) : '-'; ?>" name="" class="form-control">
    </div>
</div>