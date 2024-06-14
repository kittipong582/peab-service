<?php
session_start();
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$branch_id = $_POST['branch_id'];

$user_level = $_SESSION['user_level'];
$user_id = $_SESSION['user_id'];

$customer_branch_id = $_POST['customer_branch_id'];
$condition = "";
if ($_POST['customer_branch_id'] != "") {
    $product_id2 = $_POST['product_id2'];
    $condition = "AND a.product_id = '$product_id2'";

    $if_con = "(" . $product_id2 . " == " . $row['product_id'] . ")? SELECTED : ' '";
}

$sql = "SELECT a.serial_no,d.type_code,d.type_name,b.brand_name,c.model_name,a.product_id FROM tbl_product a 
    LEFT JOIN tbl_product_brand b ON a.brand_id = b.brand_id
    LEFT JOIN tbl_product_model c ON a.model_id = c.model_id
    LEFT JOIN tbl_product_type d ON a.product_type = d.type_id
    WHERE a.current_branch_id = '$customer_branch_id' and a.active_status = 1 $condition";
$result  = mysqli_query($connect_db, $sql);

?>


<select class="form-control select2 mb-3" style="width: 100%;" onchange="Select_product_QT(this.value)" name="product_select" id="product_select">
    <option value="">เลือกเครื่อง</option>
    <?php while ($row = mysqli_fetch_array($result)) { ?>
        <option value="<?php echo $row['product_id'] ?>" <?php echo $if_con; ?>><?php echo $row['serial_no'] . " - " . $row['type_name'] . " " . $row['brand_name'] . " " . $row['model_name'] ?></option>
    <?php  } ?>
</select>