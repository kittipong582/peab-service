<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];
$job_type = $_POST['job_type'];



if ($job_type == 3 && $search_type == 2) {

    if (is_numeric($search_value) == true) {
        $condition = "WHERE phone LIKE '%$search_value%' GROUP BY b.customer_branch_id";
    } else {
        $condition = "WHERE customer_name LIKE '%$search_value%'  GROUP BY b.customer_branch_id";
    }
    $sql = "SELECT * FROM tbl_customer_contact a 
    LEFT JOIN tbl_customer_branch b ON a.customer_branch_id = b.customer_branch_id 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    $condition";
    $result = mysqli_query($connect_db, $sql);
} else if ($search_type == 3) {

    $active = "AND b.active_status = 1";
    $sql = "SELECT * FROM tbl_customer_branch b 
    LEFT JOIN tbl_product c ON c.current_branch_id = b.customer_branch_id
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    WHERE b.branch_code LIKE '%$search_value%' AND product_id is NOT NULL $active  OR b.branch_name LIKE '%$search_value%' AND product_id is NOT NULL $active GROUP BY c.product_id";
    $result = mysqli_query($connect_db, $sql);
} else if ($search_type == 1) {

    $active = "AND a.active_status = 1";
    $sql = "SELECT * FROM tbl_product a 
    LEFT JOIN tbl_product_type e ON e.type_id = a.product_type
    WHERE a.serial_no LIKE '%$search_value%' $active";
    $result = mysqli_query($connect_db, $sql);
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
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
    $condition";
    $result = mysqli_query($connect_db, $sql);
}

// echo $sql;
?>


<table id="tbl_CM" class="table table-striped table-bordered table-hover">
    <?php if ($job_type == 3 && $search_type == 2) { ?>

    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:40%;" class="text-center">ชื่อร้าน</th>
            <th style="width:20%;" class="text-center">ลูกค้า</th>
            <th style="width:20%;" class="text-center">เบอร์</th>
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
                } ?>
        <tr>
            <td>
                <?php echo ++$i; ?>
            </td>

            <td class="text-center">
                <?php echo $row['branch_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row['customer_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row['phone'] ?>
            </td>

            <td>
                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_Product('','<?php echo $row['customer_id'] ?>');">เลือก</button>
                <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
            </td>

        </tr>
        <?php } ?>
    </tbody>


    <?php } else if ($search_type == 1) { ?>
    <thead>
        <tr>
            <th style="width:10%;">#</th>
            <th style="width:7%;" class="text-left">Serial No</th>
            <th style="width:23%;" class="text-left">เครื่อง</th>
            <th style="width:10%;" class="text-center">ประเภท</th>
            <th class="text-center" style="width:20%;">ชื่อร้าน</th>
            <th style="width:10%;" class="text-center">ลูกค้า</th>

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {

                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);


                $product_detail = $row_brand['brand_name'] . " " . $row_model['model_name'];

                $branch_id = $row['current_branch_id'];


                $sql_branch = "SELECT *FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id WHERE a.customer_branch_id = '$branch_id'";
                $result_branch = mysqli_query($connect_db, $sql_branch);
                $row_branch = mysqli_fetch_array($result_branch);


                ?>
        <tr>
            <td>
                <?php echo ++$i; ?>
            </td>
            <td class="text-left">
                <?php echo $row['serial_no'] ?>
            </td>
            <td class="text-left">
                <?php echo $product_detail ?>
            </td>
            <td class="text-center">
                <?php echo $row['type_code'] . " - " . $row['type_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row_branch['branch_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row_branch['customer_name'] ?>
            </td>


            <td>
                <?php if ($job_type == 1|| $job_type == 7) { ?>
                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_CM_Product('<?php echo $row['product_id'] ?>','');">เลือก</button>
                <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                <?php } else if ($job_type == 2) { ?>
                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row['customer_id'] ?>');">เลือก</button>
                <?php } ?>
            </td>

        </tr>
        <?php } ?>
    </tbody>
    <?php } elseif ($search_type == 2) { ?>

    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:5%;" class="text-left">Serial No</th>
            <th style="width:27%;" class="text-left">เครื่อง</th>
            <th style="width:13%;" class="text-center">ประเภท</th>
            <th style="width:20%;" class="text-center">ชื่อร้าน</th>
            <th style="width:20%;" class="text-center">ลูกค้า</th>
            <!-- <th class="text-center">เบอร์</th> -->

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {


                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);


                $product_detail = $row_brand['brand_name'] . " " . $row_model['model_name'];

                if ($search_type == 1) {
                    $branch_id = $row['current_branch_id'];
                } else {
                    $branch_id = $row['branch_care_id'];
                }

                ?>
        <tr>
            <td>
                <?php echo ++$i; ?>
            </td>
            <td class="text-left">
                <?php echo $row['serial_no'] ?>
            </td>
            <td class="text-left">
                <?php echo $product_detail ?>
            </td>
            <td class="text-center">
                <?php echo $row['type_code'] . " - " . $row['type_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row['branch_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row['customer_name'] . "</br> tel:" . $row['phone'] ?>
            </td>



            <td>
                <?php if ($job_type == 1|| $job_type == 7) { ?>
                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_CM_Product('<?php echo $row['product_id'] ?>');">เลือก</button>
                <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                <?php } else if ($job_type == 2) { ?>
                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_PM_Product('<?php echo $row['product_id'] ?>','<?php echo $row['customer_id'] ?>');">เลือก</button>
                <?php } ?>
            </td>

        </tr>
        <?php } ?>
    </tbody>

    <?php } elseif ($search_type == 3) { ?>

    <thead>
        <tr>
        <th style="width:5%;">#</th>
            <th style="width:5%;" class="text-left">Serial No</th>
            <th style="width:27%;" class="text-left">เครื่อง</th>
            <th style="width:13%;" class="text-center">ประเภท</th>
            <th style="width:20%;" class="text-center">ชื่อร้าน</th>
            <th style="width:20%;" class="text-center">ลูกค้า</th>
            <!-- <th class="text-center">เบอร์</th> -->

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {


                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);


                $product_detail = $row_brand['brand_name'] . " " . $row_model['model_name'];

                if ($search_type == 1) {
                    $branch_id = $row['current_branch_id'];
                } else {
                    $branch_id = $row['branch_care_id'];
                }

                ?>
        <tr>
            <td>
                <?php echo ++$i; ?>
            </td>
            <td class="text-left">
                <?php echo $row['serial_no'] ?>
            </td>
            <td class="text-left">
                <?php echo $product_detail ?>
            </td>
            <td class="text-center">
                <?php echo $row['type_code'] . " - " . $row['type_name'] ?>
            </td>

            <td class="text-center">
                <?php echo "[ " . $row['branch_code'] . " ] - " . $row['branch_name'] ?>
            </td>
            <td class="text-center">
                <?php echo $row['customer_name'] . "</br> tel:" . $row['phone'] ?>
            </td>


            <td>

                <button class="btn btn-xs btn-primary btn-block" type="button"
                    onclick="Choose_CM_Product('<?php echo $row['product_id'] ?>');">เลือก</button>

            </td>

        </tr>
        <?php } ?>
    </tbody>

    <?php } ?>
</table>