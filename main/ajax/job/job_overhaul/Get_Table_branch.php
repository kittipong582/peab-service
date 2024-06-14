<?php
include("../../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];
$search_value2 = $_POST['search_value2'];
// echo $search_type;
$active = "AND c.active_status = 1";
if ($search_type == 1) {
    $sql = "SELECT * FROM tbl_product c
    LEFT JOIN tbl_product_type e ON e.type_id = c.product_type
      WHERE c.serial_no LIKE '%$search_value%' $active";
    $result  = mysqli_query($connect_db, $sql);
} else if ($search_type == 2) {
    
        $condition = "WHERE d.customer_name LIKE '%$search_value%' OR d.customer_code LIKE '%$search_value%' GROUP BY b.customer_branch_id";

    $sql = "SELECT * FROM  tbl_customer_branch b 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
} elseif ($search_type == 3) {

    $condition = "WHERE b.branch_code LIKE '%$search_value%' OR b.branch_name LIKE '%$search_value%' GROUP BY b.customer_branch_id";

    $sql = "SELECT b.*,c.branch_name AS team_name,b.branch_name AS b_name,d.customer_id as cus_id,d.customer_name FROM tbl_customer_branch b 
    LEFT JOIN tbl_customer d ON d.customer_id = b.customer_id
    LEFT JOIN tbl_branch c ON  b.branch_care_id = c.branch_id
    $condition";
    $result  = mysqli_query($connect_db, $sql);
}

// echo $sql;
?>


<table id="tbl_OH" class="table table-striped table-bordered table-hover">
    <?php if ($search_type == 1) {; ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th class="text-left">Serial No</th>
                <th  style="width:20%;"class="text-left">เครื่อง</th>
                <th  style="width:10%;"class="text-center">ประเภท</th>
                <th class="text-center">ชื่อร้าน</th>
                <th class="text-center">ลูกค้า</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($result)) {


                
                $brand_id = $row['brand_id'];
                $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
                $result_brand  = mysqli_query($connect_db, $sql_brand);
                $row_brand = mysqli_fetch_array($result_brand);

                $model_id = $row['model_id'];
                $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
                $result_model  = mysqli_query($connect_db, $sql_model);
                $row_model = mysqli_fetch_array($result_model);


                $product_detail = $row_brand['brand_name']." ".$row_model['model_name'];

                $branch_id = $row['current_branch_id'];


                $sql_branch = "SELECT *FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id WHERE a.customer_branch_id = '$branch_id'";
                $result_branch = mysqli_query($connect_db, $sql_branch);
                $row_branch = mysqli_fetch_array($result_branch);
                $product_type = $row['type_code'] . " - " . $row['type_name'];

            ?>
                <tr>
                    <td><?php echo ++$i; ?></td>
                    <td class="text-left"><?php echo $row['serial_no'] ?></td>
                    <td class="text-left"><?php echo $product_detail ?></td>
                    <td class="text-center"><?php echo $product_type ?></td>
                    <td class="text-center"><?php echo $row_branch['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row_branch['customer_name'] ?></td>
                    

                    <td>
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_OH_Product('<?php echo $row['product_id'] ?>','<?php echo $row_branch['customer_branch_id'] ?>');">เลือก</button>
                        <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->

                    </td>

                </tr>
            <?php } ?>
        </tbody>
    <?php } elseif ($search_type == 2) {
    ?>

        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th style="width:25%;" class="text-center">ชื่อร้าน</th>
                <th style="width:25%;" class="text-center">รหัสลูกค้า</th>
                <th style="width:25%;" class="text-center">ลูกค้า</th>
                <th class="text-center">เบอร์</th>
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
                    <td><?php echo ++$i; ?></td>

                    <td class="text-center"><?php echo "[".$row['branch_code']."] - ".$row['branch_name'] ?></td>
                    <td class="text-center"><?php echo $row['customer_code'] ?></td>
                    <td class="text-center"><?php echo $row['customer_name'] ?></td>
                    <td class="text-center"><?php echo $row['phone'] ?></td>

                    <td>
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_customer('<?php echo $row['cus_id'] ?>','<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                        <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                    </td>

                </tr>
            <?php } ?>
        </tbody>




    <?php } else if ($search_type == 3) { ?>


        <thead>
            <tr>
                <th style="width:10%;">#</th>
                <th  style="width:25%;" class="text-center">ชื่อร้าน</th>
                <th style="width:25%;" class="text-center">ลูกค้า</th>
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
                        <button class="btn btn-xs btn-primary btn-block" type="button" onclick="Choose_customer('<?php echo $row['cus_id'] ?>','<?php echo $row['customer_branch_id'] ?>');">เลือก</button>
                        <!-- <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-info btn-block">รายละเอียด</a> -->
                    </td>

                </tr>
            <?php } ?>
        </tbody>

    <?php   } ?>

</table>