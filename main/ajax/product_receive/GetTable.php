<?php
include("../../../config/main_function.php");
session_start();
$to_branch_id = $_POST['to_branch_id'];
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];

$sql_user = "SELECT * FROM tbl_user 
WHERE user_id = '$user_id'";
$result_user  = mysqli_query($connect_db, $sql_user);
$row_user = mysqli_fetch_array($result_user);



?>

<table class="table table-striped table-bordered table-hover tbl_transfer" id="tbl_transfer">
    <thead>
        <tr>
            <th style="width:2%;">#</th>
            <th class="text-left">Transfer No</th>
            <th class="text-center" style="width:15%;">สาขางาน (ต้นทาง)</th>
            <th class="text-center" style="width:15%;">เครื่อง</th>
            <th class="text-center">ผู้ทำรายการ</th>
            <th class="text-center" style="width:10%;">ผู้อนุมัติรับ</th>
            <th class="text-center" style="width:15%;">หมายเหตุ</th>
            <th class="text-center">สถานะ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT a.*,d.branch_name AS team_name,c.branch_name As cus_branch_name,e.fullname AS receive_name,b.fullname AS create_name,f.brand_id,f.model_id,f.serial_no FROM tbl_product_transfer a
        LEFT JOIN tbl_user b ON a.create_user_id = b.user_id
        LEFT JOIN tbl_customer_branch c ON a.to_branch_id = c.customer_branch_id
        LEFT JOIN tbl_customer_branch d ON a.from_branch_id = d.customer_branch_id
        LEFT JOIN tbl_user e ON a.receive_user_id = e.user_id
        LEFT JOIN tbl_product f ON f.product_id = a.product_id
         WHERE a.to_branch_id = '$to_branch_id' AND a.receive_result is null ORDER BY a.create_datetime";
        $result  = mysqli_query($connect_db, $sql);

        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {

            if ($row['product_type'] == 1) {
                $product_type = 'เครื่องชง';
            } else if ($row['product_type'] == 2) {
                $product_type = 'เครื่องบด';
            } else if ($row['product_type'] == 3) {
                $product_type = 'เครื่องปั่น';
            }
            $product_id = $row['product_id'];
            $brand_id = $row['brand_id'];
            $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
            $result_brand  = mysqli_query($connect_db, $sql_brand);
            $row_brand = mysqli_fetch_array($result_brand);

            $model_id = $row['model_id'];
            $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
            $result_model  = mysqli_query($connect_db, $sql_model);
            $row_model = mysqli_fetch_array($result_model);

            $sql_branch = "SELECT * FROM tbl_customer_branch WHERE branch_care_id = '{$row_user['branch_id']}' AND  customer_branch_id = '{$row['to_branch_id']}'";
            $result_branch  = mysqli_query($connect_db, $sql_branch);
            $row_cnt = mysqli_num_rows($result_branch);

            if ($row['receive_result'] == 1) {
                $status = "รับโอนแล้ว";
            } else if ($row['receive_result'] == 2) {
                $status = "ยกเลิกการโอนแล้ว";
            } else {
                $status = "รอดำเนินการ";
            }

        ?>
            <tr>
                <td><?php echo ++$i; ?></td>

                <td class="text-left"><?php echo $row['transfer_no']; ?></td>
                <td class="text-center"><?php echo $row['team_name']; ?></td>
                <td class="text-center"><?php echo "[ " . $row['serial_no'] . " ] - " . $row_brand['brand_name'] . $row_model['model_name']; ?><br><?php echo $product_type; ?></td>

                <td class="text-center"><?php echo $row['create_name']; ?><br><?php echo date("d-m-Y", strtotime($row['create_datetime'])); ?></td>
                <td class="text-center"><?php echo $row['receive_name']; ?><br><?php echo ($row['receive_datetime'] != null ? date("d-m-Y", strtotime($row['receive_datetime'])) : " "); ?></td>
                <td class="text-center"><?php echo $row['note']; ?></td>
                <td class="text-center"><?php echo $status ?></td>
                <td>
                    <?php if ($user_level == 2 && $row_cnt == 1 && $row['receive_result'] == null || $admin_status == 9  && $row['receive_result'] == null) {
                    ?>
                        <div style="padding-bottom: 1ex;">
                            <button class="btn btn-xs btn-success btn-block" onclick="ModalReceive('<?php echo $row['transfer_id'] ?>');">ยืนยันการรับโอน</button>
                        </div>
                    <?php } ?>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>