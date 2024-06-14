<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$temp_start_date = explode("/", $_POST['start_date']);
$start_date = date("Y-m-d", strtotime($temp_start_date[0] . "-" . $temp_start_date[1] . "-" . $temp_start_date[2]));

$temp_end_date = explode("/", $_POST['end_date']);
$end_date = date("Y-m-d", strtotime($temp_end_date[0] . "-" . $temp_end_date[1] . "-" . $temp_end_date[2]));

$sql = "SELECT report.* 
,branch.branch_name 
,brand.brand_name 
,model.model_name
,product.warranty_start_date
,product.warranty_expire_date
,product.product_type
,ptype.type_name
FROM tbl_report_repair report 
LEFT JOIN tbl_customer_branch branch ON branch.customer_branch_id = report.branch_id 
LEFT JOIN tbl_product product ON product.product_id = report.product_id 
LEFT JOIN tbl_product_brand brand ON brand.brand_id = product.brand_id 
LEFT JOIN tbl_product_model model ON model.model_id = product.brand_id 
LEFT JOIN tbl_product_type ptype ON ptype.type_id = product.product_type
WHERE report.create_datetime BETWEEN '$start_date' AND '$end_date'";

$res = mysqli_query($connect_db, $sql);

?>

<div class="table-responsive">
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;" class="text-center">วันที่แจ้ง</th>
            <th style="width:10%;" class="text-center">ผู้แจ้งซ่อม</th>
            <th style="width:10%;" class="text-center">สาขา</th>
            <th style="width:10%;" class="text-center">รายละเอียด</th>
            <th style="width:5%;" class="text-center">สถานะ</th>
            <th style="width:5%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td>
                    <?php echo date("d/m/Y", strtotime($row['create_datetime'])) ?>
                </td>
                <td>
                    <b> ผู้แจ้ง : </b><?php echo $row['user_report'] ?>
                    <br>
                    <b>เบอร์ : </b><?php echo $row['phone_report'] ?>
                </td>
                <td>
                    <b>สาขา : </b><?php echo $row['branch_name'] ?>
                </td>
                <td>
                    <b>ยี่ห้อ : </b><?php echo $row['brand_name'] ?>
                    <br>
                    <b>รุ่น : </b><?php echo $row['model_name'] ?>
                    <br>
                    <b>ประเภท : </b><?php echo $row['type_name'] ?>
                </td>
                <td>
                    <a href="report_repair_job.php?report=<?php echo $row['report_repair_id']; ?>" class="btn btn-success btn-sm w-100" >เพิ่มงานใหม่</a>
                </td>
                <td>
                    <button class="btn btn-info btn-sm w-100 mb-2" onclick="GetModalDetail('<?php echo $row['report_repair_id']; ?>')"> รายละเอียด </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>
</div>