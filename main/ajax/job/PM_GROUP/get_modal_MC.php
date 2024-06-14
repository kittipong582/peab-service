<?php
session_start();
include("../../../../config/main_function.php");
$secure = "LM=VjfQ{6rsm&/h`";
$connection = connectDB($secure);

$customer_branch_id = mysqli_real_escape_string($connection, $_POST['customer_branch_id']);
$temp_id = "''";
foreach ($_POST['choose_product_id'] as $value) {
    $temp_id .= $temp_id == '' ? "'$value'" : ",'$value'";
}

$sql = "SELECT 
cb.customer_branch_id 
,cb.branch_name
,pd.product_id
,pt.type_code
,pt.type_name
,pd.serial_no 
,pb.brand_name
,pdm.model_name
,pd.warranty_type
,pd.install_date
,pd.warranty_start_date
,pd.warranty_expire_date
FROM tbl_customer_branch cb
JOIN tbl_product pd ON pd.current_branch_id = cb.customer_branch_id  
JOIN tbl_product_brand pb ON pb.brand_id = pd.brand_id
JOIN tbl_product_model pdm ON pdm.model_id = pd.model_id 
JOIN tbl_product_type pt ON pt.type_id = pd.product_type
WHERE cb.customer_branch_id  = '$customer_branch_id' AND pd.active_status = '1' AND pd.product_id NOT IN ($temp_id)";
$res = mysqli_query($connection, $sql) or die($connection->error);

?>
<div class="modal-header">
    <h4 class="modal-title">เลือกเครื่อง</h4>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
</div>
<div class="modal-body">
    <table class="table table-striped">
        <?php while ($row = mysqli_fetch_assoc($res)) { ?>
            <tr>
                <td><?php echo $row['model_name']; ?></td>
                <td><button class="btn btn-primary btn-xs" onclick="AddTab('<?php echo $row['product_id']; ?>')">เลือก</button></td>
            </tr>
        <?php } ?>
    </table>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-white" data-dismiss="modal">ปิด</button>
</div>