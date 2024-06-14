<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$sql = "SELECT a.*,b.fullname FROM tbl_business_group a 
LEFT JOIN tbl_user b ON a.create_user_id = b.user_id";
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $temp_array = array(
        "group_id" => $row['group_id'],
        "customer_name" => $row['group_name'],
        "tax_no" => $row['tax_no'],
        "invoice_name" => $row['invoice_name'],
        "invoice_address" => $row['invoice_address'],
        "phone" => $row['phone'],
        "email" => $row['email'],
        "create_datetime" => date("d-m-Y", strtotime($row['create_datetime'])),
        "fullname" => $row['fullname'],
        "active_status" => $row['active_status']
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:15%;"></th>
            <th style="width:15%;">หมายเลขผู้เสียภาษี</th>
            <th style="width:20%;">รายละเอียด</th>
            <th class="text-center" style="width:13%;">การบันทึก</th>
            <th class="text-center" style="width:10%;">สถานะ</th>
            <th style="width:10%;"></th>
        </tr>
    </thead>
    <tbody>
        <?php
        $i = 0;
        foreach ($list as $row) {
        ?>
            <tr>
                <td><?php echo ++$i; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['tax_no']; ?></td>
                <td><?php echo $row['invoice_name']." ( ".$row['phone']." )"."<br/>".$row['email']."<br/>".$row['invoice_address']; ?></td>
                <td class="text-center"><?php echo $row['fullname']."<br/>".$row['create_datetime']; ?></td>
                <td><button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus('<?php echo $row['group_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button></td>
                <td>

                    <button class="btn btn-xs btn-warning btn-block" type="button" onclick="ModalEdit('<?php echo $row['group_id']; ?>')">
                        แก้ไขข้อมูล
                    </button>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>