<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$customer_branch_id = $_POST['customer_branch_id'];


?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:2%;">#</th>
            <th style="width:12%;" class="text-left">Serial No</th>
            <th style="width:13%;" class="text-center">ยี่ห้อ</th>
            <th style="width:21%;" class="text-center">รุ่น</th>
            <th style="width:15%;" class="text-center">ประเภท</th>
            <th style="width:12%;" class="text-center">การรับประกัน</th>
            <th style="width:15%;" class="text-center">ประเภทการรับประกัน</th>

            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        $sql = "SELECT *,a.active_status as product_status FROM tbl_product a 
        LEFT JOIN tbl_product_type b ON a.product_type = b.type_id
         WHERE a.current_branch_id ='$customer_branch_id' ORDER BY a.create_datetime";
        $result  = mysqli_query($connect_db, $sql);
        while ($row = mysqli_fetch_array($result)) {

            $product_id = $row['product_id'];
            $brand_id = $row['brand_id'];
            $sql_brand = "SELECT * FROM tbl_product_brand WHERE brand_id = '$brand_id'";
            $result_brand  = mysqli_query($connect_db, $sql_brand);
            $row_brand = mysqli_fetch_array($result_brand);

            $model_id = $row['model_id'];
            $sql_model = "SELECT * FROM tbl_product_model WHERE model_id = '$model_id'";
            $result_model  = mysqli_query($connect_db, $sql_model);
            $row_model = mysqli_fetch_array($result_model);

            $sql_care = "SELECT a.*, (a.branch_id) AS id,b.*,(b.branch_name) AS b_name  FROM tbl_branch a 
LEFT JOIN tbl_customer_branch b ON a.branch_id = b.branch_care_id WHERE b.branch_care_id = '$branch_id'";
            $result_care  = mysqli_query($connect_db, $sql_care);
            $row_care = mysqli_fetch_array($result_care);

            if ($row['warranty_expire_date'] == null) {
                $warranty = "ไม่มีข้อมูล";
            } else {

                $now = strtotime("today");
                $expire_date = strtotime($row['warranty_expire_date']);
                $datediff = $expire_date - $now;

                $days_remain = round($datediff / (60 * 60 * 24));
                if ($days_remain <= 0) {
                    $total_remain = "<font color=red>" . "หมดอายุ " . "</font>";
                } else {
                    $total_remain = "เหลือ " . $days_remain . " วัน";
                }
                $warranty = date("d-m-Y", strtotime($row['warranty_expire_date'])) . "<br>" . $total_remain;
            }

            if ($row['warranty_type'] == 1) {
                $warranty_text = 'ซื้อจากบริษัท';
            } else  if ($row['warranty_type'] == 2) {
                $warranty_text = 'ไม่ได้ซื้อจากบริษัท';
            } else if ($row['warranty_type'] == 3) {
                $warranty_text = 'สัญญาบริการ';
            }
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td class="text-left"><?php echo $row['serial_no']; ?></td>
                <td class="text-center"><?php echo $row_brand['brand_name']; ?></td>
                <td class="text-center"><?php echo $row_model['model_name']; ?></td>
                <td class="text-center"><?php echo $row['type_code'] . " - " . $row['type_name']; ?></td>
                <td class="text-center"><?php echo $warranty; ?></td>
                <td class="text-center"><?php echo $warranty_text; ?></td>

                <td>
                    <button class="btn btn-xs btn-block <?php echo ($row['product_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['product_id']; ?>')">
                        <?php echo ($row['product_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                    <button class="btn btn-xs btn-warning btn-block" onclick="ModalEdit('<?php echo $product_id ?>');">แก้ไข</button>
                    <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-success btn-block">รายละเอียด</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>