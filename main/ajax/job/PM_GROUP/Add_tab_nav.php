<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$num_tab = mysqli_real_escape_string($connect_db, $_POST['num_tab']);
$product_id = mysqli_real_escape_string($connect_db, $_POST['product_id']);

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
WHERE pd.product_id = '$product_id' AND pd.active_status = '1'";
$res = mysqli_query($connect_db, $sql) or die($connect_db->error);
$num_row = mysqli_num_rows($res);
$row = mysqli_fetch_assoc($res);
?>
<li id="li_<?php echo $num_tab ?>">
    <a class="nav-link tab_head_<?php echo $num_tab ?>" id="tab_head_<?php echo $num_tab ?>" href="#tab-<?php echo $num_tab ?>" data-toggle="tab">
        <?php echo $row['model_name']; ?>
        <button type="button" class="btn btn-danger btn-xs" onclick="RemoveMCTab('<?php echo $num_tab ?>')">X</button>
    </a>
</li>