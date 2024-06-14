<?php
session_start();
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$user_id = $_SESSION['user_id'];
$user_level = $_SESSION['user_level'];
$admin_status = $_SESSION['admin_status'];
$name_branch = $_POST['name_branch'];
$search_type = $_POST['search_type'];


if ($search_type == 1) {

    $condition_name = "AND a.branch_code LIKE '%$name_branch%'";
} else if ($search_type == 2) {
    $condition_name = "AND a.branch_name LIKE '%$name_branch%'";
} else if ($search_type == 3) {
    $condition_name = "AND c.customer_code LIKE '%$name_branch%'";
} elseif ($search_type == 4) {
    $condition_name = "AND c.customer_name LIKE '%$name_branch%'";
}

if (!empty($name_branch)) {
    if ($admin_status == 9 || $user_level == 4) {

        $sql = "SELECT a.*,b.*,(a.branch_name) AS cus_branch_name,a.district_id as dis_id,c.customer_name,c.customer_code  FROM tbl_customer_branch a 
LEFT JOIN tbl_branch b ON b.branch_id = a.branch_care_id 
LEFT JOIN tbl_customer c ON a.customer_id = c.customer_id
WHERE 1  $condition_name  order by b.branch_name";
        $result  = mysqli_query($connect_db, $sql);
    } else {



        $sql_user = "SELECT branch_id FROM tbl_user WHERE user_id = '$user_id'";
        $result_user  = mysqli_query($connect_db, $sql_user);
        $row_user = mysqli_fetch_array($result_user);

        if ($user_level == 1 || $user_level == 2) {

            $sql = "SELECT a.*,b.*,(a.branch_name) AS cus_branch_name,c.customer_name,c.customer_code  FROM tbl_customer_branch a 
        LEFT JOIN tbl_branch b ON b.branch_id = a.branch_care_id 
        LEFT JOIN tbl_customer c ON a.customer_id = c.customer_id
         WHERE b.branch_id = '{$row_user['branch_id']}' $condition_name order by b.branch_name";
            $result  = mysqli_query($connect_db, $sql);
        }
    }
}

// echo $sql;
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:7%;" class="text-center">รหัสสาขา</th>
            <th class="text-left">ชื่อสาขา</th>
            <th class="text-left">ชื่อลูกค้า</th>
            <th class="text-left">การติดต่อ</th>
            <th class="text-left" style="width:10%;">ที่ตั้ง</th>
            <th class="text-center">ทีมงานที่ดูแล</th>
            <th class="text-center" style="width:10%;">จำนวนเครื่อง</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        // echo $sql;
        while ($row = mysqli_fetch_array($result)) {



            $customer_id = $row['customer_id'];
            $customer_branch_id = $row['customer_branch_id'];
            $branch_code = $row['branch_code'];

            $sql_count = "SELECT * FROM tbl_customer WHERE customer_id = '$customer_id'";
            $result_count  = mysqli_query($connect_db, $sql_count);
            $row_count = mysqli_fetch_array($result_count);

            $sql_countact = "SELECT * FROM tbl_customer_contact WHERE customer_branch_id = '$customer_branch_id' AND main_contact_status = 1 ;";
            $result_countact  = mysqli_query($connect_db, $sql_countact);
            $row_countact = mysqli_fetch_array($result_countact);

            $sql_address = "SELECT a.district_id,b.amphoe_name_th,c.province_name_th FROM tbl_district a
            LEFT JOIN tbl_amphoe b ON a.ref_amphoe = b.amphoe_id 
            LEFT JOIN tbl_province c ON b.ref_province = c.province_id
            WHERE a.district_id = '{$row['dis_id']}' ;";
            $result_address  = mysqli_query($connect_db, $sql_address);
            $row_address = mysqli_fetch_array($result_address);

            $sql_c = "SELECT COUNT(product_id) AS count_p FROM tbl_product WHERE current_branch_id = '$customer_branch_id' ;";
            $result_c  = mysqli_query($connect_db, $sql_c);
            $row_c = mysqli_fetch_array($result_c);

            // echo $sql_address;


        ?>
            <tr>
                <td class="text-center"><?php echo $branch_code; ?></td>
                <td><?php echo $row['cus_branch_name']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row_countact['contact_name']; ?> <br> <?php echo $row_countact['contact_phone']; ?> </td>
                <td><?php echo $row_address['province_name_th']; ?></td>
                <td class="text-center"><?php echo $row['branch_name']; ?></td>
                <td class="text-center"><?php echo $row_c['count_p']; ?></td>
                <td>
                    <a href="branch_view_detail.php?id=<?php echo $row['customer_branch_id']; ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>