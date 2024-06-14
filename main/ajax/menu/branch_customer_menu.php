<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pagename = basename($_SERVER['PHP_SELF']);
// $color = "style='background-color: #23c6c8; box-shadow: inset 0 0 0 #12a7a9, 0 5px 0 0 #19a3a5, 0 10px 5px #999999 !important; border-color: #23c6c8;'";

$customer_branch_id = $_GET['id'];

$sql = "SELECT a.*, (a.branch_id) AS id,b.*,(b.branch_name) AS b_name FROM tbl_branch a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id WHERE b.customer_branch_id = '$customer_branch_id'";
$result  = mysqli_query($connect_db, $sql);
$row = mysqli_fetch_array($result);



$sql_receive = "SELECT product_id FROM tbl_product_transfer WHERE to_branch_id = '$customer_branch_id' AND receive_result is null";
$result_receive  = mysqli_query($connect_db, $sql_receive);
$row_receive = mysqli_fetch_array($result_receive);


$product_id = $row_receive['product_id'];
// echo $sql;

?>

<div class="col-lg-12">
    <div class="ibox">
        <div class="ibox-content" style="padding: 15px 15px 15px 15px;">
            <div class="col-lg-12">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="row">

                            <div class="col-md-2">

                                <a href='branch_view_detail.php?id=<?php echo $customer_branch_id; ?>' class="btn btn-block dim <?php if ($pagename == 'branch_view_detail.php') echo ' btn-secondary';
                                                                                                                                else {
                                                                                                                                    echo 'btn-info';
                                                                                                                                } ?>">ภาพรวม</a>

                            </div>

                            <div class="col-md-2">

                                <a href='product.php?id=<?php echo $customer_branch_id ?>' class="btn btn-block dim <?php if ($pagename == 'product.php') echo ' btn-secondary';
                                                                                                                    else {
                                                                                                                        echo 'btn-info';
                                                                                                                    } ?>">รายการสินค้า</a>

                            </div>

                            <div class="col-md-2">

                                <a href='branch_job.php?id=<?php echo $customer_branch_id ?>' class="btn btn-block dim <?php if ($pagename == 'branch_job.php') echo ' btn-secondary';
                                                                                                                        else {
                                                                                                                            echo 'btn-info';
                                                                                                                        } ?>">ประวัติใบงาน</a>

                            </div>


                            <div class="col-md-2">

                                <a href='daily_record.php?id=<?php echo $customer_branch_id; ?>' class="btn btn-block dim <?php if ($pagename == 'daily_record.php') echo ' btn-secondary';
                                                                                                                            else {
                                                                                                                                echo 'btn-info';
                                                                                                                            } ?>">บันทึกประจำวัน</a>

                            </div>


                            <div class="col-md-2">

                                <a href='customer_edit_branch.php?id=<?php echo $customer_branch_id; ?>' class="btn btn-block dim <?php if ($pagename == 'customer_edit_branch.php') echo ' btn-secondary';
                                                                    else {
                                                                        echo 'btn-warning';
                                                                    } ?>">แก้ไข</a>

                            </div>

                            <?php if ($result_receive->num_rows > 0) { ?>
                                <div class="col-md-2">

                                    <a href='product_receive.php?id=<?php echo $customer_branch_id; ?>' class="btn btn-block dim <?php if ($pagename == 'product_receive.php') echo ' btn-secondary';
                                                                                                                                    else {
                                                                                                                                        echo 'btn-info';
                                                                                                                                    } ?>">รับโอนเครื่อง</a>

                                </div>
                            <?php } ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>