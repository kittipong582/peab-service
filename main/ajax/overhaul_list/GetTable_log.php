<?php
include("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$overhaul_id = $_POST['overhaul_id'];
$sql = "SELECT *,a.create_datetime as log_datetime,d.branch_name AS dname FROM tbl_overhaul_log a 
LEFT JOIN tbl_overhaul b ON a.overhaul_id = b.overhaul_id 
LEFT JOIN tbl_user c ON a.create_user_id = c.user_id
LEFT JOIN tbl_customer_branch d ON b.current_customer_branch_id = d.customer_branch_id
WHERE a.overhaul_id = '$overhaul_id' ORDER BY a.create_datetime";
$rs = mysqli_query($connect_db, $sql) or die($connect_db->error);

?>

<div class="table-responsive">

    <table class="table table-striped table-bordered  tbl_log" id="tbl_log">

        <thead>

            <tr>

                <th width="10%"></th>

                <th width="" class="text-center">วันที่ทำรายการ</th>

                <th width="" class="text-center">ผู้ทำรายการ</th>

                <th width="" class="text-center">สาขา</th>


            </tr>

        </thead>

        <tbody>

            <?php
            while ($row = mysqli_fetch_assoc($rs)) {
               
                $i++;

                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }
                $overhaul = $row['overhaul_id'];
                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand  = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model  = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);
                $branch_id = $row['current_branch_id'];

                $sql_care = "SELECT *  FROM tbl_branch WHERE branch_id = '$branch_id'";
                $result_care  = mysqli_query($connect_db, $sql_care);
                $row_care = mysqli_fetch_array($result_care);

                if ($row['warranty_end_date'] == null) {
                    $warranty = "ไม่มีข้อมูล";
                } else {

                    $now = strtotime("today");
                    $expire_date = strtotime($row['warranty_end_date']);
                    $datediff = $expire_date - $now;

                    $days_remain = round($datediff / (60 * 60 * 24));
                    if ($days_remain <= 0) {
                        $total_remain = "<font color=red>" . "หมดอายุ " . abs($days_remain) . " วัน" . "</font>";
                    } else {
                        $total_remain = "เหลือ " . $days_remain . " วัน";
                    }
                    $warranty = date("d-m-Y", strtotime($row['warranty_end_date'])) . "<br>" . $total_remain;
                }


            ?>
                <tr id="tr_<?php echo $row['spare_used_id']; ?>">

                    <td class="text-center">
                        <?php echo $i ?>

                    </td>


                    <td class="text-center">
                        <?php echo date("d-m-Y H:i:s", strtotime($row['log_datetime'])); ?>
                    </td>

                    <td class="text-center">
                        <?php echo $row['fullname']; ?>
                    </td>
                    </td>

                    <td class="text-center">
                        <?php echo $row['dname']; ?>
                       
                    </td>

                </tr>

            <?php } ?>

        </tbody>

    </table>

</div>