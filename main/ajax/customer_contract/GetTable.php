<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");
$customer_id = $_POST['customer_id'];

$sql = "SELECT *  FROM tbl_customer_contract a
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id WHERE customer_id = '$customer_id' AND cancel_date is NULL order by create_datetime";
$result  = mysqli_query($connect_db, $sql);
?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:15%;" class="text-center">เลขที่สัญญา</th>
            <th class="text-left">ผู้ทำรายการ</th>
            <th class="text-left">วันที่เริ่มสัญญา</th>
            <th class="text-left">วันที่หมดสัญญา</th>
            <th class="text-left" style="width:20%;">หมายเหตุ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;

        while ($row = mysqli_fetch_array($result)) {


        ?>
            <tr>
                <td class="text-center"><?php echo $row['contract_number']; ?></td>
                <td><?php echo $row['fullname']; ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['start_contract_date'])); ?></td>
                <td><?php echo date('d-m-Y', strtotime($row['end_contract_date'])); ?> </td>
                <td><?php echo $row['remark']; ?></td>
                <td>
                    <div class="form-group">
                        <button type="button" onclick="modal_edit_contract('<?php echo $row['contract_id']; ?>')" class="btn btn-warning btn-block btn-xs"> แก้ไขสัญญา</button>
                        <button type="button" onclick="modal_cancel('<?php echo $row['contract_id']; ?>')" class="btn btn-danger btn-block btn-xs"> ยกเลิก</button>
                    </div>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>