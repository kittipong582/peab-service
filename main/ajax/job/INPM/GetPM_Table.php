<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];
$job_type = $_POST['job_type'];


if ($search_type == 1) {
    $active = "AND active_status = 1";
    $sql = "SELECT * FROM tbl_product WHERE serial_no LIKE '%$search_value%' $active";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 2) {
    $active = "AND c.active_status = 1";
    if (is_numeric($search_value) == true) {
        $condition = "WHERE d.phone LIKE '%$search_value%' AND product_id is NOT NULL $active GROUP BY c.product_id";
    } else {
        $condition = "WHERE d.customer_name LIKE '%$search_value%' AND product_id is NOT NULL $active GROUP BY c.product_id";
    }
    $sql = "SELECT * FROM tbl_customer_contact a 
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    LEFT JOIN tbl_product c ON c.current_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 3) {
    $sql = "SELECT * FROM tbl_customer_contact a 
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    LEFT JOIN tbl_product c ON c.current_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    WHERE b.branch_code LIKE '%$search_value%' AND product_id is NOT NULL $active GROUP BY c.product_id";
    $result  = mysqli_query($connect_db, $sql);
}

// echo $sql;

?>


<table id="tbl_PM" class="table table-striped table-bordered table-hover">
    <?php if ($search_type == 1) { ?>
        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-left">Serial No</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">ประเภท</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                $branch_id = $row['current_branch_id'];

                $sql_branch = "SELECT *FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id WHERE a.customer_branch_id = '$branch_id'";
                $result_branch = mysqli_query($connect_db, $sql_branch);
                $row_branch = mysqli_fetch_array($result_branch);
                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-left"><?php echo $row['serial_no'] ?></td>
                    <td class="text-center"><?php echo $row_branch['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row_branch['customer_name'] ?></td>
                    <td class="text-center"><?php echo $product_type ?></td>

                    <td>

                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row_branch['customer_branch_id'] ?>');">เลือก</button>
                    </td>

                </tr>
            <?php } ?>
        </tbody>
    <?php } elseif ($search_type == 2) { ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-left">Serial No</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">เบอร์</th>
                <th class="text-center">ประเภท</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                if ($search_type == 1) {
                    $branch_id = $row['current_branch_id'];
                } else {
                    $branch_id = $row['branch_care_id'];
                }
                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-left"><?php echo $row['serial_no'] ?></td>
                    <td class="text-center"><?php echo $row['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo $row['phone'] ?></td>
                    <td class="text-center"><?php echo $product_type ?></td>

                    <td>

                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row['customer_branch_id'] ?>');">เลือก</button>

                    </td>

                </tr>
            <?php } ?>
        </tbody>

    <?php } elseif ($search_type == 3) { ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-left">Serial No</th>
                <th class="text-center">ร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th class="text-center">เบอร์</th>
                <th class="text-center">ประเภท</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {
                if ($search_type == 1) {
                    $branch_id = $row['current_branch_id'];
                } else {
                    $branch_id = $row['branch_care_id'];
                }
                if ($row['product_type'] == 1) {
                    $product_type = 'เครื่องชง';
                } else if ($row['product_type'] == 2) {
                    $product_type = 'เครื่องบด';
                } else if ($row['product_type'] == 3) {
                    $product_type = 'เครื่องปั่น';
                }
            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-left"><?php echo $row['serial_no'] ?></td>
                    <td class="text-center"><?php echo "[ ".$row['branch_code']." ] - ".$row['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo $row['phone'] ?></td>
                    <td class="text-center"><?php echo $product_type ?></td>

                    <td>

                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row['customer_branch_id'] ?>');">เลือก</button>

                    </td>

                </tr>
            <?php } ?>
        </tbody>

    <?php } ?>
</table>