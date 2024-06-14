<?php

include("../../../config/main_function.php");



$connect_db = connectDB("LM=VjfQ{6rsm&/h`");



$search_type = $_POST['search_type'];

$text_search = $_POST['text_search'];

$search_brand = $_POST['search_brand'];

$search_model = $_POST['search_model'];



$type = "";

$condition3 = "";



if ($search_type == 1) {

    $type = 'a.serial_no';

} else if ($search_type == 2) {

    $type = 'b.branch_code';

} else if ($search_type == 3) {

    $type = 'b.branch_name';

} else if ($search_type == 4) {

    $type = 'c.customer_code';

} else if ($search_type == 5) {

    $type = 'c.customer_name';

}





if ($text_search != "") {

    $condition3 .= "AND $type LIKE  '%$text_search%'";

}



if ($search_brand != "") {

    $condition3 .= "AND brand_id =  '$search_brand'";

}





if ($search_model != "") {

    $condition3 .= "AND model_id =  '$search_model'";

}





$i = 0;

$sql = "SELECT a.*,d.*,b.branch_name,b.branch_code FROM tbl_product a

        LEFT JOIN tbl_customer_branch b ON a.current_branch_id = b.customer_branch_id

        LEFT JOIN tbl_customer c ON b.customer_id = c.customer_id

        LEFT JOIN tbl_product_type d ON a.product_type = d.type_id

        WHERE a.active_status = 1  $condition3 ORDER BY a.create_datetime";

$result  = mysqli_query($connect_db, $sql);


?>



<table class="table table-striped table-bordered table-hover">

    <thead>

        <tr>

            <th style="width:2%;">#</th>

            <th style="width:8%;" class="text-left">Serial No</th>

            <th style="width:20%;" class="text-center">เครื่อง</th>

            <th style="width:10%;" class="text-center">สาขาปัจจุบัน</th>

            <th style="width:10%;" class="text-center">การรับประกัน</th>

            <th style="width:10%;" class="text-center">ประเภทการรับประกัน</th>

            <th style="width:5%;" class="text-center">สถานะ</th>

            <th style="width:10%;"></th>

        </tr>

    </thead>

    <tbody>

        <?php



        // echo $sql;

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

                <td class="text-left"><?php echo "<b>ยี่ห้อ:</b> " . $row_brand['brand_name'] . "<br/> <b>รุ่น:</b> " . $row_model['model_name']; ?><br><?php echo  "<b>ประเภท:</b> " . $row['type_code'] . " - " . $row['type_name']; ?></td>

                <td class="text-center"><?php echo $row['branch_code']." - ".$row['branch_name'] ?></td>

                <td class="text-center"><?php echo $warranty; ?></td>

                <td class="text-center"><?php echo $warranty_text; ?></td>

                <td class="text-center">



                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['product_id']; ?>')">

                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>

                    </button>

                </td>

                <td>

                    <!-- <button class="btn btn-xs btn-warning btn-block" onclick="ModalEdit('<?php echo $product_id ?>');">แก้ไข</button> -->

                    <a href="product_view_detail.php?id=<?php echo $product_id ?>" class="btn btn-xs btn-success btn-block">รายละเอียด</a>

                </td>

            </tr>

        <?php } ?>

    </tbody>

</table>