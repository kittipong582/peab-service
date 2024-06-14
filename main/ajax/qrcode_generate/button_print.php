<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_group = mysqli_real_escape_string($connect_db, $_POST['customer_group_mol']);

// if ($customer_group != "x" &&  $customer_group != 0) {
//     $condi_group = $con_group . "c.customer_group = '$customer_group'";
// } else if ($customer_group == 0 && $customer_group != "x") {
//     $condi_group = $con_group . "c.customer_group IS NULL";
// } else {
//     $condi_group = "";
// }
if ($customer_group == 6) {
    $condi_group = $con_group . " AND (b.branch_code LIKE 'CC%' 
    OR b.branch_code LIKE 'SC%' 
    OR b.branch_code LIKE 'SD%' 
    OR b.branch_code LIKE 'RM%' 
    OR b.branch_code LIKE 'JM%' 
    OR b.branch_code LIKE 'DD%' 
    OR b.branch_code LIKE 'CD%'
    OR b.branch_code = 'C1100737' 
    OR b.branch_code = 'C1100738')";
} else if ($customer_group == 7 ) {
    $condi_group = $con_group . "AND NOT(b.branch_code LIKE 'CC%' 
    OR b.branch_code LIKE 'SC%' 
    OR b.branch_code LIKE 'SD%' 
    OR b.branch_code LIKE 'RM%' 
    OR b.branch_code LIKE 'JM%' 
    OR b.branch_code LIKE 'DD%' 
    OR b.branch_code LIKE 'CD%'
    OR b.branch_code = 'C1100737' 
    OR b.branch_code = 'C1100738')";
} else {
    $condi_group = "";
}

// $sql = "SELECT b.branch_name
// -- ,IF(b.branch_code != 'null' , b.branch_code ,'-') AS branch_code , b.branch_name 
// FROM tbl_customer a 
// LEFT JOIN tbl_customer_branch b ON  b.customer_id = a.customer_id
// LEFT JOIN tbl_qr_code c ON c.branch_id = b.customer_branch_id
// WHERE a.active_status = 1 AND $condi_group";

// $res = mysqli_query($connect_db, $sql);
// $total_record = mysqli_num_rows($res);
// $list_size = 600;

$sql = "SELECT a.*
,b.branch_name
,c.customer_name
FROM tbl_qr_code a
LEFT JOIN tbl_customer_branch b ON b.customer_branch_id = a.branch_id
LEFT JOIN tbl_customer c ON c.customer_id = b.customer_id
WHERE b.active_status = '1'  $condi_group";
$res = mysqli_query($connect_db, $sql);
$total_record = mysqli_num_rows($res);
$list_size = 600;
$number = range(0, $total_record, $list_size);


if ($total_record < $list_size) {
    $number = $total_record;
?>
    <div class="row">
        <div class="col-4">
            <a href="../print/print_qr_all.php?page=0&group=<?php echo $customer_group; ?>" target="_blank" class="btn btn-primary btn-sm mb-1 btn-block ">
                <?php echo '1 - ' . $number ?>
            </a>
        </div>
    </div>
<?php
} else {
    $number = range(0, $total_record, $list_size);
?>
    <div class="row">
        <?php foreach ($number as $a) { ?>
            <div class="col-4">
                <a href="../print/print_qr_all.php?page=<?php echo $a; ?>&group=<?php echo $customer_group; ?>" target="_blank" class="btn btn-primary btn-sm mb-1 btn-block ">
                    <?php echo $a + 1 ?> - <?php echo ($a + $list_size > $total_record ? $total_record : $a + $list_size) ?>
                </a>
            </div>
        <?php } ?>
    </div>
<?php
}

?>