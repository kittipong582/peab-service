<?php
include("../../../config/main_function.php");
$connection = connectDB("LM=VjfQ{6rsm&/h`");

$report_id = mysqli_real_escape_string($connection, $_POST['report_id']);
$sql = "SELECT report.* 
,branch.branch_name 
,brand.brand_name 
,model.model_name
,product.warranty_start_date
,product.warranty_expire_date
,product.product_type
,ptype.type_name
,GROUP_CONCAT(rimg.image_file) AS image_file
FROM tbl_report_repair report 
LEFT JOIN tbl_customer_branch branch ON branch.customer_branch_id = report.branch_id 
LEFT JOIN tbl_product product ON product.product_id = report.product_id 
LEFT JOIN tbl_product_brand brand ON brand.brand_id = product.brand_id 
LEFT JOIN tbl_product_model model ON model.model_id = product.brand_id 
LEFT JOIN tbl_product_type ptype ON ptype.type_id = product.product_type
LEFT JOIN tbl_report_repair_image rimg ON rimg.report_repair_id = report.report_repair_id
WHERE report.report_repair_id = '$report_id'";

$res = mysqli_query($connection, $sql);
$row = mysqli_fetch_assoc($res);


$sql_image = "SELECT * FROM tbl_report_repair_image  WHERE report_repair_id  = '{$row['report_repair_id']}'";
$res_image = mysqli_query($connection, $sql_image);


?>
<div class="modal-header">
    <h4 class="modal-title">รายละเอียดการแจ้งซ่อม</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-12">
            <b>วันที่แจ้ง : </b><?php echo date("d/m/Y", strtotime($row['create_datetime'])); ?> <br>
            <b> สาขา : </b><?php echo $row['branch_name'] ?><br>
            <b>ยี่ห้อ : </b><?php echo $row['brand_name'] ?><br>
            <b>รุ่น : </b><?php echo $row['model_name'] ?><br>
            <b>ประเภท : </b><?php echo $row['type_name'] ?><br>
            <b>อาการเสีย : </b><?php echo $row['description']; ?>
        </div>
        <div class="col-12">
            <b>รูปภาพ :</b>
            <div class="text-center">
                <div class="row">

                    <?php
                    $temp_data = explode(',', $row['image_file']);
                    $count = count($temp_data);

                    for ($i = 0; $i < $count; $i++) {
                        //echo $temp_data[$i];
                    ?>
                        <div class="col-6">
                            <img src="http://peaberry-care.com/image/report_repair/<?php echo $temp_data[$i]; ?>" alt="" class="mt-3" style="width: 50%;">
                        </div>
                    <?php } ?>
                </div>

            </div>
        </div>


    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>