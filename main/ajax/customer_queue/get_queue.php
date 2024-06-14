<?php
@include ("../../../config/main_function.php");
$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$search_value = $_POST['search_value'];
$search_type = $_POST['search_type'];

$sql = "SELECT * FROM tbl_customer_queue ORDER BY queue_no ASC";
$res = mysqli_query($connect_db, $sql);

?>
<div class="table-responsive">
    <table id="tbl_queue" class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th style="width:10%;">คิวงาน</th>
                <th class="">สาขา</th>
                <th class="">ภาค</th>
                <th style="width:10%;"></th>
            </tr>
        </thead>
        <tbody>
            <?php $i = 0;
            while ($row = mysqli_fetch_array($res)) {
                $sql_customer = "SELECT * FROM tbl_customer_branch a
                LEFT JOIN tbl_customer b ON a.customer_id = b.customer_id 
                WHERE a.customer_branch_id  = '{$row['customer_branch_id']}'";
                $res_customer = mysqli_query($connect_db, $sql_customer);
                $row_customer = mysqli_fetch_array($res_customer);

                ?>
                <tr>
                    <td>
                        <?php echo ++$i; ?>
                    </td>
                    <td class="">
                        <b>ชื่อลูกค้า : </b>
                        <?php echo ($row_customer['customer_name']) != NULL || ($row_customer['customer_name'] != '') ? $row_customer['customer_name'] : '-' ?>
                        <br>
                        <b>เบอร์ : </b>
                        <?php echo ($row_customer['phone']) != NULL || ($row_customer['phone'] != '') ? $row_customer['phone'] : '-' ?>
                        <br>
                        <b>สาขา : </b>
                        <?php echo ($row_customer['branch_code']) != NULL || ($row_customer['branch_code'] != '') ? $row_customer['branch_code'] : '-' ?>
                        <?php echo ($row_customer['branch_name']) != NULL || ($row_customer['branch_name'] != '') ? $row_customer['branch_name'] : '-' ?>
                        <br>
                    </td>
                    <?php

                    $sql_area = "SELECT * FROM tbl_zone_oh WHERE area_id = '{$row['area_id']}' AND active_status = 1";
                    $res_area = mysqli_query($connect_db, $sql_area) or die($connection->error);
                    $row_area = mysqli_fetch_assoc($res_area);
                    ?>
                    <td>
                        <?php echo $row_area['area_name'] ?>
                    </td>
                    <td>
                        <a href="form_add_job.php?code=<?php echo $row_customer['branch_code'] ?>&id=<?php echo $row_customer['customer_branch_id'] ?>&job_type=4"
                            class="btn btn-xs btn-primary btn-block">เปิดงาน
                        </a>
                        <button class="btn btn-xs btn-warning btn-block" type="button"
                            onclick="Modal_edit('<?php echo $row['queue_id'] ?>');">แก้ไข</button>
                        <button class="btn btn-xs btn-danger btn-block" type="button"
                            onclick="Delete_queue('<?php echo $row['customer_branch_id'] ?>');">ลบคิวงาน</button>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>