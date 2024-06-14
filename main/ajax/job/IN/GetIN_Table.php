<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];
$job_type = $_POST['job_type'];



if ($search_type == 3) {

    $condition = "WHERE b.branch_code LIKE '%$search_value%' OR b.branch_name LIKE '%$search_value%' GROUP BY b.customer_branch_id";
} else {
    if (is_numeric($search_value) == true) {
        $condition = "WHERE d.phone LIKE '%$search_value%' GROUP BY b.customer_branch_id";
    } else {
        $condition = "WHERE d.customer_name LIKE '%$search_value%'  GROUP BY b.customer_branch_id";
    }
}


$sql = "SELECT c.branch_name AS team_name,b.branch_name AS b_name,d.customer_name,d.phone,b.customer_branch_id,b.branch_code FROM tbl_customer_branch b 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    LEFT JOIN tbl_branch c ON  b.branch_care_id = c.branch_id
    $condition";
$result  = mysqli_query($connect_db, $sql);

// echo $sql;
?>


<table id="tbl_IN" class="table table-striped table-bordered table-hover">
    <?php if ($job_type == 3 && $search_type == 2) { ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">เบอร์</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {


            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>

                    <td class="text-center"><?php echo "[".$row['branch_code']."] - ".$row['b_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo $row['phone'] ?></td>

                    <td>
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_IN('<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                        <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                    </td>

                </tr>
            <?php } ?>
        </tbody>


    <?php } else if ($search_type == 3) { ?>


        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">ทีมดูแล</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {


            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>

                    <td class="text-center"><?php echo "[".$row['branch_code']."] - ".$row['b_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo $row['team_name'] ?></td>

                    <td>
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_IN('<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                        <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                    </td>

                </tr>
            <?php } ?>
        </tbody>

    <?php   } ?>
</table>