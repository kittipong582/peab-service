<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];


$condition = "";
if ($admin_status == 9) {
    $condition = "";
    $condition1 = "";
} else {
    if ($user_level == 1 || $user_level == 2) {

        $sql_branch = "SELECT branch_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_branch  = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $branch_id = $row_branch['branch_id'];
 
        $condition = "WHERE a.current_branch_id = '$branch_id' AND e.receive_result is null";
        $condition1 = $condition;
    } else if ($user_level == 3) {

        $sql_branch = "SELECT zone_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_branch  = mysqli_query($connect_db, $sql_branch);
        $row_branch = mysqli_fetch_array($result_branch);

        $zone_id = $row_branch['zone_id'];

        $condition = "WHERE d.zone_id = '$zone_id' AND e.receive_result is null";

        $condition1 = $condition;
    }

    
    
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th class="text-left">รหัสทรัพย์สิน</th>
            <th class="text-left">Serial No</th>
            <th class="">รายละเอียด</th>
            <th class="text-center">ประกัน</th>
            <th class="text-center">ทีมดูแล</th>
            <th class="text-center">สาขาที่อยู่</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if($admin_status == 9){
        $i = 0;
        $sql = "SELECT a.*,c.branch_code,c.branch_name FROM tbl_overhaul a
        LEFT JOIN tbl_job b ON b.overhaul_id = a.overhaul_id 
        LEFT JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
        $condition  
        
        
        union 

        SELECT a.*,c.branch_code,c.branch_name FROM tbl_overhaul a
        LEFT JOIN tbl_job b ON b.overhaul_id = a.overhaul_id 
        LEFT JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
        $condition1
        ORDER BY create_datetime";
        }else {


            $sql = "SELECT a.*,c.branch_code,c.branch_name,e.receive_result,e.to_branch_id,e.oh_transfer_id FROM tbl_overhaul a
            LEFT JOIN tbl_job b ON b.overhaul_id = a.overhaul_id 
            LEFT JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
            LEFT JOIN tbl_overhaul_transfer e ON e.overhaul_id = a.overhaul_id 
            $condition  
            
            
            union 
    
            SELECT a.*,c.branch_code,c.branch_name,e.receive_result,e.to_branch_id,e.oh_transfer_id FROM tbl_overhaul a
            LEFT JOIN tbl_job b ON b.overhaul_id = a.overhaul_id 
            LEFT JOIN tbl_customer_branch c ON b.customer_branch_id = c.customer_branch_id
            LEFT JOIN tbl_overhaul_transfer e ON e.overhaul_id = a.overhaul_id 
            WHERE e.to_branch_id = '$branch_id' AND e.receive_result is null 
            ORDER BY create_datetime";
            

        }
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
            $overhaul = $row['overhaul_id'];
            $brand_id = $row['brand_id'];
            $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
            $result_brand  = mysqli_query($connect_db, $sql_brand);
            $row_brand = mysqli_fetch_array($result_brand);

            $model_id = $row['model_id'];
            $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
            $result_model  = mysqli_query($connect_db, $sql_model);
            $row_model = mysqli_fetch_array($result_model);
            $current_branch_id = $row['current_branch_id'];

            $sql_care = "SELECT *  FROM tbl_branch WHERE branch_id = '$current_branch_id'";
            $result_care  = mysqli_query($connect_db, $sql_care);
            $row_care = mysqli_fetch_array($result_care);



            $sql_transfer = "SELECT * FROM tbl_overhaul_transfer WHERE overhaul_id = '{$row['overhaul_id']}' AND receive_result is null";
            $result_transfer  = mysqli_query($connect_db, $sql_transfer);
            $row_transfer = mysqli_fetch_array($result_transfer);



            if ($row['overhaul_owner'] == 1) {
                $overhaul_owner = 'เครื่องบริษัท';
            } else if ($row['overhaul_owner'] == 2) {
                $overhaul_owner = 'ไม่ใช่เครื่องบริษัท';
            }



            $log = "SELECT * FROM tbl_overhaul_log WHERE overhaul_id = '$overhaul' AND return_datetime is NULL LIMIT 1";
            $result_log  = mysqli_query($connect_db, $log);
            $row_log = mysqli_fetch_array($result_log);

            // echo $log;
            $days_remain = "";
            $current_data = "";
            if ($row['current_customer_branch_id'] != null) {

                $datetime_now = strtotime("NOW");
                $datediff = $datetime_now - strtotime($row_log['create_datetime']);
                $days_remain = round($datediff / (60 * 60 * 24));

                $current_data = $row['branch_code'] . "  " . $row['branch_name'] . "<br>" . $days_remain . " วัน";
            }
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-left"><?php echo $row['ax_no']; ?></td>
                <td class="text-left"><?php echo $row['serial_no']; ?></td>
                <td class="">
                    <?php echo "<b>ยี่ห้อ : </b>" . $row_brand['brand_name'] . "<br>"; ?>
                    <?php echo "<b>รุ่น : </b>" . $row_model['model_name'] . "<br>"; ?>
                    <?php echo "<b>ประเภทเครื่อง : </b>" . $product_type . "<br>"; ?>
                </td>
                <td class="text-center"><?php echo $overhaul_owner; ?></td>
                <td class="text-center"><?php echo $row_care['branch_name']; ?></td>
                <td class="text-center"><?php echo $current_data; ?></td>
                <td>

                    <?php if ($result_transfer->num_rows == 1 && $row_transfer['to_branch_id'] == $branch_id || $result_transfer->num_rows == 1 && $admin_status == 9) { ?>
                        <div style="padding-bottom: 1ex;">
                            <button class="btn btn-xs btn-success btn-block" onclick="ModalReceive('<?php echo $row_transfer['oh_transfer_id'] ?>');">ยืนยันการรับโอน</button>
                        </div>
                    <?php } ?>

                    <?php if ($row['current_branch_id'] == $branch_id || $admin_status == 9) { ?>
                        <div style="padding-bottom: 1ex;">
                            <a href="view_overhaul.php?id=<?php echo $overhaul; ?>"><button class="btn btn-xs btn-success btn-block">ข้อมูล</button></a>
                        </div>
                        <div style="padding-bottom: 1ex;">
                            <button class="btn btn-xs btn-warning btn-block" onclick="ModalEdit('<?php echo $overhaul ?>');">แก้ไข</button>
                        </div>
                    <?php } ?>


                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>