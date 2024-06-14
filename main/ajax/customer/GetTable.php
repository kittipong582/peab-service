<?php
include("../../../config/main_function.php");

$connect_db = connectDB("LM=VjfQ{6rsm&/h`");

$list = array();

$search_type  = $_POST['search_type'];
$search  = $_POST['search'];

$condition = "";
if ($search_type == "1" && $search != "") {
    $condition = "WHERE customer_code LIKE '%$search%'";
}

if ($search_type == "2" && $search != "") {
    $condition = "WHERE customer_name LIKE '%$search%'";
}


if ($search_type == "3" && $search != "") {
    $condition = "WHERE phone LIKE '%$search%'";
}


$sql = "SELECT * FROM tbl_customer $condition";
$result  = mysqli_query($connect_db, $sql);
while ($row = mysqli_fetch_array($result)) {

    $customer_id = $row['customer_id'];

    switch ($row['customer_type']) {
        case '1':
            $customer_type = "นิติบุคคล";
            break;
        case '2':
            $customer_type = "บุคคลธรรมดา";
            break;
    }

    $sql_brance = "SELECT COUNT(*) AS count_brance FROM tbl_customer_branch WHERE customer_id = '$customer_id'";
    $result_brance  = mysqli_query($connect_db, $sql_brance);
    $row_brance = mysqli_fetch_array($result_brance);

    $count_brance = $row_brance['count_brance'];

    $temp_array = array(
        "customer_id" => $row['customer_id'],
        "customer_code" => $row['customer_code'],
        "customer_name" => $row['customer_name'],
        "customer_type" => $customer_type,
        "tax_no" => $row['tax_no'],
        "phone" => $row['phone'],
        "email" => $row['email'],
        "count_brance" => $count_brance,
        "active_status" => $row['active_status'],
    );

    array_push($list, $temp_array);
}

?>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <th style="width:5%;">#</th>
            <th style="width:10%;" class="text-center">รหัสลูกค้า</th>
            <th class="text-left">ชื่อลูกค้า</th>
            <th class="text-left" style="width:20%;">การติดต่อ</th>
            <th style="width:13%;" class="text-center">ประเภทลูกค้า</th>
            <th style="width:10%;" class="text-center">จำนวนสาขา</th>
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
                <td class="text-center"><?php echo ++$i; ?></td>
                <td class="text-center"><?php echo $row['customer_code']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td>
                    <?php echo ($row['phone'] != "") ? "<i class='fa fa-phone'></i> : " . $row['phone'] . "<br>" : ''; ?>
                    <?php echo ($row['email'] != "") ? "<i class='fa fa-envelope'></i> : " . $row['email'] : ''; ?>
                </td>
                <td class="text-center"><?php echo $row['customer_type']; ?></td>
                <td class="text-center"><?php echo $row['count_brance']; ?></td>
                <td class="text-center">
                    <button class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>" onclick="ChangeStatus(this,'<?php echo $row['customer_id']; ?>')">
                        <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                    </button>
                </td>
                <td>
                    <!-- <button
                    class="btn btn-xs btn-block <?php echo ($row['active_status'] == 1) ? 'btn-info' : 'btn-danger'; ?>"
                    onclick="ChangeStatus(this,'<?php echo $row['customer_id']; ?>')">
                    <?php echo ($row['active_status'] == 1) ? 'กำลังใช้งาน' : 'ยกเลิกใช้งาน'; ?>
                </button> -->
                    <a href="customer_view_detail.php?id=<?php echo $row['customer_id']; ?>" class="btn btn-xs btn-info btn-block">ดูข้อมูล</a>
                </td>
            </tr>
        <?php } ?>
    </tbody>
</table>