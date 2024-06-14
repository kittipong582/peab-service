<?php
session_start();
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$pagename = basename($_SERVER['PHP_SELF']);
// $color = "style='background-color: #23c6c8; box-shadow: inset 0 0 0 #12a7a9, 0 5px 0 0 #19a3a5, 0 10px 5px #999999 !important; border-color: #23c6c8;'";

$product_id = $_GET['id'];

// $sql = "SELECT a.*, (a.branch_id) AS id,b.*,(b.branch_name) AS b_name FROM tbl_branch a 
// LEFT JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id WHERE b.customer_branch_id = '$customer_branch_id'";
// $result  = mysqli_query($connect_db, $sql);
// $row = mysqli_fetch_array($result);

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

                                <a href='product_view_detail.php?id=<?php echo $product_id; ?>' class="btn btn-block dim <?php if ($pagename == 'product_view_detail.php') echo ' btn-secondary';
                                                                                                                            else {
                                                                                                                                echo 'btn-info';
                                                                                                                            } ?>">ภาพรวม</a>

                            </div>

                            <div class="col-md-2">

                                <a href='product_history.php?id=<?php echo $product_id; ?>' class="btn btn-block dim <?php if ($pagename == 'product_history.php') echo ' btn-secondary';
                                                                                        else {
                                                                                            echo 'btn-info';
                                                                                        } ?>">ประวัติการงาน</a>

                            </div>


                            <div class="col-md-2">

                                <a href='#' class="btn btn-block dim <?php if ($pagename == '#') echo ' btn-secondary';
                                                                        else {
                                                                            echo 'btn-info';
                                                                        } ?>">บันทึกประจำวัน</a>

                            </div>

                            <div class="col-md-2">

                                <a href='product_transfer.php?id=<?php echo $product_id; ?>' class="btn btn-block dim <?php if ($pagename == 'product_transfer.php') echo ' btn-secondary';
                                                                        else {
                                                                            echo 'btn-info';
                                                                        } ?>">โอนย้าย</a>

                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>